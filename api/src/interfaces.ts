import { Express } from 'express'
import { ConnectionPool} from '@databases/pg'
import {SQL} from '@databases/sql'

export default interface ApiCall{
  processName: string
  run(app: Express, db: ConnectionPool, sql: SQL): Promise<void>
}
