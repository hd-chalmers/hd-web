import ApiCall from '../../interfaces'
import { Express, Request } from 'express'
import { ConnectionPool } from '@databases/pg'
import { SQL, SQLQuery } from '@databases/sql'
import Users from '../../__generated__/users'
import Products from '../../__generated__/products'
import Accounts from '../../__generated__/accounts'
import { Session, SessionData } from 'express-session'
import { store } from '../../../app'
import Events from '../../__generated__/events'

// noinspection TypeScriptUnresolvedFunction
export class loehkFrontpage implements ApiCall{
  processName = 'Loehk Frontpage'

  async run (app: Express, db: ConnectionPool, sql: SQL): Promise<void> {
    app.get('/loehk/front', async (req, res) => {
      console.log('[API] ' + this.processName + ' was accessed')
//      if (await this.validate(db, sql, req)) {
        const productCount = await  db.query(sql`SELECT count(id) AS count FROM products`)
        const updatedProducts: Products[] = await db.query(sql`SELECT name, updated_at FROM products ORDER BY updated_at DESC LIMIT 1;`)
        const latestProduct: Products[] = await db.query(sql`SELECT name, created_at FROM products ORDER BY created_at DESC LIMIT 1;`)

        const accountCount = await db.query(sql`SELECT count(id) FROM accounts`)
        const latestAccount: Accounts[] = await db.query(sql`SELECT uid, name, created_at FROM accounts ORDER BY created_at DESC LIMIT 1;`)
        const updatedAccount: Accounts[] = await db.query(sql`SELECT uid, name, updated_at FROM accounts ORDER BY updated_at DESC LIMIT 1;`)

        const eventCount = await  db.query(sql`SELECT count(id) FROM events`)
        const latestEvent: Events[] = await db.query(sql`SELECT title, created_at, date FROM events ORDER BY created_at DESC  LIMIT 1`)
        const updatedEvent: Events[] = await db.query(sql`SELECT title, updated_at, date FROM events ORDER BY updated_at DESC LIMIT 1`)

        const gameCount =  await db.query(sql`SELECT count(id) FROM games`)
        const latestGame = await db.query(sql`SELECT games.name, games.created_at, gp.name AS platform FROM games
                            JOIN game_platforms gp on games.game_platform_id = gp.id ORDER BY games.created_at DESC LIMIT 1`)
        const updatedGame = await db.query(sql`SELECT games.name, games.updated_at, gp.name AS platform FROM games
                            JOIN game_platforms gp on games.game_platform_id = gp.id ORDER BY games.updated_at DESC LIMIT 1`)

        res.json({
            products: productCount[0].count,
            product_updated: updatedProducts[0] ? {
              name: updatedProducts[0].name,
              updated_at: updatedProducts[0].updated_at
            } : null,
            product_latest: latestProduct[0] ? {
              name: latestProduct[0].name,
              created_at: latestProduct[0].created_at
            } : null,
            investment_accounts: accountCount[0].count,
            investment_latest: latestAccount[0] ? {
              uid: latestAccount[0].uid,
              name: latestAccount[0].name,
              created_at: latestAccount[0].created_at
            } : null,
            investment_updated: updatedAccount ? {
              uid: updatedAccount[0].uid,
              name: updatedAccount[0].name,
              updated_at: updatedAccount[0].updated_at
            } : null,
            events: eventCount[0].count,
            event_latest: latestEvent[0] ? {
              title: latestEvent[0].title,
              created_at: latestEvent[0].created_at,
              date: latestEvent[0].date
            } : null,
            event_updated: updatedEvent[0] ? {
              title: updatedEvent[0].title,
              updated_at: updatedEvent[0].updated_at,
              date: updatedEvent[0].date
            } : null,
            games: gameCount[0].count,
            games_latest: latestGame[0] ? {
              name: latestGame[0].name,
              created_at: latestGame[0].created_at,
              platform: latestGame[0].platform,
            } : null,
            games_updated: updatedGame[0] ? {
              name: updatedGame[0].name,
              updated_at: updatedGame[0].updated_at,
              platform: updatedGame[0].platform,
            } : null
          })
      /*} else {
        res.status(403).json({ error: 'unauthorized' })
      }*/
    })
    return Promise.resolve(undefined);
  }

  async getSingleDBEntry(query: SQLQuery, db:ConnectionPool, returnOnUndefined?: any): Promise<any>{
    const value = await db.query(query)
    if(value[0] === undefined){
      return Promise.resolve(returnOnUndefined ?? {})
    }
    else{
      return Promise.resolve(value[0])
    }
  }

  async validate(db: ConnectionPool, sql: SQL, req: Request): Promise<boolean>{
     const session = this.getSession(req)
    console.log(session)
    if(session.login){
      const tokens: Users[] = await db.query(sql`SELECT api_token FROM users WHERE api_token = ${session.login}`)
      if(tokens[0] === undefined){
        console.log('[API] token mismatch')
        return Promise.resolve(false)
      }
    }
    else{
      console.log('[API] session does not exist')
      return Promise.resolve(false)
    }
    return Promise.resolve(true)
  }

  getSession(req:Request): (Session & Partial<SessionData>){
    if(req.body.session){
      console.log('Id used ' + req.body.session)
      // eslint-disable-next-line @typescript-eslint/ban-ts-comment
      // @ts-ignore
      return store.get(req.body.session, () => console.log('There was en error looking for session'))
    }

      return req.session
  }

}
