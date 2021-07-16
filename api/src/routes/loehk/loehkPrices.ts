import { barcodes, categories, products } from '../../database'
import ApiCall from '../../apiCallClass'

export class loehkPrices extends ApiCall{
  processName = 'Loehk Prices'

  async run (): Promise<void> {
    this.app.get(process.env.API_PATH + '/loehk/prices', async (req, res) =>{
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

      const items =  await products(this.db).find().all() as any[]
      for(const item of items){
        item.barcodes = await barcodes(this.db).find({product_id: item.id}).all()
          .catch(err => console.log(err))
        item.combobox_barcodes = [] as string[]
        for(const barcode of item.barcodes){
          item.combobox_barcodes.push(`${barcode.variant_name? barcode.variant_name + '=' : ''}${barcode.barcode}`)
        }

        item.category = await categories(this.db).findOne({id: item.category_id})
          .catch(err => console.log(err))
        item.category_name = item.category.name
      }

      const categoryArr = await categories(this.db).find().all()
        .catch(err => console.log(err))

      res.json({
        products: items,
        categories: categoryArr
      })
    })

    this.app.put(process.env.API_PATH + '/loehk/prices', async (req, res) => {
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

      if(!req.query.itemId){
        res.status(400).send()
        this.error('Id is missing')
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

      const updatedEntry = await products(this.db).update({id}, productData)
        .catch((err: Error) => this.error(err.message, err.stack))

        if(updatedEntry) {
          this.log('Updated product ' + id)
          const existingCodes = await barcodes(this.db).find({ product_id: id }).all()

          for (const barcodeStr of comboboxBarcodes) {
            // Parse barcode
            let code: string, name: string | null
            if (barcodeStr.includes('=')) {
              const split = barcodeStr.split('=', 2)
              name = split[0]
              code = split[1]
            } else {
              code = barcodeStr
              name = null
            }

            // Check if barcode is already in database and update it's entry. Also removes the matched entry in array
            let match = false
            for (const index in existingCodes) {
              if (existingCodes[index].barcode === code) {
                await barcodes(this.db).update({ id: existingCodes[index].id }, {
                  barcode: code,
                  variant_name: name
                })
                  .catch(err => this.error(err))
                this.log('Updated barcode ' + existingCodes[index].barcode)
                existingCodes.splice(parseInt(index), 1)
                match = true
                break
              }
            }

            // Add any barcodes that didn't have an match
            if (!match) {
              await barcodes(this.db).insertOrIgnore({
                product_id: id,
                barcode: code,
                variant_name: name,
                created_at: new Date(),
                updated_at: new Date()
              })
                .catch((err: Error) => this.error(err.message, err.stack))
              this.log('Added barcode ' + code)
            }
          }

          // Remove any unmatched barcodes from the database
          for (const leftover of existingCodes) {
            barcodes(this.db).delete({ id: leftover.id })
              .then(() => this.log('Removed barcode ' + leftover.barcode))
              .catch((err: Error) => this.error(err.message, err.stack))
          }
          res.send()

          this.redisClient.aDel('loehkFront')
            .catch((err: Error) => this.error(err.message, err.stack))
        }
      else {
        res.status(422).send()
        }
    })

    this.app.post(process.env.API_PATH + '/loehk/prices', async (req, res) => {
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

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

      const newEntry = await products(this.db).insert(productData)
        .catch((err: Error) => this.error(err.message, err.stack))

      if(newEntry) {
        this.log('Added product ' + productData?.name)

        for (const barcodeStr of barcodeArr) {
          // Parse barcode
          let code: string, name: string | null
          if (barcodeStr.includes('=')) {
            const split = barcodeStr.split('=', 2)
            name = split[0]
            code = split[1]
          } else {
            code = barcodeStr
            name = null
          }

          barcodes(this.db).insert({
            product_id: newEntry[0].id,
            barcode: code,
            variant_name: name
          })
            .then(() => {
              this.log('Added barcode ' + code)
            })
            .catch((err) => {
              this.error(err)
            })
        }
        res.send()

        this.redisClient.aDel('loehkFront')
          .catch((err: Error) => this.error(err.message, err.stack))
      }
      else {
        res.status(422).send()
      }
    })

    this.app.delete(process.env.API_PATH + '/loehk/prices', async (req, res) => {
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

      const id: number = req.body.itemId
      if(id === undefined || isNaN(id)){
        console.log('missing id')
        res.status(400).send()
      }

      await barcodes(this.db).delete({product_id: id})
        .catch(err => console.log(err))
      await products(this.db).delete({id})
        .catch(err => console.log(err))
      this.log('Deleted product ' + id)

      res.send()

      this.redisClient.aDel('loehkFront')
        .catch((err: Error) => this.error(err.message, err.stack))
    })
    return Promise.resolve(undefined);
  }

}
