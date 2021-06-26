import ApiCall from '../interfaces'
import { Express } from 'express'
import { ConnectionPool } from '@databases/pg'
import { SQL } from '@databases/sql'
import bcrypt from 'bcrypt'
import Users from '../__generated__/users'

export class login implements ApiCall{
  processName = 'Login'

  async run (app: Express, db: ConnectionPool, sql: SQL): Promise<void> {
    app.post('/login', async (req, res) =>{
      const email = req.body.email
      const password = req.body.password
      const accounts: Users[] = await db.query(sql`SELECT email, password FROM users WHERE email = ${email}`)
      console.log('[API] ' + this.processName + ' got a post request with argument ' + email)

      if(accounts[0] == undefined){
        console.log('[API] email not found')
        res.json({error: 'invalid credentials'})
        return
      }

      // Convert password hash version to 2b if it's not the default type
      if(accounts[0].password.charAt(2) === 'y' || accounts[0].password.charAt(2) === 'd'){
        accounts[0].password = '$2b' + accounts[0].password.substr(3)
        console.log('[Warn] Converted password hash version to 2b')
      }

      const verify = await bcrypt.compare(password, accounts[0].password)
      if(verify){
        console.log('[API] Login success')
        res.json({status: 'success'})
      }
      else{
        console.log('[API] password mismatch')
        res.json({error: 'invalid credentials'})
      }
    })
    return Promise.resolve(undefined);
  }

}
