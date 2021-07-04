import ApiCall from '../../interfaces'
import { Express } from 'express'
import { ConnectionPool } from '@databases/pg'
import { SQL } from '@databases/sql'
import { active_years, committee_members } from '../../database'
import { FileArray, UploadedFile } from 'express-fileupload'

export class loehkActiveYear implements ApiCall{
  processName = 'Loehk Active Year'

  async run (app: Express, db: ConnectionPool, sql: SQL): Promise<void> {
    app.get('/loehk/active_year', async (req, res) => {
      const all_years: any[] = await active_years(db).find().orderByDesc('year').all()
      for (const year of all_years){
        year.displayed_year = year.year.getFullYear() + '/' + (year.year.getFullYear() + 1) as string
        year.committee_members = await committee_members(db).find({active_year_id: year.id}).all()
      }

      res.json({current: all_years[0], all_years})
    })

    app.patch('/loehk/active_year', async (req, res) => {
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
            active_years(db).update({id}, {description: data[key], updated_at: new Date()})
              .catch(err => console.log(err))
            break
          default:
            console.log(key + 'is not an allowed field')
            res.status(400).send()
            return
        }
      }

      for(const key in files){
        const year = await active_years(db).findOne({id})
          .catch(err => console.log(err))
        if(year === undefined){
          res.status(400).send()
          return
        }

        let file: UploadedFile, temp
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
            console.log('uploading ' + key)
            file = files[key] as UploadedFile
            switch (file.mimetype){
              case 'image/jpg':
                file.name += '.jpg'
                break
              case 'image/png':
                file.name += '.png'
                break
              case 'image/gif':
                file.name += '.gif'
                break
              case 'image/webp':
                file.name += '.webp'
                break
              default:
                console.log(file.mimetype + ' is not an allowed filetype')
                res.status(400).send()
                return
            }
            file.mv(`./storage/public/${(<any>year).year.getFullYear()}/` + file.name, (err) => console.log(err))
            temp = {} as any
            temp[key] = `http://localhost:8000/static/${(<any>year).year.getFullYear()}/` + file.name
            temp.updated_at = new Date()
            active_years(db).update({id}, temp)
              .catch(err => console.log(err))
            break
          default:
            console.log(key + 'is not an allowed field')
            res.status(400).send()
            return
        }
      }

      res.send()
    })

    app.post('/loehk/active_year', async (req, res) => {
      const currentDate = new Date()
      const newYear: any = await active_years(db).insert({
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
