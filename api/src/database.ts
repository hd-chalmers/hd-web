import createConnectionPool, {sql} from '@databases/pg';
import tables from '@databases/pg-typed';
import DatabaseSchema, {serializeValue} from './__generated__';

export {sql};

const db = createConnectionPool('postgres://hd:hd@localhost:1081/hd');
export default db;

// You can list whatever tables you actually have here:
const {active_years, committee_members, events, users} = tables<DatabaseSchema>({
  serializeValue,
});
export {active_years, committee_members, events, users};
