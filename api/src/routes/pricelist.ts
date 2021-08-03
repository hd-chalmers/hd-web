import ApiCall from "../apiCallClass";
import {categories, products} from "../database";

export class priceList extends ApiCall{
  processName = 'Pricelist'

  async run(): Promise<void> {
    this.app.get('/pricelist', async (req, res) => {
      const groups: any[] = await categories(this.db).find().select('id', 'name').orderByAsc('name').all()
      for (const category of groups){
        category.products = await products(this.db).find({category_id: category.id, active: true}).select('id', 'name', 'price').orderByAsc('name').all()
      }

      res.json({categories: groups})
    })
    return Promise.resolve(undefined);
  }
}
