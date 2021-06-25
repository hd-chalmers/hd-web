/**
 * !!! This file is autogenerated do not edit by hand !!!
 *
 * Generated by: @databases/pg-schema-print-types
 * Checksum: 1DAXXU/ElaBRdKU1wanCHdRcVz9UiwhxLSGkFJFtQMeJFiccbL/8Udmo+Zl/OPn47mvK0wDxjBxiD6mcRLK04w==
 */

// eslint:disable
// tslint:disable

interface ActiveYears {
  background_image: (string) | null
  christmas_image: (string) | null
  created_at: (Date) | null
  description: (string) | null
  front_image: (string) | null
  group_photo: (string) | null
  /**
   * @default nextval('active_years_id_seq'::regclass)
   */
  id: number & {readonly __brand?: 'active_years_id'}
  updated_at: (Date) | null
  year: Date
}
export default ActiveYears;

interface ActiveYears_InsertParameters {
  background_image?: (string) | null
  christmas_image?: (string) | null
  created_at?: (Date) | null
  description?: (string) | null
  front_image?: (string) | null
  group_photo?: (string) | null
  /**
   * @default nextval('active_years_id_seq'::regclass)
   */
  id?: number & {readonly __brand?: 'active_years_id'}
  updated_at?: (Date) | null
  year: Date
}
export type {ActiveYears_InsertParameters}