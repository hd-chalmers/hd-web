import { Express } from 'express'
import { ConnectionPool} from '@databases/pg'
import {SQL} from '@databases/sql'

export default interface ApiCall{
  processName: string
  run(app: Express, db: ConnectionPool, sql: SQL): Promise<void>
}

export interface eventType {
  id: number
  title: string
  description: string
  location: string
  facebookLink: string
  date: Date
}

export interface memberType{
  id: number
  name: string
  role: string
  profilePic: string
  quote: string
  description: string
  favouriteGame: string
  favouriteSugar: string
}
