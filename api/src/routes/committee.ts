import ApiCall, { memberType } from '../interfaces'
import { Express } from 'express'
import { ConnectionPool } from '@databases/pg'
import { SQL } from '@databases/sql'
import ActiveYears from '../__generated__/active_years'
import CommitteeMembers from '../__generated__/committee_members'

export class committee implements ApiCall{
  processName = 'Committee'

  async run (app: Express, db: ConnectionPool, sql: SQL): Promise<void> {

    app.get('/committee', async (req, res)=>{
      console.log('[API] ' + this.processName + ' was accessed')
      const yearList: ActiveYears[] = await db.query(sql`SELECT id, year, group_photo, description FROM active_years ORDER BY year DESC LIMIT 1`)
      const memberList: CommitteeMembers[] = await db.query(sql`SELECT * FROM committee_members WHERE active_year_id = ${yearList[0].id}`)

      const formattedMembers: memberType[] = []

      for(const member of memberList){
        formattedMembers.push(<memberType>{
          id: member.id,
          description: member.description,
          favouriteGame: member.favourite_game,
          favouriteSugar: member.favourite_sugar,
          name: member.name,
          profilePic: member.image,
          quote: member.quote,
          role: member.role
        })
      }

      res.json({
        displayedYear: yearList[0].year.getFullYear() + '/' + (yearList[0].year.getFullYear() + 1),
        groupPhoto: yearList[0].group_photo,
        description: yearList[0].description,
        committeeMembers: formattedMembers
      })
    })
    return Promise.resolve(undefined);
  }

}
