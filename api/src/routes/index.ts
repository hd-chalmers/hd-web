import ApiCall from '../interfaces'
import { events } from './events'
import { frontPage } from './frontPage'
import { background } from './background'
import { committee } from './committee'
import { login } from './login'

export const routes : Array<ApiCall> = [
  new events,
  new frontPage,
  new background,
  new committee,
  new login
]
