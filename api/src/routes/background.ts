import ApiCall from '../interfaces'
import { Express } from 'express'
import { ConnectionPool } from '@databases/pg'
import { SQL } from '@databases/sql'
import ActiveYears from '../__generated__/active_years'

export class background implements ApiCall{
  processName = 'Background'

  async run (app: Express, db: ConnectionPool, sql: SQL): Promise<void> {
    app.get('/background', async(req, res)=>{
      console.log('[API] ' + this.processName + ' was accessed')
      const yearlist: ActiveYears[] = await db.query(sql`SELECT background_image FROM active_years WHERE background_image NOTNULL ORDER BY year DESC LIMIT 1`)
      res.json(yearlist[0].background_image)
    })
    return Promise.resolve(undefined);
  }

}
