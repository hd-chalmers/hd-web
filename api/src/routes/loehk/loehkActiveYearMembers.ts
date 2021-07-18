import { active_years, committee_members } from '../../database'
import CommitteeMembers from '../../__generated__/committee_members'
import { UploadedFile } from 'express-fileupload'
import ApiCall from '../../apiCallClass'

export class loehkActiveYearMembers extends ApiCall{
  processName = 'Loehk Active Year Members'

  async run (): Promise<void> {
    this.app.patch(process.env.API_PATH + '/loehk/active_year/committee_members', async (req, res) => {
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

      const member = req.body as CommitteeMembers

      const id: number = parseInt(<string> req.query.memberId)
      if(id !== undefined && !isNaN(id) ){
        member.id = id
      }

      member.updated_at = new Date()

      let updatedMember
      if(member.id){
        updatedMember = await committee_members(this.db).update({id: member.id}, member)
          .catch(err => console.log(err))
        this.log('Updated committee member ' + member.id)
      }
      else {
        if (!member.name) {
          member.name = 'Mr. Okänd'
        }
        if (!member.role) {
          member.role = 'Okänd roll'
        }
        member.created_at = new Date()

        updatedMember = await committee_members(this.db).insert(member)
          .catch(err => console.log(err))
        this.log('Inserted committee member ' + member.name)
      }

      if(req.files?.image){
        const year = await active_years(this.db).findOne({id: member.active_year_id})
          .catch((err: Error) => this.error(err.message, err.stack))
        const file = req.files.image as UploadedFile

        if(file.size > 10 * 1000000){
          res.sendStatus(422)
          return
        }

        await this.processImage(file, `./storage/public/${year?.year.getFullYear()}/members/${(<any>updatedMember)[0]?.name}_`)
          .catch((err) => {
            this.error(err)
            res.sendStatus(415)
          })
        if(res.statusCode >= 400){
          return
        }

        const image = `${<string>process.env.API_FULL_URL + process.env.STATIC_PATH}/${year?.year.getFullYear()}/members/${(<any>updatedMember)[0]?.name}_${file.name}.webp`
        updatedMember = await committee_members(this.db).update({id: (<any>updatedMember)[0].id},{image})
          .catch((err: Error) => this.error(err.message, err.stack))
      }

      res.json((<any>updatedMember)[0])

      this.redisClient.aDel('committee')
        .catch((err: Error) => this.error(err.message, err.stack))
    })

    this.app.delete(process.env.API_PATH + '/loehk/active_year/committee_members', async (req, res) =>{
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

      const id: number = req.body.id
      if(!id || isNaN(id)){
        res.status(400).send()
        return
      }

      console.log('deleting committee member ' + id)
      await committee_members(this.db).delete({id})
        .catch(err => console.log(err))

      res.send()

      this.redisClient.aDel('committee')
        .catch((err: Error) => this.error(err.message, err.stack))
    })
    return Promise.resolve(undefined);
  }

}
