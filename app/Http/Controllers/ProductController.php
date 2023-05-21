<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\ProductVariant;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $products = Product::latest()->get();

        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();

        return view('product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'product_name' => $request->name,
            'category_id'  =>  $request->category,
            'subcategory_id' => $request->subcategory,
            'brand_id' => $request->brand,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'selling_price' => $request->sellingPrice,
        ];
        
        $product = Product::Create($data);
        $productVariantsData = [];
        
        if($request->has('variant') && count($request->variant) > 0) {
            if(isset($variantData['type']) && !is_null($variantData['type'])) {
                foreach ($request->variant as $variantData) {
                    $productVariantsData[] = [
                        'variant_type' => $variantData['type'],
                        'color' => $variantData['color'],
                        'size' => json_encode($variantData['sizes']),
                        'quantity' => $variantData['quantity'],
                        'price' => $variantData['price'],
                        'selling_price' => $variantData['sellingPrice'],
                        
                    ];
                }
            }

            $product->variants()->createMany($productVariantsData);
        }
        

        return redirect()->route('product.index')->with('success', 'Product added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategories = Subcategory::whereCategoryId($product->category_id)->get();
        $brands = Brand::orderBy('name', 'ASC')->get();

        return view('product.edit', compact('product', 'categories', 'subcategories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = [
            'product_name' => $request->name,
            'category_id'  =>  $request->category,
            'subcategory_id' => $request->subcategory,
            'brand_id' => $request->brand,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'selling_price' => $request->sellingPrice,
        ];
        
        $product->update($data);

        if($request->has('variant') && count($request->variant) > 0) {
            $productVariantsData = [];
            foreach ($request->variant as $variantData) {

                if(isset($variantData['type']) && !is_null($variantData['type'])) {
                
                    $productVariantsData[] = [
                        'variant_type' => $variantData['type'],
                        'color' => $variantData['color']??null,
                        'size' => json_encode($variantData['sizes']),
                        'quantity' => $variantData['quantity'],
                        'price' => $variantData['price'],
                        'selling_price' => $variantData['sellingPrice'],
                        
                    ];

                    // $product->variants()->updateOrCreate(['id'=>$variantData['variant_id']??null], $productVariantsData);

                    
                }
                $product->variants()->delete();
                
                $product->variants()->createMany($productVariantsData);
            }
        }
        

        return redirect()->route('product.index')->with('success', 'Product Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->variants()->delete();
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }
}
