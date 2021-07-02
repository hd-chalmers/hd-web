import ApiCall from '../../interfaces'
import { Express } from 'express'
import { ConnectionPool } from '@databases/pg'
import { SQL } from '@databases/sql'
import { accounts, purchase_histories, purchase_history_products } from '../../database'
import Accounts from '../../__generated__/accounts'

export class loehkInvestAcc implements ApiCall{
  processName = 'Loehk Investment Accounts'

  async run (app: Express, db: ConnectionPool, sql: SQL): Promise<void> {
    app.get('/loehk/investments', async (req, res) =>{
      const active = await accounts(db).find({active: true}).all() as any[]
      const inactive = await accounts(db).find({active: false}).all() as any[]

      for(const account of active){
        account.active_text = 'Aktiv'
      }
      for(const account of inactive){
        account.active_text = 'Inaktiv'
      }

      res.json({active, inactive})
    })

    app.put('/loehk/investments', async (req, res) => {
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
      const currentAcc = await accounts(db).findOne({id})
      if(accountData.active !== currentAcc?.active && accountData.active === false){
        accountData.inactive_since = new Date()
      }

      console.log('Updated account ' + id)
      await accounts(db).update({id}, accountData)
        .catch(err => console.log(err))

      res.send()
    })

    app.post('/loehk/investments', async (req, res) => {
        const accountData = req.body

      delete accountData.print
      accountData.balance = 0
      accountData.active = true
      accountData.created_at = new Date()
      accountData.updated_at = new Date()

      console.log('Added investment account ' + accountData.uid)
      const newEntry = await accounts(db).insertOrIgnore(accountData)
        .catch(err => console.log(err))
        const entryObj: any = (<Accounts[]>newEntry)[0]
      entryObj.active_text = '!Nytt!'

      res.json(entryObj)
    })

    app.delete('/loehk/investments', async (req, res) => {
      const id: number = req.body.accountId
      if(id == undefined || isNaN(id)){
        res.status(400).send()
      }

      const purchases = await purchase_histories(db).find({account_id: id}).all()
      for(const entry of purchases){
        console.log('Deleteing history products: ' + entry.id)
        await purchase_history_products(db).delete({purchase_history_id: entry.id})
          .catch(err => console.log(err))
      }
      console.log('Deleting histories for account ' + id)
      await purchase_histories(db).delete({account_id: id})
        .catch(err => console.log(err))
      console.log('Deleting account ' + id)
      await accounts(db).delete({id})
        .catch(err => console.log(err))

      res.send()
    })
    return Promise.resolve(undefined);
  }
}
