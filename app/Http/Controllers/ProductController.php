<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Support\Collection;
use Intervention\Image\Facades\Image as Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $products = ProductVariantPrice::with('products', 'productvariantsone', 'productvariantstwo', 'productvariantsthree')->paginate(10);
        //dd($products);

        $groups = DB::table('variants')
        ->select('description')
        ->groupBy('description')
        ->get();

        $variants = Variant::all();

        
        //dd($groups[0]->description);
        
        return view('products.index', ['products' => $products, 'variants' => $variants, 'groups' => $groups]);
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


        $productVariantPrice = new ProductVariantPrice;
        

        if($request->input('variantid') != null)
        {
        $variant = Variant::where('id', $request->input('variantid'))->first();
        $productVariant = ProductVariant::create([
            'variant' => $variant->title,
            'product_id' => $product->id,
            'variant_id' => $request->input('variantid'),
        ]);
        $productVariantPrice->product_variant_one = $productVariant->id; 
        }

        if($request->input('variantid2') != null)
        {
        $variant2 = Variant::where('id', $request->input('variantid2'))->first();
        $productVariant2 = ProductVariant::create([
            'variant' => $variant2->title,
            'product_id' => $product->id,
            'variant_id' => $request->input('variantid2'),
        ]);
        $productVariantPrice->product_variant_two = $productVariant2->id;
        }

        if($request->input('variantid3') != null)
        {
        $variant3 = Variant::where('id', $request->input('variantid3'))->first();
        $productVariant3 = ProductVariant::create([
            'variant' => $variant3->title,
            'product_id' => $product->id,
            'variant_id' => $request->input('variantid3'),
        ]);
        $productVariantPrice->product_variant_three = $productVariant3->id;
        }

        
        
        
        $productVariantPrice->price = (float) $request->input('price'); 
        $productVariantPrice->stock = (int) $request->input('stock'); 
        $productVariantPrice->product_id = $product->id; 
        $productVariantPrice->save();

        $this->validate($request, [
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg'
        ]);
        $originalImage= $request->file('image');
        $thumbnailImage = Image::make($originalImage);
        
        $thumbnailPath = public_path('/images/thumbnail/');
        $originalPath = public_path('/images/');
        
        $thumbnailImage->save($originalPath.time().$originalImage->getClientOriginalName());
        
        $thumbnailImage->resize(150,150);
        $thumbnailImage->save($thumbnailPath.time().$originalImage->getClientOriginalName()); 
        
        $imagemodel= new ProductImage();
        $imagemodel->product_id = $product->id;
        $imagemodel->file_path=time().$originalImage->getClientOriginalName();
        $imagemodel->save();

        $variants = Variant::all();
        return view('products.create', ['variants' => $variants])->with('success', 'New product has been created successful');
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
        $product = ProductVariantPrice::with('products', 'productvariantsone', 'productvariantstwo', 'productvariantsthree')
                    ->where('product_id', $product->id)
                    ->first();
        $image = ProductImage::where('product_id', $product->product_id)->first();
        //dd($product->product_id);

        return view('products.edit', ['product' => $product, 'image' => $image, 'variants' => $variants]);
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

        //dd($request->input('variantid'));

        if($request->input('variantid') != null)
        {
        $variant1 = Variant::where('id', $request->input('variantid'))->first();
        ProductVariant::where('product_id', $request->input('id'))
        ->update([
            'variant' => $variant1->title,
            'variant_id' => $request->input('variantid'),
        ]);
        }

        if($request->input('variantid2') != null)
        {
        $variant2 = Variant::where('id', $request->input('variantid2'))->first();
        ProductVariant::where('product_id', $request->input('id'))->update([
            'variant' => $variant2->title,
            'variant_id' => $request->input('variantid2'),
        ]);
        }

        if($request->input('variantid3') != null)
        {
        $variant3 = Variant::where('id', $request->input('variantid3'))->first();
        ProductVariant::where('product_id', $request->input('id'))->update([
            'variant' => $variant3->title,
            'variant_id' => $request->input('variantid3'),
        ]);
        }

        ProductVariantPrice::where('product_id', $request->input('id'))
            ->update([
                'product_variant_one' => $request->input('variantid'),
                'product_variant_two' => $request->input('variantid2'),
                'product_variant_three' => $request->input('variantid3'),
                'price' => (float) $request->input('price'),
                'stock' => (int) $request->input('stock'),
            ]);

        $this->validate($request, [
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg'
        ]);
        $originalImage= $request->file('image');
        $thumbnailImage = Image::make($originalImage);
        
        $thumbnailPath = public_path('/images/thumbnail/');
        $originalPath = public_path('/images/');
        
        $thumbnailImage->save($originalPath.time().$originalImage->getClientOriginalName());
        
        $thumbnailImage->resize(150,150);
        $thumbnailImage->save($thumbnailPath.time().$originalImage->getClientOriginalName());

        ProductImage::where('product_id', $request->input('id'))
        ->update([
            'file_path' => time().$originalImage->getClientOriginalName(),
        ]);

        return redirect('/product')->with('success', 'Product has been updated successful');

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
        $date = date("Y-m-d", strtotime($request->input('date')));
        
        if ($request->input('title') != null ) {
            $title = $request->input('title');
            $products = ProductVariantPrice::with('products', 'productvariantsone', 'productvariantstwo', 'productvariantsthree')
                                    ->whereHas('products', function($q) use($title) {
                                        $q->where('title','like', '%'.$title.'%'); 
                                })
                    ->paginate(10);
        }

        if ($request->input('variant') != null ) {
            $variant = ProductVariant::where('variant', $request->input('variant'))->first();
            $products = ProductVariantPrice::with('products', 'productvariantsone', 'productvariantstwo', 'productvariantsthree')
                    ->where('product_variant_one','like', '%'.$variant->id.'%')
                    ->paginate(10);
        }

        if ($request->input('price_from') != null && $request->input('price_to') != null ) {
            $products = ProductVariantPrice::with('products', 'productvariantsone', 'productvariantstwo', 'productvariantsthree')
                    ->whereBetween('price', [$request->input('price_from'), $request->input('price_to')])
                    ->paginate(10);
        }

        if ($request->input('date') != null ) {
            $products = ProductVariantPrice::with('products', 'productvariantsone', 'productvariantstwo', 'productvariantsthree')
                    ->where('created_at','like', '%'.$date.'%')
                    ->paginate(10);
        }

        $groups = DB::table('variants')
        ->select('description')
        ->groupBy('description')
        ->get();

        
        return view('products.index', ['products' => $products, 'variants' => $variants, 'groups' => $groups]);
    }
}
