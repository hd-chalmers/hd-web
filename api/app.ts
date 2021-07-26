import dotenv from 'dotenv'
dotenv.config()

import express from 'express';
import db, {sql} from './src/database'
import { routes } from './src/routes'
import Cors from 'cors'
import expressFileUpload from 'express-fileupload'
import { LogStyle } from './src/logStyles'
import morgan from 'morgan'
import fs from 'fs'
import AsyncRedisClient from './src/declarations/asyncRedisClient'

const asyncRedis = new AsyncRedisClient({
  host: process.env.REDIS_URL,
  port: parseInt(<string>process.env.REDIS_PORT)
})
const app = express()
if(!fs.existsSync('./storage/logs')) {
  fs.mkdirSync('./storage/logs', {recursive: true})
  fs.writeFileSync('./storage/logs/httpRequests.log', '')
}
    app.use(morgan(
      'combined',
      {
        stream: fs.createWriteStream('./storage/logs/httpRequests.log')
      }))
app.use(morgan( LogStyle.bg.white + LogStyle.fg.black
  + ` :date[iso] | :method | :url ${LogStyle.reset} Status :status, :response-time ms, http :http-version & :req[content-type]`,
  {
    skip (req, res): boolean {
      return req.url === process.env.API_PATH + '/door' && res.statusCode < 400
    }
  }))
app.use(Cors())
app.use(express.urlencoded({extended: true}))
app.use(express.json())
app.use(expressFileUpload({
  createParentPath: true,
  debug: false,
  safeFileNames: true,
  useTempFiles: true,
  tempFileDir: 'storage/temp',
  abortOnLimit: true,
  limits: {
    fileSize: 10 * 1024 * 1024 * 1024 //10MB max file(s) size
  }
}))
app.use(<string>process.env.STATIC_PATH,express.static('./storage/public'))
/*
app.use(expressSession({
  secret: 'hd',
  resave: false,
  saveUninitialized: true,
  cookie: {
    httpOnly: true,
    sameSite: 'strict',
    secure: false
  }
}))
*/

app.use((req, res, next) => {
  res.setHeader('Content-Type', 'application/json')
  res.setHeader('X-Powered-By', 'HD-API')
  next()
})

app.get('/', (req, res) => res.send('Api is running'))
app.listen(parseInt(<string>process.env.API_PORT), () => {
  console.log(LogStyle.bg.green + LogStyle.fg.black + ' ' + new Date().toISOString() +
    ` | Server ${LogStyle.reset} Server is running at ` + process.env.API_FULL_URL)
})

for (const route of routes){
  new route(app, db, sql, asyncRedis)
}
