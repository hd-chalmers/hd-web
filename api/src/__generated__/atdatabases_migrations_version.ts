/**
 * !!! This file is autogenerated do not edit by hand !!!
 *
 * Generated by: @databases/pg-schema-print-types
 * Checksum: TpzCQ93K0bjZPn+fXJRl8zC0sQMsUxzUePHiU8MTUjxrIJrQ3DId+E1dxnpZFwz7QWacFdhwsU5SfE9Y34LG4w==
 */

// eslint:disable
// tslint:disable

interface AtdatabasesMigrationsVersion {
  id: number & {readonly __brand?: 'atdatabases_migrations_version_id'}
  version: (string) | null
}
export default AtdatabasesMigrationsVersion;

interface AtdatabasesMigrationsVersion_InsertParameters {
  id: number & {readonly __brand?: 'atdatabases_migrations_version_id'}
  version?: (string) | null
}
export type {AtdatabasesMigrationsVersion_InsertParameters}
