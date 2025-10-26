<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductCart;

class UserCartController extends Controller
{
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $cart = new ProductCart();
        $cart->user_id = Auth::id();
        $cart->product_id = $product->id;
        $cart->save();

        return redirect()->back()->with('cart_message', 'Product added to cart!');
    }

    public function cartProducts()
    {
        $count = Auth::check() ? ProductCart::where('user_id', Auth::id())->count() : 0;
        $cart = ProductCart::where('user_id', Auth::id())->get();

        return view('viewcartproduct', compact('count', 'cart'));
    }

    public function removeCart($id)
    {
        ProductCart::findOrFail($id)->delete();
        return redirect()->back()->with('cart_message', 'Product removed from cart.');
    }
}
