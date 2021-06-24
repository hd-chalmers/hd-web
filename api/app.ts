import express from 'express';
import db, {sql} from './src/database'
import active_years from './src/__generated__/active_years'

async function run(): Promise<active_years[]> {
  const years: active_years[] = await db.query(sql`
    SELECT * FROM active_years;
  `);
  if (years.length === 0) {
    return [];
  }
  return years;
}

run().catch((err) => {
  console.error(err);
  process.exit(1);
});

const app = express();
const PORT = 8000;
app.get('/', (req, res) => res.send('Api is running'));
app.get('/test', async (req, res) =>{
  const years: active_years[] = await db.query(sql`SELECT * FROM active_years`)
  res.send({years})
} )
app.listen(PORT, () => {
  console.log(`⚡️[server]: Server is running at https://localhost:${PORT}`);
});
