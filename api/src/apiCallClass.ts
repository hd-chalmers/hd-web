import { Express } from 'express'
import { ConnectionPool } from '@databases/pg'
import { SQL } from '@databases/sql'
import { LogStyle } from './logStyles'
import fs from 'fs'
import AsyncRedisClient from './asyncRedisClient'
import { users } from './database'


export default abstract class ApiCall {
  constructor (app: Express, db: ConnectionPool, sql: SQL, redis: AsyncRedisClient) {
    this.app = app
    this.db = db
    this.sql = sql
    this.redisClient = redis

    this.run()
      .then(() => this.log(this.processName + ' was initialised'))
      .catch(() => this.log(this.processName + ' had an error initializing'))
  }
  abstract processName: string
  redisClient: AsyncRedisClient
  app: Express
  db: ConnectionPool
  sql: SQL

  abstract run (): Promise<void>

  async verify(id: string): Promise<boolean>{
    const token = await this.redisClient.aGet(id)
      .catch(err => this.error(err))
    if(token){
      const dbEntry = await users(this.db).findOne({api_token: token})
        .catch(err => this.error(err?.message, err))
      const match = token === dbEntry?.api_token
      return Promise.resolve(match)
    }
    return Promise.resolve(false)
  }

  // Write info styled in console and in log file
  log(message: string): void{
    const date = new Date().toISOString()
    // Write to console
    console.info(LogStyle.bg.blue + LogStyle.fg.black + `${date} | ${this.processName} ` + LogStyle.reset + ' ' + message)

    // Write to log file
    fs.appendFile('./storage/logs/general.log',
      `[${date} | Info | ${this.processName}] ` + message + '\n',
      (err) => {
      if(err) {
        console.log(LogStyle.fg.red + err + LogStyle.reset)
      }
    })
  }

  // Write a warning styled in console and in log file
  warn(message: string): void{
    const date = new Date().toISOString()
    // Write styled message to console
    console.warn(
      LogStyle.bg.yellow + LogStyle.fg.black
      + `${date} | ⚠ ️${this.processName} ` + LogStyle.reset + LogStyle.bright
      + ' ' + message + LogStyle.reset
    )

    // Write to log file
    fs.appendFile('./storage/logs/general.log',
      `[${date} | Warn | ${this.processName}] ` + message + '\n',
      (err) => {
        if(err) {
          console.log(LogStyle.fg.red + err + LogStyle.reset)
        }
      })
  }

  // Write an error message styled in console and in log files
  error(message: string, stacktrace?: string): void{
    const date = new Date().toISOString()
    // Write to console
    console.error(
      LogStyle.bg.red + `${date} | ☠ ${this.processName} ` + LogStyle.reset + ' '
      + LogStyle.bright + LogStyle.fg.red + message + LogStyle.reset
    )

    // Write to general log
    fs.appendFile(
      './storage/logs/general.log',
      `[${date} | Error | ${this.processName}] ` + message + '\n',
      (err) => {
        if(err){
          console.log(LogStyle.fg.red + err + LogStyle.reset)
        }
      })

    // Write to error log
    fs.appendFile(
      './storage/logs/errors.log',
      `[${date} | API | ${this.processName}] ` + message + '\n'
        + (stacktrace? stacktrace + '\n' : ''),
      (err => {
        if(err){
          console.log(LogStyle.fg.red + message + LogStyle.reset)
        }
      }))
  }
}
