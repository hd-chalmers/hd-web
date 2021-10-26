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
  group_photo: string | null,
  description: string | null,
  committee_members: MemberType[]
}

export interface FrontpageData{
  front_image: string | null,
  event: {title: string, date: string} | null,
  event_after: {title: string, date: string} | null,
  event_count: number
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
  } | null
  games_updated: {
    name: string,
    updated_at: string,
    platform: string,
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
  id: bigint,
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
