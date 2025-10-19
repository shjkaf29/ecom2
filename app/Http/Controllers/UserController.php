<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        if(Auth::check() && Auth::user()->user_type=="user")
            {
                return view('dashboard');
            }

        else if(Auth::check() && Auth::user()->user_type=="admin"){
            return view('admin.dashboard');
        }
        
    }

    public function home(){
        $count = ProductCart::where('user_id',Auth::id())->count();
        $products = Product::all();
        return view('index',compact('products','count'));
    }

    public function productDetails($id){
        if(Auth::check()){
            $count = ProductCart::where('user_id', Auth::id())->count();
        }
        else{
            $count = '';
        }
        $product = Product::findOrFail($id);
        return view('product_details', compact('product'));
    }

    public function addToCart($id){
        $product = Product::findOrFail($id);
        $product_cart = new ProductCart();
        $product_cart->user_id = Auth::id();
        $product_cart->product_id = $product->id;

        $product_cart->save();

        return redirect()->back()->with("cart_message", "added to the cart");
    }

    public function cartProducts(){
        if(Auth::check()){
            $count = ProductCart::where('user_id', Auth::id())->count();
            $cart = ProductCart::where('user_id', Auth::id())->get();
        }
        else{
            $count = '';
        }

        return view('viewcartproduct',compact('count','cart'));
    }

    public function removeCart($id){

        $product = ProductCart::findOrFail($id);

        $product->delete();

        return redirect()->back();

    }

    public function confirmOrder(Request $request)
{
    $validated = $request->validate([
        'receiver_address' => 'required|string|max:255',
        'receiver_number'  => 'required|string|max:20',
        'product_ids'      => 'required|array',
    ]);

    foreach ($validated['product_ids'] as $productId) {
        $order = new Order();
        $order->receiver_address = $validated['receiver_address'];
        $order->receiver_phone   = $validated['receiver_number']; // match field name
        $order->user_id          = Auth::id();
        $order->product_id       = $productId;
        $order->save();
    }

    $cart = ProductCart::where('user_id',Auth::id())->get();

    foreach($cart as $cart){
        $cart_id = ProductCart::find($cart->id);
        $cart_id->delete();
    }

    return redirect()->back()->with('confirm_order', 'Order has been confirmed!');
}

}
