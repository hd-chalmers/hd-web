import ActiveYears from '../__generated__/active_years'
import ApiCall from '../apiCallClass'

export class background extends ApiCall{
  processName = 'Background'

  async run (): Promise<void> {
    this.app.get(process.env.API_PATH + '/background', async(req, res)=>{
      if(await this.redisClient.aExist('background')){
        res.setHeader('Content-Type', 'application/json')
          res.send(await this.redisClient.aGet('background'))
        return
      }

      const yearlist: ActiveYears[] = await this.db.query(this.sql`SELECT background_image FROM active_years WHERE background_image NOTNULL ORDER BY year DESC LIMIT 1`)
      res.json(yearlist[0]?.background_image)
      this.redisClient.aSet('background', JSON.stringify(yearlist[0]?.background_image))
        .then(() => {
          this.log('Set new cache')
          // expire after a month
          this.redisClient.aExpire('background', 2628000)
            .catch((err: Error) => this.error(err.message, err.message))
        })
        .catch((err: Error) => this.error(err.message, err.stack))
    })
    return Promise.resolve(undefined);
  }

}
