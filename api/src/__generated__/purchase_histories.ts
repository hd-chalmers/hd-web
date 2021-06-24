/**
 * !!! This file is autogenerated do not edit by hand !!!
 *
 * Generated by: @databases/pg-schema-print-types
 * Checksum: QaBB9wrm0ySQKJvmHKzwTm4DnKmRS8/OGziaHLP7uyreeOLuD7Zs+T7MSNPXhzAGUmR0BoEqnu0j1BroJ0QUrA==
 */

// eslint:disable
// tslint:disable

import Accounts from './accounts'

interface PurchaseHistories {
  account_id: Accounts['id']
  created_at: (Date) | null
  /**
   * @default nextval('purchase_histories_id_seq'::regclass)
   */
  id: number & {readonly __brand?: 'purchase_histories_id'}
  sum: number
  updated_at: (Date) | null
}
export default PurchaseHistories;

interface PurchaseHistories_InsertParameters {
  account_id: Accounts['id']
  created_at?: (Date) | null
  /**
   * @default nextval('purchase_histories_id_seq'::regclass)
   */
  id?: number & {readonly __brand?: 'purchase_histories_id'}
  sum: number
  updated_at?: (Date) | null
}
export type {PurchaseHistories_InsertParameters}
