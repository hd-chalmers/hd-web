import ApiCall from '../apiCallClass'
import { accounts } from '../database'

export class print extends ApiCall{
  processName = "Print"

  async run (): Promise<void> {
    this.app.get(process.env.API_PATH + '/loehk/investments/print', async (req, res) => {
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

      const active = await accounts(this.db).find({print: true, active: true}).select('uid', 'name').orderByAsc('uid').all()
      const inactive = await accounts(this.db).find({print: true, active: false}).select('uid', 'name').orderByAsc('uid').all()
      const last = await accounts(this.db).count()

      res.json({active, last: last + parseInt(<string>process.env.PRINT_STRECK_MODIFIER) , inactive})
    })
    return Promise.resolve(undefined);
  }

}
