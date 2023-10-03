<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\User;
use App\Models\User\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderProducts.orderProductOptions', 'orderProducts.product'])
            ->get();

        return view('admin.order.index', compact('orders'));
    }

    public function edit($id)
    {
        $order = Order::with('orderProducts', 'orderProducts.product.category')->where('id', $id)->first();
        return view('admin.order.edit', compact('order'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $order = Order::with('orderProducts')->where('id', $id)->first();

        if (!$order)
        {
            return redirect('/admin/orders')
              ->with('alert-fail', 'Order Status is not Updated' );
        }
        $order->update($request->only(['status']));
        return redirect('/admin/orders')
            ->with('alert-success', 'Order Status Has been Updated');
    }

    public function delete($id)
    {
        $order = Order::with('orderProducts')->where('id', $id)->first();

        if (!$order)
        {
            return redirect('admin/orders')
                ->with('alert-fail', 'Order Can Not be Found');
        }
        $order->delete();
        return redirect('admin/orders')
            ->with('alert-success', 'Order has been Deleted');
    }
}
