import ApiCall from '../interfaces'
import { events } from './events'
import { frontPage } from './frontPage'
import { background } from './background'
import { committee } from './committee'
import { login } from './loehk/login'
import {loehkFrontpage} from './loehk/leohkFrontpage'
import { loehkEvents } from './loehk/loehkEvents'
import { loehkPrices } from './loehk/loehkPrices'
import { loehkInvestAcc } from './loehk/loehkInvestAcc'
import { loehkActiveYear } from './loehk/loehkActiveYear'

export const routes : Array<ApiCall> = [
  new events,
  new frontPage,
  new background,
  new committee,
  new login,
  new loehkFrontpage,
  new loehkEvents,
  new loehkPrices,
  new loehkInvestAcc,
  new loehkActiveYear
]
