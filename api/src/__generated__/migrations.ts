/**
 * !!! This file is autogenerated do not edit by hand !!!
 *
 * Generated by: @databases/pg-schema-print-types
 * Checksum: 84gf8Pd6klaaz8OC/kcvuWjQl3pXCC48ox3cAwgPuMXHTdLAW55hyzZFvcadW18E7hio+HDVCkEx4vbDNeVYIg==
 */

// eslint:disable
// tslint:disable

interface Migrations {
  batch: number
  /**
   * @default nextval('migrations_id_seq'::regclass)
   */
  id: number & {readonly __brand?: 'migrations_id'}
  migration: string
}
export default Migrations;

interface Migrations_InsertParameters {
  batch: number
  /**
   * @default nextval('migrations_id_seq'::regclass)
   */
  id?: number & {readonly __brand?: 'migrations_id'}
  migration: string
}
export type {Migrations_InsertParameters}
