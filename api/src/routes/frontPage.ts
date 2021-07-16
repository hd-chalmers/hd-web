import Events from '../__generated__/events'
import ActiveYears from '../__generated__/active_years'
import ApiCall from '../apiCallClass'

export class frontPage extends ApiCall{
  processName = 'Front-page'
  async run (): Promise<void> {
    this.app.get(process.env.API_PATH + '/frontpage', async (req, res) =>{
      if(await this.redisClient.aExist('frontpage')){
        res.setHeader('Content-Type', 'application/json')
        res.send(await this.redisClient.aGet('frontpage'))
        return
      }

      const eventList: Events[] = await this.db.query(this.sql`SELECT title, date FROM events
            WHERE date > now() AND show_on_frontpage=true ORDER BY date LIMIT 1;`)
      const yearList: ActiveYears[] = await this.db.query(this.sql`SELECT front_image, christmas_image FROM
            active_years ORDER BY year DESC LIMIT 1`)
      if(!eventList[0]){
        (<any> eventList[0]) = {title: null, date: null}
      }
      const today = new Date()
      if ((today.getDate() == 24 || today.getDate() == 25) && today.getMonth() == 11){
        yearList[0].front_image = yearList[0].christmas_image ?? yearList[0].front_image
      }

      if(!yearList[0]?.front_image){
        this.warn('Frontpage image was not specified, using default image instead')
      }

      const result = {
        frontpageImg: yearList[0].front_image,
        event: {
          title: eventList[0].title,
          date: eventList[0].date
        }
      }
      res.json(result)

      this.redisClient.aSet('frontpage', JSON.stringify(result))
        .then(() => {
          this.log('Set new cache')
          // Expire after a month
          this.redisClient.aExpire('frontpage', 2628000)
            .catch((err: Error) => this.error(err.message, err.message))
        })
        .catch((err: Error) => this.error(err.message, err.stack))
    })

    return Promise.resolve(undefined);
  }

}
