import { active_years, committee_members } from '../../database'
import { FileArray, UploadedFile } from 'express-fileupload'
import ApiCall from '../../apiCallClass'
import * as fs from 'fs'

export class loehkActiveYear extends ApiCall{
  processName = 'Loehk Active Year'

  async run (): Promise<void> {
    this.app.get(process.env.API_PATH + '/loehk/active_year', async (req, res) => {
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

      const all_years: any[] = await active_years(this.db).find().orderByDesc('year').all()
      for (const year of all_years){
        year.displayed_year = year.year.getFullYear() + '/' + (year.year.getFullYear() + 1) as string
        year.committee_members = await committee_members(this.db).find({active_year_id: year.id}).orderByAsc('id').all()
      }

      res.json({current: all_years[0], all_years})
    })

    this.app.patch(process.env.API_PATH + '/loehk/active_year', async (req, res) => {
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

      const id: number = parseInt(<string> req.query.yearId)

      if(id === undefined || isNaN(id)){
        res.status(400).send()
        return
      }

      const data = req.body
      const files = req.files
      for(const key in data){
        switch (key){
          case 'description':
            console.log('updated description for ' + id)
            active_years(this.db).update({id}, {description: data[key], updated_at: new Date()})
              .catch(err => console.log(err))
            break
          default:
            console.log(key + 'is not an allowed field')
            res.status(400).send()
            return
        }
      }

      for(const key in files){
        const year = await active_years(this.db).findOne({id})
          .catch(err => console.log(err))
        if(year === undefined){
          res.status(400).send()
          return
        }

        let temp
        switch (key){
          case 'front_image':
          case 'christmas_image':
          case 'group_photo':
          case 'background_image':
            if(!req.files || !(<FileArray> req.files)[key]){
              console.log('File missing for ' + key)
              res.status(400).send()
              return
            }
            if((<UploadedFile>req.files[key]).size > 10 * 1000000){
              fs.rm((<UploadedFile>req.files[key]).tempFilePath, (err) => {
                if(err){
                this.error(err?.message, err?.stack)
              }})
              res.sendStatus(422)
              return
            }
            await this.processImage(<UploadedFile> files[key], `./storage/public/${(<any>year).year.getFullYear()}/`)
              .catch(err => {
                res.sendStatus(415)
                this.error(err)
              })
                if(res.statusCode  >= 400 ){
                  return
                }
                temp = {} as any
                temp[key] = `${<string>process.env.API_FULL_URL + process.env.STATIC_PATH}/${(<any>year).year.getFullYear()}/` + (<UploadedFile>files[key]).name + '.webp'
                temp.updated_at = new Date()
                active_years(this.db).update({ id }, temp)
                  .catch(err => this.error(err))

            this.log('uploaded ' + key)
            break
          default:
            this.error(key + 'is not an allowed field')
            res.status(400).send()
            return
        }
      }

        res.send()

      this.redisClient.aDel('committee')
        .catch(((err: Error) => this.error(err.message, err.stack)))
      this.redisClient.aDel('background')
        .catch((err: Error) => this.error(err.message, err.stack))
      this.redisClient.aDel('frontpage')
        .catch((err: Error) => this.error(err.message, err.stack))
    })

    this.app.post(process.env.API_PATH + '/loehk/active_year', async (req, res) => {
      // Check if request is authorized
      if(!await this.verify(<string> req.header('sessionId'))){
        this.warn(req.header('sessionId') + ' tried to access without being loggedin')
        res.status(403).send()
        return
      }

      const currentDate = new Date()
      const newYear: any = await active_years(this.db).insert({
        year: currentDate,
        updated_at: currentDate,
        created_at: currentDate
      })
        .catch(err => console.log(err))

      newYear[0].displayed_year = currentDate.getFullYear() + '/' + (currentDate.getFullYear() + 1) as string
      newYear[0].committee_members = []

      res.json(newYear[0])
    })
    return Promise.resolve(undefined);
  }

}
