import ActiveYears from '../__generated__/active_years'
import ApiCall from '../apiCallClass'

export class background extends ApiCall{
  processName = 'Background'

  async run (): Promise<void> {
    this.app.get(process.env.API_PATH + '/background', async(req, res)=>{
      const yearlist: ActiveYears[] = await this.db.query(this.sql`SELECT background_image FROM active_years WHERE background_image NOTNULL ORDER BY year DESC LIMIT 1`)
      res.json(yearlist[0]?.background_image)
    })
    return Promise.resolve(undefined);
  }

}
