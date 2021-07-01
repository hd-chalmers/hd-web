import ApiCall from '../../interfaces'
import { Express } from 'express'
import { ConnectionPool } from '@databases/pg'
import { SQL } from '@databases/sql'
import { barcodes, categories, products } from '../../database'
import Products from '../../__generated__/products'

export class loehkPrices implements ApiCall{
  processName = 'Loehk Prices'

  async run (app: Express, db: ConnectionPool, sql: SQL): Promise<void> {
    app.get('/loehk/prices', async (req, res) =>{
      const items =  await products(db).find().all() as any[]
      for(const item of items){
        item.barcodes = await barcodes(db).find({product_id: item.id}).all()
          .catch(err => console.log(err))
        item.combobox_barcodes = [] as string[]
        for(const barcode of item.barcodes){
          item.combobox_barcodes.push(`${barcode.variant_name? barcode.variant_name + '=' : ''}${barcode.barcode}`)
        }

        item.category = await categories(db).findOne({id: item.category_id})
          .catch(err => console.log(err))
        item.category_name = item.category.name
      }

      const categoryArr = await categories(db).find().all()
        .catch(err => console.log(err))

      res.json({
        products: items,
        categories: categoryArr
      })
    })

    app.put('/loehk/prices', async (req, res) => {
      if(!req.query.itemId){
        res.status(400).send()
        console.log('Id is missing')
        return
      }
      const id: number = parseInt(<string> req.query.itemId, 10)

      const productData = req.body
      const comboboxBarcodes: string[] = productData.combobox_barcodes

      // Change format for usage in database
      delete productData.combobox_barcodes
      delete productData.barcodes
      delete productData.category_name
      delete productData.category
      delete productData.axfood
      productData.updated_at = new Date()

      await products(db).update({id}, productData)
        .catch(err => console.log(err))
      console.log('Updated product ' + id)

      const existingCodes = await barcodes(db).find({product_id: id}).all()
      for(const barcodeStr of comboboxBarcodes){
        // Parse barcode
        let code: string, name : string | null
        if(barcodeStr.includes('=')){
          const split = barcodeStr.split('=', 2)
          name = split[0]
          code = split[1]
        }
        else{
          code = barcodeStr
          name = null
        }

        // Check if barcode is already in database and update it's entry. Also removes the matched entry in array
        let match = false
        for(const index in existingCodes){
          if (existingCodes[index].barcode === code){
            await barcodes(db).update({id: existingCodes[index].id}, {barcode: code, variant_name: name})
              .catch(err => console.log(err))
            console.log('Updated barcode ' + existingCodes[index].barcode)
            existingCodes.splice(parseInt(index), 1)
            match = true
            break
          }
        }

        // Add any barcodes that didn't have an match
        if(!match){
          await barcodes(db).insertOrIgnore({
            product_id: id,
            barcode: code,
            variant_name: name,
            created_at: new Date(),
            updated_at: new Date()
          })
            .catch(err => console.log(err))
          console.log('Added barcode '+ code)
        }
      }

      // Remove any unmatched barcodes from the database
      for (const leftover of existingCodes){
        await barcodes(db).delete({id: leftover.id})
          .catch(err => console.log(err))
        console.log('Removed barcode ' + leftover.barcode)
      }
    })

    app.post('/loehk/prices', async (req, res) => {
      const productData = req.body
      const barcodeArr: string[] = productData.barcodes

      // format for database insertion
      delete productData.barcodes
      delete productData.category_name
      delete productData.category
      delete productData.axfood
      delete productData.valid
      productData.created_at = new Date()
      productData.updated_at = new Date()

      const newEntry = await products(db).insert(productData)
        .catch(err => console.log(err))
      console.log('Added product ' + productData.name)

      for(const barcodeStr of barcodeArr){
        // Parse barcode
        let code: string, name : string | null
        if(barcodeStr.includes('=')){
          const split = barcodeStr.split('=', 2)
          name = split[0]
          code = split[1]
        }
        else{
          code = barcodeStr
          name = null
        }

        barcodes(db).insert({
          product_id: (<Products[]><unknown>newEntry)[0].id,
          barcode: code,
          variant_name: name
        })
        console.log('Added barcode ' + code)
      }
      res.send()
    })

    app.delete('/loehk/prices', async (req, res) => {
      const id: number = req.body.itemId
      if(typeof id != 'number' || isNaN(id)){
        console.log('missing id')
        res.status(400).send()
      }

      console.log('Deleted product ' + id)
      await barcodes(db).delete({product_id: id})
        .catch(err => console.log(err))
      await products(db).delete({id})
        .catch(err => console.log(err))

      res.send()
    })
    return Promise.resolve(undefined);
  }

}
