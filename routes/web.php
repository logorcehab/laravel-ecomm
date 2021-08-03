<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [ProductController::class, 'index'])
        ->name('admin.index');
    Route::prefix('categories')->group(function () {
        Route::get('/',[ CategoryController::class, 'index'])
            ->name('categories.index');
        Route::post('/',[ CategoryController::class, 'store'])
            ->name('categories.store');
        Route::get('/autocomplete', [ CategoryController::class, 'autocomplete'])
            ->name('categories.autocomplete');
    });
    Route::prefix('brands')->group(function () {
        Route::get('/',[ BrandController::class, 'index'])
            ->name('brands.index');
        Route::post('/',[ BrandController::class, 'store'])
            ->name('brands.store');
        Route::get('/autocomplete', [ BrandController::class, 'autocomplete'])
            ->name('brands.autocomplete'); 
    });
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])
            ->name('products.index');
        Route::get('/new', [ProductController::class, 'create'])
            ->name('products.create');
        Route::post('/new', [ProductController::class, 'store'])
            ->name('products.store');
        Route::delete('/{product}', [ProductController::class, 'destroy'])
            ->name('products.delete');
        Route::get('/edit/{product}', [ProductController::class, 'edit'])
            ->name('products.edit');
        Route::post('/{product}', [ProductController::class, 'update'])
            ->name('products.update');
        Route::get('/{product}', [ProductController::class, 'show'])
            ->name('products.show');
    }); 
});

?>
<?php
?>

<?php




?>


<?php


