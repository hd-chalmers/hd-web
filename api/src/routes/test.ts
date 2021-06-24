import ApiCall from '../interfaces'
import { Express } from 'express'
import {ConnectionPool} from '@databases/pg'
import {SQL} from '@databases/sql'
import Accounts from '../__generated__/accounts'

export class test implements ApiCall{
  processName = 'test'
  async run (app: Express, db: ConnectionPool, sql: SQL): Promise<void> {

    app.get('/test', async (req, res) =>{
      console.log('[API] ' + this.processName + ' was accessed')
      const strecklista: Accounts[] = await db.query(sql`SELECT * FROM accounts;`)
      res.send({strecklista})
    })

    return Promise.resolve(undefined);
  }
}
