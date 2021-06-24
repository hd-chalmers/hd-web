import ApiCall from '../interfaces'
import { events } from './events'
import frontPage from './frontPage'

export const routes : Array<ApiCall> = [
  new events,
  new frontPage
]
