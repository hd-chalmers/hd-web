<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pricelist\NewProduct;
use App\Models\Barcode;
use App\Models\Category;
use App\Models\Product;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class PricelistController extends Controller
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
            $product->purchase_price = $request->post('purchase_price')*100;
            $product->discount       = $request->post('discount')*100;
            $product->active         = $request->post('active');
            $product->updatePrice($request->post('package'), $request->post('pant'));
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
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
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
