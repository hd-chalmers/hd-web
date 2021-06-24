import ApiCall from '../interfaces'
import { events } from './events'
import frontPage from './frontPage'
import background from './background'

export const routes : Array<ApiCall> = [
  new events,
  new frontPage,
  new background
]
