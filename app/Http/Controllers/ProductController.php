<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Support\Collection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $products = DB::table('products')
                    ->join('product_variant_prices', 'products.id', '=', 'product_variant_prices.product_id')
                    ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                    ->select('products.*', 'product_variant_prices.price', 'product_variant_prices.stock',  'product_variants.variant' )
                    ->paginate(10);

        $variants = Variant::all();
        
        return view('products.index', ['products' => $products, 'variants' => $variants]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $product = Product::create([
            'title' => $request->input('product_name'),
            'sku' => $request->input('product_sku'),
            'description' => $request->input('description'),
        ]);

        $productVariant = ProductVariant::create([
            'variant' => $request->input('variant'),
            'product_id' => $product->id,
            'variant_id' => $request->input('product_variant_one'),
        ]);
        
        $productVariantPrice = new ProductVariantPrice;
        $productVariantPrice->product_variant_one = $productVariant->id; 
        $productVariantPrice->price = (float) $request->input('price'); 
        $productVariantPrice->stock = (int) $request->input('stock'); 
        $productVariantPrice->product_id = $product->id; 
        $productVariantPrice->save();

        

        $variants = Variant::all();
        return view('products.create', ['variants' => $variants]);
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        $product = DB::table('products')
                    ->join('product_variant_prices', 'products.id', '=', 'product_variant_prices.product_id')
                    ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                    ->select('products.*', 'product_variant_prices.price', 'product_variant_prices.stock',  'product_variants.variant' )
                    ->where('products.id', $product->id)
                    ->first();
        return view('products.edit', ['product' => $product, 'variants' => $variants]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $productUpdate = Product::find($request->input('id'));
        $productUpdate->title = $request->input('product_name');
        $productUpdate->sku = $request->input('product_sku');
        $productUpdate->description = $request->input('description');
        $productUpdate->save();

        ProductVariantPrice::where('product_id', $request->input('id'))
            ->update([
                'price' => (float) $request->input('price'),
                'stock' => (int) $request->input('stock'),
            ]);

        return redirect('/product');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    //filter data
    public function filter(Request $request)
    {
        //
        $variants = Variant::all();
        $products = DB::table('products')
                    ->join('product_variant_prices', 'products.id', '=', 'product_variant_prices.product_id')
                    ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                    ->select('products.*', 'product_variant_prices.price', 'product_variant_prices.stock',  'product_variants.variant' )
                    ->where('products.title','like', '%'. $request->input('title').'%')
                    ->paginate(10);
        return view('products.index', ['products' => $products, 'variants' => $variants]);
    }
}
