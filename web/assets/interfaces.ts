import {Route} from "vue-router";

export interface EventType {
  id: bigint
  title: string
  description: string | null
  location: string | null
  facebook_event_link: string | null
  date: Date
}

export interface EventData{
  id: bigint
  title: string
  description: string | null
  location: string | null
  facebook_event_link: string | null
  date: string
}

export interface EventPropsData{
  id?: number
  title: string
  description: string | null
  location: string | null
  facebook_event_link: string | null
  date: string
  show_on_frontpage: boolean
  time: string
}

export interface MemberType {
  id: bigint
  name: string
  role: string
  image: string | null
  quote: string | null
  description: string | null
  favourite_game: string | null
  favourite_sugar: string | null
}

export interface YearData {
  displayed_year: string,
  groupPhoto: string | null,
  description: string | null,
  committee_members: MemberType[]
}

export interface FrontpageData{
  front_image: string | null
}

export interface SimpleEventData{
  title: string,
  date: Date
}

export interface GameData{
  id: bigint,
  name: string,
  description: string | null,
  genre: string | null,
  platform: string,
  min_players: number | null,
  max_players: number | null,
  published_year: string | null,
  max_playtime: number | null,
  min_playtime: number | null,
  expansion_to: {id: bigint, name: string} | null,
  expansions: {id: bigint, name: string}[],
  image_link: string | null
}

export interface PricelistCategory{
  id: number,
  name: string,
  products: {
    id: number,
    name: string,
    price: number,
    discount: number
  }[]
}

export interface LoehkSummaryData{
  products: number
  product_updated: {
    name: string,
    updated_at: string
  } | null
  product_latest: {
    name: string,
    created_at: string
  } | null
  investment_accounts: number,
  investment_latest: {
    uid: string,
    name: string,
    created_at: string
  }
  investment_updated: {
    uid: string,
    name: string,
    updated_at: string
  } | null
  events: number
  event_latest: {
    title: string,
    created_at: string,
    date: string
  } | null
  event_updated: {
    title: string,
    updated_at: string,
    date: string
  },
  games: number,
  games_latest: {
    name: string,
    created_at: string,
    platform: string,
  } | null,
  games_updated: {
    name: string,
    updated_at: string,
    platform: string,
  } | null,
  door_status: {
    status: string,
    updated_at: string,
    times_changed: number
  } | null,
  sales_month: {
    this_month: number,
    last_month: number,
    top_product: string
  } | null
}

export interface ActiveYearData{
  id: number,
  year: string,
  description: string | null,
  group_photo: string | null,
  front_image: string | null,
  christmas_image: string | null,
  background_image: string | null,
  committee_members: LoehkMemberType[]
}

export interface LoehkMemberType {
  id?: number
  name: string
  role: string
  image: string | null
  image_upload?: string | null
  quote: string | null
  description: string | null
  favourite_game: string | null
  favourite_sugar: string | null
}

export interface LoehkGameData{
  id: number,
  name: string,
  description: string | null,
  genre: GameGenreData | null,
  platform: PlatformData,
  min_players: number | null,
  max_players: number | null,
  published_year: string | null,
  max_playtime: number | null,
  min_playtime: number | null,
  expansion_to: {id: bigint, name: string} | null,
  owner: OwnerData | null,
  image_link: string | null,
  active: boolean,
  updated_at: string | null,
  created_at: string | null
}

export interface PlatformData{
  id: number,
  name: string,
  type: string
}

export interface OwnerData{
  id: number,
  name: string,
  nickname: string | null,
  phone_number: string | null,
  email: string | null
}

export interface GameGenreData{
  id: number,
  name: string
}

export interface InvestAccData{
  id: number,
  uid: string,
  name: string,
  password: string | null,
  balance: number,
  active: boolean,
  active_text: string,
  print: boolean,
  inactive_since: string,
  updated_at: string | null,
  created_at: string | null
}

export interface InevestAccPrintData{
  id: number,
  uid: string,
  name: string
}

export interface LoehkProductData{
  id: number,
  /* is used for keeping track of the form validity */
  valid?: boolean,
  category_id: number,
  /* is used for table sorting */
  category_name: string,
  name: string,
  purchase_price: number,
  discount: number,
  price: number,
  active: boolean,
  pant: boolean,
  package_size: number,
  adjustment: number,
  axfood: boolean,
  /* is a encoded version of barcodes in the format $name=barcode
  where $ is a boolean for a package barcode */
  combobox_barcodes: string[],
  updated_at: string | null
}

export interface LoehkDoorData{
  status: boolean | null,
  date: string,
  time: string,
  timestamp: string | Date
}

export interface VCalendarEvent{
  start: Date,
  end: Date,
  color: string,
  timed: boolean | number
}

export interface ProductCategory{
  id: number,
  name: string,
  created_at: string | null,
  updated_at: string | null
}

/*
  The type for the Boardgame Atlas mechanics api.
  Official documentation: https://www.boardgameatlas.com/api/docs/game/mechanics
 */
export interface BoardgameAtlasMechanic{
  id: string,
  name: string,
  url: string
}

/*
  The gmae type for most of the Boardgame Atlas APIs.
  Official documentation: https://www.boardgameatlas.com/api/docs/gameobject
 */
