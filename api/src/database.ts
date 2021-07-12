import createConnectionPool, {sql} from '@databases/pg';
import tables from '@databases/pg-typed';
import DatabaseSchema, {serializeValue} from './__generated__';

export {sql};

const db = createConnectionPool();
export default db;

// You can list whatever tables you actually have here:
const {accounts, active_years, barcodes, categories, committee_members, events, game_owners, game_platforms, games,
  products, purchase_histories, purchase_history_products, users} = tables<DatabaseSchema>({
  serializeValue,
});
export {accounts, active_years, barcodes, categories, committee_members, events, game_owners, game_platforms, games,
        products, purchase_histories, purchase_history_products, users};
