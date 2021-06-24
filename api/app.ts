import express from 'express';
import db, {sql} from './src/database'
import { routes } from './src/routes'

const app = express()
const PORT = 8000
app.get('/', (req, res) => res.send('Api is running'))
app.listen(PORT, () => {
  console.log(`⚡️[server]: Server is running at https://localhost:${PORT}`)
})

for (const route of routes){
  const promise = route.run(app, db, sql)
  promise.then(() =>{
    console.log('[API] ' + route.processName + ' was initialized')
  })
}
