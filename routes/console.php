<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductImage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('gen:fake', function () {
    $brands = Brand::factory()
        ->create();
    $products = Product::factory()
        ->count(random_int(2,4))
        ->for($brands, 'brands')
        ->create();
    $categories = Category::factory()
        ->hasAttached($products)
        ->hasAttached($brands)
        ->count(random_int(2,4))
        ->create();
    foreach ($products as $key => $product)
    {
        $images = ProductImage::factory()
            ->count(random_int(1,5))
            ->for($product ,'products')
            ->create();
    }
    
});