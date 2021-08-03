<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Product;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function home()
    {
        $products = Product::all();
        $data = array();
        foreach ($products as $key => $product) {
            $images = array();

            foreach ($product->images as $image) { 
                array_push($images,asset((Storage::url($image->filename))));
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
        return view('landing', ['products' => json_encode($data)]);
    }
}
