<?php

use App\Livewire\SuperDuper\BlogList;
use App\Livewire\SuperDuper\BlogDetails;
use App\Livewire\SuperDuper\Pages\ContactUs;
use Illuminate\Support\Facades\Route;
use Lab404\Impersonate\Services\ImpersonateManager;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantSub;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');



Route::get('impersonate/leave', function() {
    if(!app(ImpersonateManager::class)->isImpersonating()) {
        return redirect('/');
    }

    app(ImpersonateManager::class)->leave();

    return redirect(
        session()->pull('impersonate.back_to')
    );
})->name('impersonate.leave')->middleware('web');

// SEO Routes
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [App\Http\Controllers\SitemapController::class, 'robots'])->name('robots');

// Product View Route
Route::get('/product/{id}', function ($id) {
    $product = Product::findOrFail($id);
    $variants = VariantSub::select(['subvar_image'])->where('subvar_productId', $id)->get();
    $images = [];
    if ($product->product_images) {
        $imgs = json_decode($product->product_images, true);
        if (is_array($imgs)) {
            foreach ($imgs as $img) {
                $images[] = asset('storage/' . $img);
            }
        }
    }
    if($variants->isNotEmpty()) {
        foreach ($variants as $variant) {
            if ($variant->subvar_image) {
                $images[] = asset('storage/' . $variant->subvar_image);
            }
        }
    }
    if (empty($images)) {
        $images[] = asset('storage/' . $product->product_thumbnail);
    }
    $mainImage = $images[0] ?? asset('storage/' . $product->product_thumbnail);

    $variants = Variant::where('variant_productId', $id)->get();
    $subvariants = VariantSub::where('subvar_productId', $id)->get();

    return view('pages.product-view', compact('product', 'images', 'mainImage', 'variants', 'subvariants'));
})->name('product.view');

Route::get('/shop/{id}', function($id) {
    return view('pages.shop-view', compact('id'));
})->name('shop.view');
