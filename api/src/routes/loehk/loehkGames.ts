import ApiCall from "../../apiCallClass";
import {game_genre, game_owners, game_platforms, games} from "../../database";

export class loehkGames extends ApiCall{
  processName = 'Loehk Games'

  async run(): Promise<void> {
    // TODO Add more api calls
    this.app.get(process.env.API_PATH + '/loehk/games', async (req, res) => {
      const entries = await games(this.db).find().orderByAsc('name').all() as any
      for(const game of entries){
        if(game.expansion_to){
          const index = await this.findIndexOfId(game.expansion_to, entries)
          if(index){
            game.expansion_to = {name: entries[index].name, id: game.expansion_to}
          }
          else {
            this.warn(game.name + ' doesn\'t have an parent')
          }
        }

        if(game.game_platform_id){
          game.platform = await game_platforms(this.db).findOne({id: game.game_platform_id})
          game.group = game.platform?.name
        }
        else {
          game.group = 'okänd'
        }

        if(game.game_owner_id){
          game.owner = await game_owners(this.db).findOne({id: game.game_owner_id})
        }
        else {
          game.owner = {}
        }

        if(game.genre_id){
          game.genre = await game_genre(this.db).findOne({id: game.genre_id})
        }
      }

      const genres = await game_genre(this.db).find().orderByAsc('name').all()
      const platforms = await game_platforms(this.db).find().orderByAsc('name').all()
      const owners = await game_owners(this.db).find().orderByAsc('name').all()

      res.json({
        games: entries,
        genres,
        platforms,
        owners
      })
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
