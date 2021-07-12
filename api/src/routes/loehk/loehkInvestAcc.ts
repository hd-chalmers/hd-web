import { accounts, purchase_histories, purchase_history_products } from '../../database'
import Accounts from '../../__generated__/accounts'
import ApiCall from '../../apiCallClass'

export class loehkInvestAcc extends ApiCall{
  processName = 'Loehk Investment Accounts'

  async run (): Promise<void> {
    this.app.get('/loehk/investments', async (req, res) =>{
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

      const active = await accounts(this.db).find({active: true}).all() as any[]
      const inactive = await accounts(this.db).find({active: false}).all() as any[]

      for(const account of active){
        account.active_text = 'Aktiv'
      }
      for(const account of inactive){
        account.active_text = 'Inaktiv'
      }

      res.json({active, inactive})
    })

    this.app.put('/loehk/investments', async (req, res) => {
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

      const id: number = parseInt(<string> req.query.accountId, 10)
      if(id === undefined || isNaN(id)){
        console.log('missing id')
        res.status(400).send()
      }

      const accountData = req.body
      delete accountData.active_text
      delete accountData.id
      delete accountData.balance
      accountData.updated_at = new Date()

      // Check if account has become inactive
      const currentAcc = await accounts(this.db).findOne({id})
      if(accountData.active !== currentAcc?.active && accountData.active === false){
        accountData.inactive_since = new Date()
      }

      this.log('Updated account ' + id)
      const updatedAcc = await accounts(this.db).update({id}, accountData)
        .catch(err => console.log(err))

      if(updatedAcc) {
        (<any> updatedAcc[0]).active_text = updatedAcc[0].active ? 'Aktiv' : 'Inaktiv'
        res.json(updatedAcc[0])
      }
      else {
        res.status(422).send()
      }
    })

    this.app.post('/loehk/investments', async (req, res) => {
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

      const accountData = req.body

      delete accountData.print
      accountData.balance = 0
      accountData.active = true
      accountData.created_at = new Date()
      accountData.updated_at = new Date()
      if(!accountData.password){
        accountData.password = ''
      }

      this.log('Adding investment account ' + accountData.uid)
      const newEntry = await accounts(this.db).insertOrIgnore(accountData)
        .catch(err => this.error(err, err))
      if(newEntry) {
        const entryObj: any = (<Accounts[]>newEntry)[0]
        entryObj.active_text = '!Nytt!'

        res.json(entryObj)
      }
      else {
        res.status(422).send()
      }
    })

    this.app.delete('/loehk/investments', async (req, res) => {
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

      const id: number = req.body.accountId
      if(id == undefined || isNaN(id)){
        res.status(400).send()
      }

      const purchases = await purchase_histories(this.db).find({account_id: id}).all()
      for(const entry of purchases){
        console.log('Deleteing history products: ' + entry.id)
        await purchase_history_products(this.db).delete({purchase_history_id: entry.id})
          .catch(err => console.log(err))
      }
      console.log('Deleting histories for account ' + id)
      await purchase_histories(this.db).delete({account_id: id})
        .catch(err => console.log(err))
      console.log('Deleting account ' + id)
      await accounts(this.db).delete({id})
        .catch(err => console.log(err))

      res.send()
    })
    return Promise.resolve(undefined);
  }
}
