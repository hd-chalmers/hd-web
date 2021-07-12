import { eventType } from '../interfaces'
import Events from '../__generated__/events'
import ApiCall from '../apiCallClass'

export class events extends ApiCall{
  processName = 'Events'
  async run (): Promise<void> {

    this.app.get('/events', async (req, res) =>{
      const events: Events[] = await this.db.query(this.sql`SELECT * FROM events WHERE date > now()
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
