import ApiCall from '../../apiCallClass'
import { accounts, events, games, products } from '../../database'


export class loehkFrontpage extends ApiCall{
  processName = 'Loehk Frontpage'

  async run (): Promise<void> {
    this.app.get(process.env.API_PATH + '/loehk/front', async (req, res) => {
      // Check if request is authorized
        if(!await this.verify(<string> req.header('sessionId'))){
          this.warn(req.header('sessionId') + ' tried to access without being loggedin')
          res.status(403).send()
          return
        }

      if(await this.redisClient.aExist('loehkFront')){
        res.setHeader('Content-Type', 'application/json')
        res.send(await this.redisClient.aGet('loehkFront'))
        return
      }

        const productCount = await  products(this.db).count()
        const updatedProducts = await products(this.db).find().select('name', 'updated_at').orderByDesc('updated_at').first()
        const latestProduct = await products(this.db).find().select('name', 'created_at').orderByDesc('created_at').first()

        const accountCount = await accounts(this.db).count()
        const latestAccount = await accounts(this.db).find().select('name', 'uid', 'created_at').orderByDesc('created_at').first()
        const updatedAccount = await accounts(this.db).find().select('name', 'uid', 'updated_at').orderByDesc('updated_at').first()

        const eventCount = await  events(this.db).count()
        const latestEvent = await events(this.db).find().select('title', 'date', 'created_at').orderByDesc('created_at').first()
        const updatedEvent = await events(this.db).find().select('title', 'date', 'updated_at').orderByDesc('updated_at').first()

        const gameCount =  await games(this.db).count()
        const latestGame = await this.db.query(this.sql`SELECT games.name, games.created_at, gp.name AS platform FROM games
                            JOIN game_platforms gp on games.game_platform_id = gp.id ORDER BY games.created_at DESC LIMIT 1`)
        const updatedGame = await this.db.query(this.sql`SELECT games.name, games.updated_at, gp.name AS platform FROM games
                            JOIN game_platforms gp on games.game_platform_id = gp.id ORDER BY games.updated_at DESC LIMIT 1`)

      const result = {
        products: productCount,
        product_updated: updatedProducts,
        product_latest: latestProduct,
        investment_accounts: accountCount,
        investment_latest: latestAccount,
        investment_updated: updatedAccount,
        events: eventCount,
        event_latest: latestEvent,
        event_updated: updatedEvent,
        games: gameCount,
        games_latest: latestGame[0] ? latestGame[0] : null,
        games_updated: updatedGame[0] ? updatedGame[0] : null
      }

      res.json(result)
      this.redisClient.aSet('loehkFront', JSON.stringify(result))
        .then(() => {
          this.log('Set new cache')
          // Expire after a month
          this.redisClient.aExpire('loehkFront', 2628000)
            .catch((err: Error) => this.error(err.message, err.message))
        })
        .catch((err: Error) => this.error(err.message, err.stack))
    })
    return Promise.resolve(undefined);
  }
}
