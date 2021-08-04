/**
 * !!! This file is autogenerated do not edit by hand !!!
 *
 * Generated by: @databases/pg-schema-print-types
 * Checksum: lK6pPp16gBYESeQfqItv17dpMXH3lmKOoh6prTZOPwyYxy/PubRAEFAnUZLaH77VFPKCjLKbzvDoDZEPi7d2WA==
 */

// eslint:disable
// tslint:disable

import Accounts from './accounts'

interface PurchaseHistories {
  account_id: Accounts['id']
  /**
   * @default CURRENT_TIMESTAMP
   */
  created_at: (Date) | null
  /**
   * @default nextval('purchase_histories_id_seq'::regclass)
   */
  id: number & {readonly __brand?: 'purchase_histories_id'}
  sum: number
  /**
   * @default CURRENT_TIMESTAMP
   */
  updated_at: (Date) | null
}
export default PurchaseHistories;

interface PurchaseHistories_InsertParameters {
  account_id: Accounts['id']
  /**
   * @default CURRENT_TIMESTAMP
   */
  created_at?: (Date) | null
  /**
   * @default nextval('purchase_histories_id_seq'::regclass)
   */
  id?: number & {readonly __brand?: 'purchase_histories_id'}
  sum: number
  /**
   * @default CURRENT_TIMESTAMP
   */
  updated_at?: (Date) | null
}
export type {PurchaseHistories_InsertParameters}
