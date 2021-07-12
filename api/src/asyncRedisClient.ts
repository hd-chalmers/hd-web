import { RedisClient } from 'redis'
import { promisify } from 'util'

/*
export const redisClient = redis.createClient({
  host: 'localhost',
  port: 49154
})
*/

// This class is a wrapper for the RedisClient object and it has promisofied versions of some functions
export default class AsyncRedisClient extends RedisClient{
  aGet = promisify(this.get).bind(this)
  aSet = promisify(this.set).bind(this)
  aExist = promisify(this.exists).bind(this)
  aDel = promisify(this.del).bind(this)
  aExpire = promisify(this.expire).bind(this)
}
