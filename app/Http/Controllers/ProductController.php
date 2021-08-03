<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::all();
        $data = array();
        foreach ($products as $key => $product) {
            $images = array();

            foreach ($product->images as $image) { 
                array_push($images,$image->filename);
            }

            $categories = array();
            foreach($product->categories as $category){
                array_push($categories,$category);
            }

            $data[]=[
                'id'=> $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'brands' => $product->brands,
                'categories' => $categories,
                'images' => $images,
            ];
        }
        // TODO Remove json_endoe and decode from products.index
        return view('admin.index',['products'=> json_encode($data)], ['brands'=>Brand::all(), 'categories'=>Category::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.create',['brands'=>Brand::all(), 'categories'=>Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [];
        $photos = count($request->file('photos'));
        foreach(range(0, $photos) as $index) {
            $rules['photos.' . $index] = 'image|mimes:jpeg,bmp,png|max:2000';
        }
        $validated = $request->validate([
            $rules
        ]);
        $brand = Brand::where('name',$request->brand)->first();
        $categories = $request->categories;
        foreach ($categories as $key => $category) {
            $categoryBrandExists = $brand->categories()->where('name',$category)->exists();
            if(!$categoryBrandExists){
                $brand
                    ->categories()
                        ->attach(
                            Category::where('name',$category)
                                ->first()
                                ->id
                        );
            }
        }
        $product = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
            'brands_id' => $brand->id,
        ]);
        $product->brands()->attatch(Brand::where('name',$brand)->first());

        foreach ($request->photos as $photo) {
            $filename = $photo->store('public/photos');
            ProductImage::create([
                'products_id' => $product->id,
                'filename' => $filename
            ]);
        }
        foreach ($categories as $key => $category) {
            $product
            ->categories()
                ->attach(
                    Category::where('name',$category)
                        ->first()
                        ->id
                );
        }
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        // $images = array();

        // foreach ($product->images as $image) { 
        //     array_push($images,Storage::url($image->filename));
        // }

        // $categories = array();
        // foreach($product->categories as $category){
        //     array_push($categories,$category);
        // }

        // $data=array(
        //     'id'=> $product->id,
        //     'name' => $product->name,
        //     'description' => $product->description,
        //     'price' => $product->price,
        //     'quantity' => $product->quantity,
        //     'brand' => $product->brands->name,
        //     'categories' => $categories,
        //     'images' => $images,
        // );
        return view('admin.show',['product'=> $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        return view('admin.edit',['brands'=>Brand::all(), 'categories'=>Category::all(), 'product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // TODO update function
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        foreach ($product->images as $key => $image) {
            Storage::delete($image->filename);
        }
        $product->delete();
        return redirect()->route('products.index');
    }
}
