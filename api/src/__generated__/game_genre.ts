/**
 * !!! This file is autogenerated do not edit by hand !!!
 *
 * Generated by: @databases/pg-schema-print-types
 * Checksum: +S+i9BkPNj8e3IOh0dwuED1lwLwTbv0Jq2WFJMu9IIGlDVe4q+01iqxeAvQM5Vt1fxiZ9nGGZtYetjRtVVXI4Q==
 */

// eslint:disable
// tslint:disable

interface GameGenre {
  /**
   * @default CURRENT_TIMESTAMP
   */
  created_at: (Date) | null
  /**
   * @default nextval('game_genre_id_seq'::regclass)
   */
  id: number & {readonly __brand?: 'game_genre_id'}
  name: string
  /**
   * @default CURRENT_TIMESTAMP
   */
  updated_at: (Date) | null
}
export default GameGenre;

interface GameGenre_InsertParameters {
  /**
   * @default CURRENT_TIMESTAMP
   */
  created_at?: (Date) | null
  /**
   * @default nextval('game_genre_id_seq'::regclass)
   */
  id?: number & {readonly __brand?: 'game_genre_id'}
  name: string
  /**
   * @default CURRENT_TIMESTAMP
   */
  updated_at?: (Date) | null
}
export type {GameGenre_InsertParameters}