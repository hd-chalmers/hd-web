import ApiCall from '../interfaces'
import { events } from './events'
import { frontPage } from './frontPage'
import { background } from './background'
import { committee } from './committee'

export const routes : Array<ApiCall> = [
  new events,
  new frontPage,
  new background,
  new committee
]
