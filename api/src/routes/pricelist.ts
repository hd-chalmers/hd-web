import ApiCall from "../apiCallClass";
import {categories, products} from "../database";

export class priceList extends ApiCall{
  processName = 'Pricelist'

  async run(): Promise<void> {
    this.app.get('/pricelist', async (req, res) => {
      if(await this.redisClient.aExist('pricelist')){
        res.setHeader('Content-Type', 'application/json')
        res.send(await this.redisClient.aGet('pricelist'))
        return
      }

      const groups: any[] = await categories(this.db).find().select('id', 'name').orderByAsc('name').all()
      for (const category of groups){
        category.products = await products(this.db).find({category_id: category.id, active: true}).select('id', 'name', 'price').orderByAsc('name').all()
      }

      const result = JSON.stringify({ categories: groups})
      res.send(result)
      this.redisClient.aSet('pricelist', result)
        .then(() => {
          this.log('Set new cache')
          // Expire after a month
          this.redisClient.aExpire('pricelist', 2628000)
            .catch((err: Error) => this.error(err.message, err.message))
        })
        .catch((err: Error) => this.error(err.message, err.stack))
    })
    return Promise.resolve(undefined);
  }
}
