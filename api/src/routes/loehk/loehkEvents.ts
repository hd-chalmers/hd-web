import ApiCall from '../../interfaces'
import { Express } from 'express'
import { ConnectionPool } from '@databases/pg'
import { SQL } from '@databases/sql'
import Events from '../../__generated__/events'
import { events } from '../../database'

export class loehkEvents implements ApiCall{
  processName = 'Loehk Events'

  async run (app: Express, db: ConnectionPool, sql: SQL): Promise<void> {
    app.put('/loehk/events', async (req, res) => {

      if(!req.query.eventId){
        console.log('missing id')
        res.status(400).send()
        return
      }
      const id = parseInt(<string> req.query.eventId, 10)

      // since this is a for-in loop item contains the key/index instead of value
      for(const item in req.body){

        console.log(`[API] Property ${item} was changed in an event with id ${id}`)
        let temp

        switch (item){
          case 'date':
            temp = await db.query(sql`SELECT date FROM events WHERE id = ${id};`) as Events[]
            await db.query(sql`UPDATE events SET date = ${req.body[item] + ' ' + temp[0].date.toLocaleTimeString('se-SV', {hour: '2-digit', minute: '2-digit'})},
                  updated_at = current_timestamp WHERE id = ${id};`)
              .catch((err) => console.log(err))
            break;

          case 'time':
            temp = await db.query(sql`SELECT to_char(date, 'YYYY-MM-DD ') AS date FROM events WHERE id = ${id};`) as Events[]
            await db.query(sql`UPDATE events SET date = ${temp[0].date + req.body[item]}, updated_at = current_timestamp WHERE id = ${id};`)
              .catch((err) => console.log(err))
            break;

          case 'title':
          case 'description':
          case 'location':
          case 'poster':
          case 'show_on_frontpage':
          case 'google_event_id':
          case 'facebook_event_link':

            temp = {updated_at: new Date()}
            // eslint-disable-next-line @typescript-eslint/ban-ts-comment
            // @ts-ignore
            temp[item] = req.body[item]

            events(db).update({id: id}, temp)
             .catch((err) => console.log(err))
            break;

          default:
            console.log('invalid key')
            res.status(400).send()
            return
        }
      }
      res.send()
    })

    app.get('/loehk/events', async (req, res) => {
      const events: Events[] = await db.query(sql`SELECT id, title, description, location, poster, show_on_frontpage, google_event_id, facebook_event_link,
                                to_char(events.date, 'HH24:MI') AS time, to_char(events.date, 'YYYY-MM-DD') AS date FROM events`)

      res.json(events)
    })

    app.post('/loehk/events', async (req, res) => {
      const eventObj = req.body
      if(eventObj.time){
        eventObj.date += ' ' + eventObj.time
        delete eventObj.time
      }
      eventObj.updated_at = new Date()
      eventObj.created_at = new Date()

      await events(db).insertOrIgnore(eventObj)
        .catch((err) =>{
          console.log(err)
          res.status(400).send()
          return
        })
      console.log('[API] New event added')
      const result: Events[] = await db.query(sql`SELECT id, title, description, location, poster, show_on_frontpage, google_event_id, facebook_event_link,
                                to_char(events.date, 'HH24:MI') AS time, to_char(events.date, 'YYYY-MM-DD') AS date FROM events ORDER BY id DESC LIMIT 1`)
      res.json(result[0])
    })

    app.delete('/loehk/events', async (req, res) => {
      if(!req.body.id){
        res.status(400).send()
        return
      }

      await events(db).delete({id: req.body.id})
        .catch((err) => {
          console.log(err)
          res.status(400).send()
          return
        })
      console.log(`[API] Removed event with id ` + req.body.id)
      res.send()
    })

    return Promise.resolve(undefined);
  }

}
