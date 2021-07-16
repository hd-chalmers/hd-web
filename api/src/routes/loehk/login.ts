import bcrypt from 'bcrypt'
import Users from '../../__generated__/users'
import ApiCall from '../../apiCallClass'
import crypto from 'crypto'

export class login extends ApiCall {
  processName = 'Login'

  async run (): Promise<void> {
    this.app.post(process.env.API_PATH + '/login', async (req, res) => {
      const email = req.body.email
      const password = req.body.password
      const accounts: Users[] = await this.db.query(this.sql`SELECT email, password, api_token
                                                   FROM users WHERE email = ${email}`)

      if (accounts[0] == undefined) {
        res.json({ error: 'invalid credentials' })
        return
      }

      // Convert password hash version to 2b if it's not the default type
      if (accounts[0].password.charAt(2) === 'y' || accounts[0].password.charAt(2) === 'd') {
        accounts[0].password = '$2b' + accounts[0].password.substr(3)
        this.warn('Converted password hash version to 2b')
      }

      const verify = await bcrypt.compare(password, accounts[0].password)
      if (verify) {
        const hash = crypto.randomBytes(32).toString('hex')
        await this.redisClient.aSet(hash, <string> accounts[0].api_token)
          .catch((err) => this.warn(err.message))
          .then(async (check) => {
            if(check){
              await this.redisClient.aExpire(hash, 10800)
                .catch((err) => this.warn(err.message))
            }
          })
        res.json({ status: 'success', sessionId: hash})
      } else {
        res.status(401).json({ error: 'invalid credentials' })
      }
    })

    this.app.delete(process.env.API_PATH + '/logout', async (req, res) => {
      if(!req.header('sessionId')){
        res.sendStatus(400)
        return
      }
      const id = req.header('sessionId');

      (<any>this.redisClient.aDel)(id)
        .then(() => this.log(id + ' was logged out'))
        .catch((err: Error) => this.error(err.message, err.stack))
        .finally(() => res.sendStatus(205))
    })
  }
}
