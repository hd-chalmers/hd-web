import ApiCall from '../interfaces'
import { Express } from 'express'
import { ConnectionPool } from '@databases/pg'
import { SQL } from '@databases/sql'
import Events from '../__generated__/events'
import ActiveYears from '../__generated__/active_years'

export default class frontPage implements ApiCall{
  processName = 'Front-page'
  async run (app: Express, db: ConnectionPool, sql: SQL): Promise<void> {
    app.get('/frontpage', async (req, res) =>{
      console.log('[API] ' + this.processName + ' was accessed')

      const eventList: Events[] = await db.query(sql`SELECT title, date FROM events
            WHERE date > now() AND show_on_frontpage=true ORDER BY date LIMIT 1;`)
      const yearList: ActiveYears[] = await db.query(sql`SELECT front_image, christmas_image FROM
            active_years ORDER BY year DESC LIMIT 1`)
      if(!eventList[0]){
        // @ts-ignore
        eventList[0] = {title: null, date: null}
      }
      const today = new Date()
      if ((today.getDate() == 24 || today.getDate() == 25) && today.getMonth() == 11){
        yearList[0].front_image = yearList[0].christmas_image ?? yearList[0].front_image
      }

      res.json({
        frontpageImg: yearList[0].front_image,
        event: {
          title: eventList[0].title,
          date: eventList[0].date
        }
      })
    })

    return Promise.resolve(undefined);
  }

}
