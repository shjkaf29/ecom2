<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductCart;

class UserOrderController extends Controller
{
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
            $order->receiver_phone   = $validated['receiver_number'];
            $order->user_id          = Auth::id();
            $order->product_id       = $productId;
            $order->save();
        }

        ProductCart::where('user_id', Auth::id())->delete();

        return redirect()->back()->with('confirm_order', 'Order has been confirmed!');
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('myorders', compact('orders'));
    }

    public function cancelOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $order->status = 'cancelled';
        $order->save();

        return redirect()->back()->with('order_message', 'Order cancelled successfully.');
    }
}
