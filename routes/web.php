<?php
require_once __DIR__.'/api-cart.php';
use App\Livewire\SuperDuper\BlogList;
use App\Livewire\SuperDuper\BlogDetails;
use App\Livewire\SuperDuper\Pages\ContactUs;
use Illuminate\Support\Facades\Route;
use Lab404\Impersonate\Services\ImpersonateManager;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantSub;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\ShippingOptions;
use App\Models\PaymentDetails;
use App\Http\Controllers\ShippingDetailsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FileUploadController;

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
    // dd(auth()->user());
    return view('welcome');
})
    ->middleware('web')
    ->name('home');



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

Route::get('/about-us', function() {
    return view('pages.about-us');
})->name('about-us');

Route::get('/login', function() {
    return view('auth.login-pg');
})
->middleware('guest')
->name('login');

// Handle login POST
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
});

Route::post('/logout', function () {
    \Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('web');

Route::get('/signup', function() {
    return view('auth.sign-up');
})
->middleware('guest')
->name('signup');

// Google OAuth Redirect
Route::get('/auth/redirect/{provider}', function ($provider) {
    return Socialite::driver($provider)->redirect();
})
->middleware('guest')
->name('socialite.redirect');

// Google OAuth Callback
Route::get('/auth/callback/{provider}', function ($provider) {
    $socialUser = Socialite::driver($provider)->stateless()->user();
    $user = User::firstOrCreate([
        'email' => $socialUser->getEmail(),
    ], [
        'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? $socialUser->getEmail(),
        'password' => '',
    ]);
    Auth::login($user);
    return redirect()->intended('/');
})->name('socialite.callback');


// AJAX endpoint for adding to cart
Route::post('/cart/add', function(Request $request) {
    $validated = $request->validate([
        'product_id' => 'required|integer|exists:products,id',
        'variant_id' => 'nullable|integer',
        'subvariant_id' => 'nullable|integer',
        'quantity' => 'required|integer|min:1',
    ]);
    if (!auth()->check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    Cart::create([
        'cart_user' => auth()->id(),
        'cart_product' => $validated['product_id'],
        'cart_variant' => $validated['variant_id'],
        'cart_subVariant' => $validated['subvariant_id'],
        'cart_quantity' => $validated['quantity'],
    ]);
    return response()->json(['success' => true]);
})->name('cart.add');

Route::get('/cart/view', function() {
    return view('pages.cart');
})->name('cart.view');


// Authenticated AJAX endpoint for fetching cart items
Route::get('/api/cart/items', function(Request $request) {
    if (!Auth::check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    $cartItems = Cart::where('cart_user', Auth::id())
        ->with([
            'product:id,product_name,product_thumbnail,product_price',
            'variant:id,variant_name',
            'subvariant:id,subvar_name,subvar_price',
        ])->get()->map(function($item) {
            $price = $item->subvariant && $item->subvariant->subvar_price !== null
                ? $item->subvariant->subvar_price
                : ($item->product->product_price ?? 0);
            return [
                'id' => $item->id,
                'product_name' => $item->product->product_name ?? '',
                'product_thumbnail' => $item->product->product_thumbnail ?? '',
                'product_price' => $price,
                'variant_name' => $item->variant->variant_name ?? '',
                'subvariant_name' => $item->subvariant->subvar_name ?? '',
                'quantity' => $item->cart_quantity,
            ];
        });
    return response()->json($cartItems);
})->middleware(['web', 'auth']);

// POST: Receive selected cart item IDs, store in session, redirect to checkout
Route::post('/cart/checkout', function(Request $request) {
    $ids = $request->input('selected', []);
    if (!is_array($ids) || empty($ids)) {
        return redirect()->route('cart.view')->with('error', 'No items selected for checkout.');
    }
    // Store selected cart item IDs in session
    session(['checkout_cart_ids' => $ids]);
    return redirect()->route('checkout.page');
})->middleware(['web', 'auth'])->name('cart.checkout');

// GET: Show checkout page with selected items, shipping options, and payment details
Route::get('/checkout', function() {
    $ids = session('checkout_cart_ids', []);
    if (empty($ids)) {
        return redirect()->route('cart.view')->with('error', 'No items selected for checkout.');
    }
    $cartItems = Cart::whereIn('id', $ids)
        ->where('cart_user', Auth::id())
        ->with([
            'product:id,product_name,product_thumbnail,product_price',
            'variant:id,variant_name',
            'subvariant:id,subvar_name,subvar_price',
        ])->get()->map(function($item) {
            $price = $item->subvariant && $item->subvariant->subvar_price !== null
                ? $item->subvariant->subvar_price
                : ($item->product->product_price ?? 0);
            return [
                'id' => $item->id,
                'product_name' => $item->product->product_name ?? '',
                'product_thumbnail' => $item->product->product_thumbnail ?? '',
                'product_price' => $price,
                'variant_name' => $item->variant->variant_name ?? '',
                'subvariant_name' => $item->subvariant->subvar_name ?? '',
                'quantity' => $item->cart_quantity,
            ];
        })->values();

    $shippingOptions = ShippingOptions::all();
    $paymentDetails = PaymentDetails::all();

    return view('pages.checkout', [
        'checkoutItems' => $cartItems,
        'shippingOptions' => $shippingOptions,
        'paymentDetails' => $paymentDetails,
    ]);
})->middleware(['web', 'auth'])->name('checkout.page');


// AJAX: Save shipping address
Route::post('/shipping-details/save', [ShippingDetailsController::class, 'save'])->middleware(['web', 'auth']);
// AJAX: List shipping addresses
Route::get('/shipping-details/list', [ShippingDetailsController::class, 'list'])->middleware(['web', 'auth']);
// AJAX: Update shipping address
Route::post('/shipping-details/update', [ShippingDetailsController::class, 'update'])->middleware(['web', 'auth']);

Route::post('/checkout/submit', [CheckoutController::class, 'submit'])->name('checkout.submit')->middleware('auth');

Route::post('/file-upload/tmp', [FileUploadController::class, 'tmpUpload'])->middleware(['web', 'auth']);

// Checkout success page
Route::get('/checkout/success/{order}', function($orderId) {
    $order = \App\Models\Order::findOrFail($orderId);
    $shippingOption = null;
    if ($order->order_shippingMethod) {
        $shippingOption = \DB::table('shipping_options')->where('id', $order->order_shippingMethod)->first();
    }
    $shippingDetails = null;
    if ($order->order_shippingAddress) {
        $shippingDetails = \App\Models\ShippingDetails::find($order->order_shippingAddress);
    }
    return view('pages.checkout-success', [
        'order' => $order,
        'shippingOption' => $shippingOption,
        'shippingDetails' => $shippingDetails,
    ]);
})->name('checkout.success')->middleware('auth');

Route::get('my-orders', function() {
    $orders = \App\Models\Order::where('order_userId', Auth::id())->orderByDesc('created_at')->get();
    return view('pages.my-orders', compact('orders'));
})->name('my-orders')->middleware('auth');

// My Orders page
Route::get('/my-orders', function() {
    $orders = \App\Models\Order::where('order_userId', auth()->id())
        ->orderByDesc('created_at')
        ->get();
    return view('pages.my-orders', [
        'orders' => $orders
    ]);
})->name('my-orders')->middleware('auth');