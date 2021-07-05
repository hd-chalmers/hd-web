import ApiCall from '../../interfaces'
import { Express } from 'express'
import { ConnectionPool } from '@databases/pg'
import { SQL } from '@databases/sql'
import { active_years, committee_members } from '../../database'
import CommitteeMembers from '../../__generated__/committee_members'
import { UploadedFile } from 'express-fileupload'

export class loehkActiveYearMembers implements ApiCall{
  processName = 'Loehk Active Year Members'

  async run (app: Express, db: ConnectionPool, sql: SQL): Promise<void> {
    app.patch('/loehk/active_year/committee_members', async (req, res) => {
      const member = req.body as CommitteeMembers

      const id: number = parseInt(<string> req.query.memberId)
      if(id !== undefined && !isNaN(id) ){
        member.id = id
      }

      member.updated_at = new Date()

      let updatedMember
      if(member.id){
        console.log('Updated committee member ' + member.id)
        updatedMember = await committee_members(db).update({id: member.id}, member)
          .catch(err => console.log(err))
      }
      else {
        if (!member.name){
          member.name = 'Mr. Okänd'
        }
        if (!member.role){
          member.role = 'Okänd roll'
        }
        member.created_at = new Date()

        console.log('Inserted committee member ' + member.name)
        updatedMember = await committee_members(db).insert(member)
          .catch(err => console.log(err))
      }

      if(req.files?.image){
        const year = await active_years(db).findOne({id: member.active_year_id})
          .catch(err => console.log(err))
        const file = req.files.image as UploadedFile
        await file.mv(`./storage/public/${year?.year.getFullYear()}/members/${(<any>updatedMember)[0]?.name}`)
        const image = `http://localhost:8000/static/${year?.year.getFullYear()}/members/${(<any>updatedMember)[0]?.name}`
        committee_members(db).update({id: (<any>updatedMember)[0].id},{image})
          .catch(err => console.log(err))
      }

      res.json((<any>updatedMember)[0])
    })

    app.delete('/loehk/active_year/committee_members', async (req, res) =>{
      const id: number = req.body.id
      if(!id || isNaN(id)){
        res.status(400).send()
        return
      }

      console.log('deleting committee member ' + id)
      await committee_members(db).delete({id})
        .catch(err => console.log(err))

      res.send()
    })
    return Promise.resolve(undefined);
  }

}
