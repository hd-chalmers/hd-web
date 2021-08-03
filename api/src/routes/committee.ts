import { memberType } from '../interfaces'
import ActiveYears from '../__generated__/active_years'
import CommitteeMembers from '../__generated__/committee_members'
import ApiCall from '../apiCallClass'

export class committee extends ApiCall{
  processName = 'Committee'

  async run (): Promise<void> {

    this.app.get(process.env.API_PATH + '/committee', async (req, res)=>{
      if(await this.redisClient.aExist('committee')){
        res.setHeader('Content-Type', 'application/json')
        res.send(await this.redisClient.aGet('committee'))
        return
      }

      const yearList: ActiveYears[] = await this.db.query(this.sql`SELECT id, year, group_photo, description FROM active_years ORDER BY year DESC LIMIT 1`)
      const memberList: CommitteeMembers[] = await this.db.query(this.sql`SELECT * FROM committee_members WHERE active_year_id = ${yearList[0].id} ORDER BY id`)

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

      const result = {
        displayedYear: yearList[0].year.getFullYear() + '/' + (yearList[0].year.getFullYear() + 1),
        groupPhoto: yearList[0].group_photo,
        description: yearList[0].description,
        committeeMembers: formattedMembers
      }
      res.json(result)
      this.redisClient.aSet('committee', JSON.stringify(result))
        .then(() => {
          this.log('Set new cache')
          // Expire after a month
          this.redisClient.aExpire('committee', 2628000)
            .catch((err: Error) => this.error(err.message, err.message))
        })
        .catch((err: Error) => this.error(err.message, err.stack))
    })
    return Promise.resolve(undefined);
  }

}
