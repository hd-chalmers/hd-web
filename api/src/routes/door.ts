import ApiCall from '../apiCallClass'
import { users } from '../database'

export class door extends ApiCall{
  processName = 'Door'
  updatedAt = new  Date()
  status: boolean|null = null

  async run (): Promise<void> {
    this.app.get(process.env.API_PATH + '/door', async (req, res) => {
      const timeDiff = Math.round(Math.abs(new Date().getTime() - this.updatedAt.getTime()) / 1000)
      res.json({
        updated: this.updatedAt.toLocaleString('se-SV'),
        status: this.status,
        duration: timeDiff,
        duration_str: await this.toRelativeTimeStr(timeDiff)
      })
    })

    this.app.put(process.env.API_PATH + '/door', async (req, res) => {
      if (req.body.api_token){
        const tokens = await users(this.db).findOne({api_token: req.body.api_token})
          .catch((err: Error) => this.error(err.message, err.stack))
        if(!tokens){
          this.warn('token was invalid')
          res.status(403).send()
          return
        }
      }
      else {
        this.warn('token was missing')
        res.status(400).send()
        return
      }

      const status: number = req.body.status
      if(status === undefined || isNaN(status)){
        this.warn('format of status is invalid')
        res.status(400).send()
        return
      }

      this.status = status > 0
      this.updatedAt = new Date()
      this.log('door was set to ' + this.status)

      res.status(202).send()
    })
    return Promise.resolve(undefined);
  }

  // Creates a relative date string from a unixtimestamp
  async toRelativeTimeStr(unixTimestamp: number): Promise<string>{
    if(isNaN(unixTimestamp)){
      return Promise.reject('Is NaN')
    }

    let result = ''
    let interval = Math.floor(unixTimestamp / 2592000)
    if (interval) {
      unixTimestamp %= 2592000
      result += ' ' + interval + (interval > 1 ? "månader" : ' månad')
    }
    interval = Math.floor(unixTimestamp / 86400)
    if (interval) {
      unixTimestamp %= 86400
      result += ' ' + interval + (interval > 1 ? " dagar" : ' dag')
    }
    interval = Math.floor(unixTimestamp / 3600)
    if (interval) {
      unixTimestamp %= 3600
      result += ' ' + interval + (interval > 1 ? " timmar" : ' timme')
    }
    interval = Math.floor(unixTimestamp / 60)
    if (interval) {
      unixTimestamp %= 60
      result += ' ' + interval + (interval > 1 ? " minuter" : ' minut')
    }
    if(unixTimestamp) {
      result += ' ' + unixTimestamp + (unixTimestamp > 1 ? " sekunder" : ' sekund')
    }
    return  Promise.resolve(result.trimStart())
  }
}
