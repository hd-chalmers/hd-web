import { events } from './events'
import { frontPage } from './frontPage'
import { background } from './background'
import { committee } from './committee'
import { login } from './loehk/login'
import { loehkFrontpage } from './loehk/leohkFrontpage'
import { loehkEvents } from './loehk/loehkEvents'
import { loehkPrices } from './loehk/loehkPrices'
import { loehkInvestAcc } from './loehk/loehkInvestAcc'
import { loehkActiveYear } from './loehk/loehkActiveYear'
import { loehkActiveYearMembers } from './loehk/loehkActiveYearMembers'
import { door } from './door'
import { print } from './print'
import { priceList } from "./pricelist";
import {games} from "./games";
import {loehkGames} from "./loehk/loehkGames";

export const routes = [
  events,
  frontPage,
  background,
  committee,
  login,
  loehkFrontpage,
  loehkEvents,
  loehkPrices,
  loehkInvestAcc,
  loehkActiveYear,
  loehkActiveYearMembers,
  door,
  print,
  priceList,
  games,
  loehkGames
]
