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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * PricelistController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'index',
                'show',
            ],
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = Category::with('products')->get();
        return response(view('pricelist.list')->with('categories', $categories));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'categories' => Category::all(),
        ];
        return response(view('pricelist.create', $data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewProduct $request
     *
     * @return ResponseFactory|Response
     */
    public function store(NewProduct $request)
    {
        try {
            $category                = Category::findOrFail($request->post('category_id'));
            $product                 = new Product();
            $product->name           = $request->post('name');
            $product->purchase_price = $request->post('purchase_price') * 100;
            $product->discount       = $request->post('discount') * 100;
            $product->active         = $request->post('active');
            $product->package_size   = $request->post('package');
            $product->pant           = $request->post('pant');
            $product->updatePrice();
            $category->products()->save($product);
            foreach ($request->post('barcodes') as $barcode) {
                $barcodes[] = new Barcode($barcode);
            }
            $product->barcodes()->saveMany($barcodes);
            return response($product->id, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response(\GuzzleHttp\json_encode([
                                                        'message' => $e->getMessage(),
                                                        'trace'   => $e->getTraceAsString(),
                                                    ]), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     *
     * @return Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('barcodes');

        return \response(view('pricelist.update', [
            'categories' => $categories,
            'product'    => $product,
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProduct $request
     * @param Product       $product
     *
     * @return Response
     * @throws Exception
     */
    public function update(UpdateProduct $request, Product $product)
    {
        if ($request->input('id')) {
            try {
                DB::beginTransaction();
                $product->name           = $request->input('name');
                $product->purchase_price = $request->input('purchase_price') * 100;
                $product->active         = $request->input('active');
                $product->discount       = $request->input('discount') * 100;
                $product->package_size   = $request->input('package_size');
                $product->pant           = $request->input('pant');
                $product->category()->associate(Category::findOrFail($request->input('id')));
                $product->updatePrice();
                $product->barcodes()->delete();
                foreach ($request->post('barcodes') as $barcode) {
                    $barcodes[] = new Barcode($barcode);
                }
                $product->barcodes()->saveMany($barcodes);
                $product->save();
                DB::commit();
                return \response(\GuzzleHttp\json_encode(['status' => 1]), 200);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                Log::error($e->getTraceAsString());
                throw $e;
            }
        } else {
            return \response(\GuzzleHttp\json_encode([
                                                         'status'  => 0,
                                                         'message' => 'ID Mismatch',
                                                     ]), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     *
     * @return ResponseFactory|Response
     * @throws Exception
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        $product->barcodes()->delete();
        $product->delete();
        DB::commit();
        return \response('Ok!');
    }

    public function download()
    {
        $data = [
            'categories' => Category::with([
                                               'products' => function ($q) {
                                                   $q->where('active', 1)->orderBy('name');
                                               },
                                           ])->get(),
        ];
        $pdf  = PDF::loadView('pricelist.render', $data);
        return $pdf->stream();
    }
}
