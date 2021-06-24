import express from 'express';
import db, {sql} from './src/database'
import { routes } from './src/routes'
import Cors from 'cors'

const app = express()
const PORT = 8000
app.use(Cors())
app.use(express.urlencoded({extended: true}))
app.use(express.json())
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
