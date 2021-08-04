/**
 * !!! This file is autogenerated do not edit by hand !!!
 *
 * Generated by: @databases/pg-schema-print-types
 * Checksum: W6lInO0eSyDfztETYJNFnDfrGvM5RN7of6ON/4IBHMqrtD85C2uazeRtC+Npb6zQcgtK+sde4+6+/DJhSAC48Q==
 */

// eslint:disable
// tslint:disable

interface Categories {
  /**
   * @default CURRENT_TIMESTAMP
   */
  created_at: (Date) | null
  /**
   * @default nextval('categories_id_seq'::regclass)
   */
  id: number & {readonly __brand?: 'categories_id'}
  name: string
  /**
   * @default CURRENT_TIMESTAMP
   */
  updated_at: (Date) | null
}
export default Categories;

interface Categories_InsertParameters {
  /**
   * @default CURRENT_TIMESTAMP
   */
  created_at?: (Date) | null
  /**
   * @default nextval('categories_id_seq'::regclass)
   */
  id?: number & {readonly __brand?: 'categories_id'}
  name: string
  /**
   * @default CURRENT_TIMESTAMP
   */
  updated_at?: (Date) | null
}
export type {Categories_InsertParameters}
