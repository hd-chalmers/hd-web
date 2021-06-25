/**
 * !!! This file is autogenerated do not edit by hand !!!
 *
 * Generated by: @databases/pg-schema-print-types
 * Checksum: 5jZnkoIIldvrjvueBKiN3PyTci+J5En75xm3GQxpNpaPdLPAozlKsAFoytTmh3Q0Vd/7eVOTCYB5EibiZ2uYuA==
 */

// eslint:disable
// tslint:disable

interface GamePlatforms {
  bgg_type: (string) | null
  created_at: (Date) | null
  /**
   * @default nextval('game_platforms_id_seq'::regclass)
   */
  id: number & {readonly __brand?: 'game_platforms_id'}
  name: string
  type: string
  updated_at: (Date) | null
}
export default GamePlatforms;

interface GamePlatforms_InsertParameters {
  bgg_type?: (string) | null
  created_at?: (Date) | null
  /**
   * @default nextval('game_platforms_id_seq'::regclass)
   */
  id?: number & {readonly __brand?: 'game_platforms_id'}
  name: string
  type: string
  updated_at?: (Date) | null
}
export type {GamePlatforms_InsertParameters}