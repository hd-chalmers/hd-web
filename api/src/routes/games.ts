import ApiCall from "../apiCallClass";


export class games extends ApiCall{
  processName = 'Games'

  async run(): Promise<void> {
    this.app.get('/games', async (req, res) => {
      if(await this.redisClient.aExist('games')){
        res.setHeader('Content-Type', 'application/json')
        res.send(await this.redisClient.aGet('games'))
        return
      }

      const entries = await this.db.query(this.sql`SELECT games.id AS id, games.name AS name, description, min_players, max_players, min_playtime, max_playtime, published_year,
       expansion_to, game_platforms.name AS platform, image_link, game_genre.name AS genre FROM games LEFT JOIN game_platforms ON games.game_platform_id = game_platforms.id
           LEFT JOIN game_genre ON games.genre_id = game_genre.id ORDER BY games.name`)
      for(const game of entries){
        if(game.expansion_to){
          const index = await this.findIndexOfId(game.expansion_to, entries)
          if(index){
            if(entries[index].expansions === undefined){
              entries[index].expansions = []
            }
            entries[index].expansions.push({name: game.name, id: game.id})
            game.expansion_to = {name: entries[index].name, id: game.expansion_to}
          }
        else {
          this.warn(game.name + ' doesn\'t have an parent')
          }
        }
      }

      const result = JSON.stringify(entries)
      res.send(result)
      this.redisClient.aSet('games', result)
        .then(() => {
          this.log('Set new cache')
          // Expire after a month
          this.redisClient.aExpire('games', 2628000)
            .catch((err: Error) => this.error(err.message, err.message))
        })
        .catch((err: Error) => this.error(err.message, err.stack))
    })
    return Promise.resolve(undefined);
  }

  async findIndexOfId(id:number, array: any[]): Promise<number | null>{
    for(const key in array){
      if (array[key].id === id){
        const index = parseInt(key)
        return Promise.resolve(isNaN(index) ? null : index)
      }
    }
    return Promise.resolve(null)
  }
}
