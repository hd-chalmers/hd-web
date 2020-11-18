<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pricelist\NewProduct;
use App\Http\Requests\Pricelist\UpdateProduct;
use App\Models\Barcode;
use App\Models\Category;
use App\Models\Product;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * PricelistController constructor.
     */
    public function __construct ()
    {
        $this->middleware('auth', [
            'except' => [
                'index',
            ],
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index ()
    {
        $categories = Category::with('products')->get();
        return response(view('pricelist.list')->with('categories', $categories));
    }


    public function deleteProduct (Product $product)
    {
        $product->delete();
    }

    public function newProduct (Request $request)
    {
        return DB::transaction(function () use ($request) {
                $product = new Product();
                $product->name = $request->input('name');
                $product->active = $request->input('active');
                $product->purchase_price = $request->input('purchase_price');
                $product->package_size = $request->input('package_size');
                $product->adjustment = $request->input('adjustment') ?? 0;
                $product->pant = $request->input('pant');
                $product->discount = $request->input('discount') ?? 0;
                $product->category_id = $request->input('category_id');
                $product->price = $request->input('price') ?? 0;
                $product->save();
                foreach ($request->input('barcodes') as $code) {
                    $barcode = new Barcode();
                    if (count($vars = explode('=', $code)) >= 2) {
                        $barcode->variant_name = $vars[0];
                        $barcode->barcode = $vars[1];
                    } else {
                        $barcode->barcode = $vars[0];
                    }
                    $product->barcodes()->save($barcode);
                }

                return response()->json([
                                            'products'   => Product::with([
                                                                              'barcodes',
                                                                              'category',
                                                                          ])->orderBy('name')->get(),
                                            'categories' => Category::all(),
                                        ]);
            }) ?? response('', 500);
    }

    public function updateProduct (Request $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {
            $product->name = $request->input('name');
            $product->active = $request->input('active');
            $product->purchase_price = $request->input('purchase_price');
            $product->package_size = $request->input('package_size');
            $product->adjustment = $request->input('adjustment') ?? 0;
            $product->pant = $request->input('pant');
            $product->discount = $request->input('discount') ?? 0;
            $product->category_id = $request->input('category_id');
            $product->price = $request->input('price');
            foreach ($request->input('combobox_barcodes') as $code) {
                if (count($vars = explode('=', $code)) >= 2) {
                    $barcode = Barcode::whereBarcode($vars[1])->firstOrNew();
                    $barcode->variant_name = $vars[0];
                    $barcode->barcode = $vars[1];
                } else {
                    $barcode = Barcode::whereBarcode($vars[0])->firstOrNew();
                    $barcode->barcode = $vars[0];
                }
                $product->barcodes()->save($barcode);
            }
            $product->save();
        });
    }
}
