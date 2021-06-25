import ApiCall, { eventType } from '../interfaces'
import { Express } from 'express'
import { ConnectionPool } from '@databases/pg'
import { SQL } from '@databases/sql'
import Events from '../__generated__/events'

export class events implements ApiCall{
  processName = 'Events'
  async run (app: Express, db: ConnectionPool, sql: SQL): Promise<void> {

    app.get('/events', async (req, res) =>{
      console.log('[API] ' + this.processName + ' was accessed')
      const events: Events[] = await db.query(sql`SELECT * FROM events WHERE date > now()
                       AND show_on_frontpage = true ORDER BY date`)

      const formattedEvents: eventType[] = [];

      for (const event of events){
        formattedEvents.push(<eventType>{
          id: event.id,
          title: event.title,
          description: event.description,
          location: event.location,
          facebookLink: event.facebook_event_link,
          date: event.date
        })
      }

      res.json(formattedEvents)
    })

    return Promise.resolve(undefined);
  }
}
