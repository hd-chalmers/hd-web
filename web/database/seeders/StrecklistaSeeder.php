<?php
namespace Database\Seeders;
use App\Models\Account;
use App\Models\Barcode;
use App\Models\Category;
use App\Models\Product;
use App\Models\PurchaseHistory;
use App\Models\PurchaseHistoryProduct;
use Illuminate\Database\Seeder;

class StrecklistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts   = factory(Account::class, 5)->create();
        $categories = factory(Category::class, 3)->create();
        /** @var Category $category */
        foreach ($categories as $category) {
            $products = $category->products()->saveMany(factory(Product::class, 30)->make());
            /** @var Product $product */
            foreach ($products as $product) {
                $product->barcodes()->saveMany(factory(Barcode::class, 2)->make());
            }
        }
        /** @var Account $account */
        foreach ($accounts as $account) {
            $purchases = $account->purchase_history()->saveMany(factory(PurchaseHistory::class, 5)->make());
            /** @var PurchaseHistory $purchase */
            foreach ($purchases as $purchase) {
                $products = $purchase->purchase_history_products()->saveMany(factory(PurchaseHistoryProduct::class, 2)->make());
                $sum      = 0;
                /** @var PurchaseHistoryProduct $product */
                foreach ($products as $product) {
                    $sum += $product->price;
                }
                $purchase->sum = $sum;
                $purchase->save();
            }
        }
    }
}
