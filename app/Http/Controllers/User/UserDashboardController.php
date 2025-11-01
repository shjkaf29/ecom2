<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class UserDashboardController extends Controller
{
   public function home(){
    if (Auth::check()) {
        if (Auth::user()->user_type === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->user_type === 'user') {
            return redirect()->route('user.dashboard');
        }
    }

    $products = Product::latest()->take(8)->get();
    $count = 0;

    return view('frontend.index', compact('products', 'count'));
    }

    public function index() {
    return $this->home();
    }
}
