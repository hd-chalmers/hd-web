import express from 'express';
import db, {sql} from './src/database'
import { routes } from './src/routes'
import Cors from 'cors'
import expressSession, { MemoryStore } from 'express-session'
import expressFileUpload from 'express-fileupload'

const app = express()
const PORT = 8000
app.use(Cors())
app.use(express.urlencoded({extended: true}))
app.use(express.json())
app.use(expressFileUpload({
  createParentPath: true,
  debug: true,
  safeFileNames: true,
  preserveExtension: true
}))
app.use('/static',express.static('./storage/public'))
export const store = new MemoryStore()
app.use(expressSession({
  secret: 'hd',
  resave: false,
  saveUninitialized: true,
  cookie: {
    httpOnly: true,
    sameSite: 'strict',
    secure: false
  },
  store: store
}))

app.use((req, res, next) => {
  res.setHeader('Content-Type', 'application/json')
  res.setHeader('X-Powered-By', 'HD-API')
  next()
})

app.get('/', (req, res) => res.send('Api is running'))
app.listen(PORT, () => {
  console.log(`⚡️[server]: Server is running at http://localhost:${PORT}`)
})

for (const route of routes){
  const promise = route.run(app, db, sql)
  promise.then(() =>{
    console.log('[API] ' + route.processName + ' was initialized')
  })
}
