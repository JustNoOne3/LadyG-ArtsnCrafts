<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/banners/{banner}/impression', function (App\Models\Banner\Content $banner) {
    $banner->trackImpression();
    return response()->json(['success' => true]);
});

Route::post('/banners/{banner}/click', function (App\Models\Banner\Content $banner) {
    $banner->trackClick();
    return response()->json(['success' => true]);
});

Route::get('/products', function (Request $request) {
    $query = Product::query();
    if ($request->brand) {
        $query->where('product_brand', $request->brand);
    }
    if ($request->category) {
        $query->where('product_category', $request->category);
    }
    switch ($request->sort) {
        case 'price_asc':
            $query->orderBy('product_price', 'asc');
            break;
        case 'price_desc':
            $query->orderBy('product_price', 'desc');
            break;
        case 'sold_desc':
            $query->orderBy('product_soldCount', 'desc');
            break;
        case 'created_at_asc':
            $query->orderBy('created_at', 'asc');
            break;
        case 'created_at_desc':
        default:
            $query->orderBy('created_at', 'desc');
            break;
    }
    $perPage = $request->input('perPage', 15);
    $products = $query->paginate($perPage);
    // Add thumbnail URL
    $products->getCollection()->transform(function ($product) {
        $product->product_thumbnail_url = $product->product_thumbnail ? asset('storage/' . $product->product_thumbnail) : null;
        return $product;
    });
    return response()->json($products);
});


Route::get('/brands', function () {
    return Brand::all();
});

Route::get('/brands/{id}', function ($id) {
    $brand = Brand::findOrFail($id);
    return response()->json($brand);
});

Route::get('/categories', function () {
    return Category::all();
});
