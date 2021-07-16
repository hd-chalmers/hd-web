import { eventType } from '../interfaces'
import Events from '../__generated__/events'
import ApiCall from '../apiCallClass'

export class events extends ApiCall{
  processName = 'Events'
  async run (): Promise<void> {

    this.app.get(process.env.API_PATH + '/events', async (req, res) =>{
      if(await this.redisClient.aExist('events')){
        res.setHeader('Content-Type', 'application/json')
        res.send(await this.redisClient.aGet('events'))
        return
      }

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
      this.redisClient.aSet('events', JSON.stringify(formattedEvents))
        .then(() => {
          this.log('Set new cache')
          // Expire after a month
          this.redisClient.aExpire('events', 2628000)
            .catch((err: Error) => this.error(err.message, err.message))
        })
        .catch((err: Error) => this.error(err.message, err.stack))
    })

    return Promise.resolve(undefined);
  }
}