export interface BoardgameAtlasGame{
  id: string,
  name: string,
  handle: string,
  url: string,
  edit_url: string,
  price: string | number,
  price_ca: string | number,
  price_uk: string | number,
  price_au: string | number,
  msrp: number,
  msrps: {country: string, price: number}[],
  discount: string | number,
  min_players: number,
  max_players: number,
  min_playtime: number,
  max_playtime: number,
  min_age: number,
  description: string,
  commentary: string,
  faq: string,
  thumb_url: string,
  image_url: string,
  matches_specs: string | boolean | null,
  specs: [],
  mechanics: {id: string}[],
  categories: {id: string}[],
  related_to: [],
  developers: string[],
  artists: string[],
  designers: {id:string}[],
  publishers: {id:string}[],
  primary_publisher: { id:string, name:string, url:string },
  primary_designer: { id:string, name:string, url:string },
  names: string[],
  tags: string[],
  publisher: string,
  rules_url: string,
  amazon_rank: number,
  official_url: string,
  comment_amount: number,
  num_user_ratings: number,
  average_user_rating: number,
  weight_amount: number,
  weight_units: string,
  size_height: number,
  size_depth: number,
  size_units: string,
  historical_low_prices: {country:string, date:{__type:string,iso:string}, price: number, isLow: boolean},
  active: boolean,
  num_user_complexity_votes: number,
  average_learning_complexity: number,
  average_strategy_complexity: number,
  visits: number,
  lists: number,
  plays: number,
  mentions: number,
  links: number,
  rank: number,
  type: string,
  sku: string,
  upc: string,
  num_distributors: number,
  trending_rank: number,
  listing_clicks: number,
  is_historical_low: boolean,
  year_published: number,
  msrp_text: string,
  price_text: string,
  images: {thumb:string, small:string, medium:string, large:string, original:string},
  description_preview: string
}

declare module 'vue/types/vue'{
  export interface Vue{
    $ga: VueUA
  }

  interface VueUA{
    /**
     * Dispatch an analytics event.
     * Format is the same as analytics classical values.
     * @param category
     * @param action
     * @param label
     * @param value
     */
    event: (category: string, action: string, label?: string, value?:  number) => void

    /**
     * Dispatch a view using the screen name
     *
     * @param screenName {string}
     */
    screenView: (screenName: string) => void

    /**
     * Track a page view
     */
    page:
      ((payload: {page:string, title:string, location: string}) => void) |
      ((location: string) => void)|
      ((router: Route) => void)

    /**
     * Track a user timing to measure periods of time.
     *
     * @param {string} timingCategory - A string for categorizing all user timing variables into logical groups (e.g. 'JS Dependencies').
     * @param {string} timingVar -  A string to identify the variable being recorded (e.g. 'load').
     * @param {number} timingValue - The number of milliseconds in elapsed time to report to Google Analytics (e.g. 20).
     * @param {string|null} timingLabel -  A string that can be used to add flexibility in visualizing user timings in the reports (e.g. 'Google CDN').
     */
    time: (timingCategory: string, timingVar: string, timingValue: number, timingLabel?: string) => void

    /**
     * Track an exception that occurred in the application.
     *
     * @param {string} description - Something describing the error (max. 150 Bytes)
     * @param {boolean} isFatal - Default is false. Specifies whether the exception was fatal
     */
    exception: (description: string, isFatal?: true) => void

    /**
     * Track a social media interaction
     * @param socialNetwork The social media
     * @param socialAction A social action such as like
     * @param socialTarget The target url
     */
    social: (socialNetwork: string, socialAction:string, socialTarget:string) => void

    /**
     * Disables analytics tracking
     */
    disable: () => void

    /**
     * Enables analytics tracking
     */
    enable: () => void

    /**
     * Require a google analytics plugin
     * @param pluginName the plugin name
     * @param options the options payload for the plugin
     */
    require: (pluginName:string, options?: any) => void

    /**
     * Contains some methods for tracking ecommerce and shopping. Ecommerce must be enabled in config
     */
    ecommerce: {
      /**
       * Adds a product, if enhance script is enabled use addProduct() instead
       * @param payload item info, pricing fields are written in a currency format such as '10USD'
       */
      addItem: (payload: {id:string, name:string, sku?:string, category?:string, price?:number, quantity?:number}) => void
      /**
       * Adds a transaction, if enhanced script is enabled use setAction() instead
       * @param payload transaction information, pricing fields are written in a currency format such as '10USD'
       */
      addTransaction: (payload: {id:string, affiliation?:string, revenue?:string, shipping?:string, tax?:string}) => void
      /**'
       * Submit data added by addItem and addTransaction
       */
      send: () => void
      /**
       * Send data regarding what product is being currently viewed
       * @param payload impression data
       */
      addImpression: (payload: {id:string, name:string, category?:string, brand?:string, variant?:string, list?:string, position?:number}) => void
      /**
       * A product to be added to the analytics database
       * @param payload product information
       */
      addProduct: (payload:{id:string, name:string, category?:string, brand?:string, variant?:string, position?:number}) => void
      /**
       * An interaction regarding a set of product(s) as indicated by addProduct()
       * @param actionType the type of interaction
       * @param payload the product information
       */
      setAction: (actionType: string | "click" | "detail" | "add" | "remove" | "checkout" | "checkout_option" | "purchase" | "refund" | "promo_click",
                  payload: {id:string, affiliation?:string, revenue?:number, tax?:number, shipping?:number, coupon?:string, list:string, step:number, option?:string}) => void
      /**
       * Adds promotion information
       * @param payload promotion data
       */
      addPromo: (payload: {id:string, name:string, brand?:string, category?:string, variant?:string, price?:number, quantity?:number, coupon?:string, position?:number}) => void
    }
  }
}
