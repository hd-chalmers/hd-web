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
import AsyncRedisClient from './src/asyncRedisClient'

const asyncRedis = new AsyncRedisClient({
  host: 'localhost',
  port: 49153
})
const app = express()
const PORT = 8000
app.use(morgan(
  'combined',
  {
    stream: fs.createWriteStream('./storage/logs/httpRequests.log')
}))
app.use(morgan( LogStyle.bg.white + LogStyle.fg.black
  + `:date[iso] | :method | :url ${LogStyle.reset} Status :status, :response-time ms, http :http-version & :req[content-type]`))
app.use(Cors())
app.use(express.urlencoded({extended: true}))
app.use(express.json())
app.use(expressFileUpload({
  createParentPath: true,
  debug: false,
  safeFileNames: true,
  preserveExtension: true
}))
app.use('/static',express.static('./storage/public'))
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
app.listen(PORT, () => {
  console.log(LogStyle.bg.green + LogStyle.fg.black + new Date().toISOString() +
    ` | Server ${LogStyle.reset} Server is running at http://localhost:${PORT}`)
})

for (const route of routes){
  new route(app, db, sql, asyncRedis)
}
