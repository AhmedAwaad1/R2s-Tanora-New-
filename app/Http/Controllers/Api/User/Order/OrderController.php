<?php

namespace App\Http\Controllers\Api\User\Order;

use App\Helpers\ResponsesHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\Admin\Option;
use App\Models\User\Order\Cart;
use App\Models\User\Order\Order;
use App\Models\User\Order\OrderProduct;
use App\Models\User\Order\OrderProductOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ResponsesHelper;

    public function __construct()
    {
        $this->middleware(['auth:api']);

    }

    public function createWithoutOption(CreateRequest $request)
    {
        $carts = (new CartController())->index(false);

        if (count($carts) == 0) {
            return $this->fail(400, 'Cart is not Found');
        }

        $total_price = 0;
        $options = [];
        $cardIds = [];

        foreach ($carts as $cart) {
            $cardIds[] = $cart->id;
            $item_price = $cart->product->price;
            $item_option = [];

            foreach ($cart->options as $option) {
                $item_price += $option->price * $cart->qty;
                $item_option [] = new OrderProductOptions([
                    'name' => $option->name,
                    'price' => $option->price
                ]);
            }
            $total_price += $cart->qty * $item_price;

            $options[] = [
                'product_id' => $cart->product->id,
                'total_item_price' => $item_price * $cart->qty,
                'price' => $item_price,
                'qty' => $cart->qty,
                'name' => $cart->product->name,
                'image' => str_replace(url('/uploads'), '', $cart->product->image),
                'created_at' => now(),
                'updated_at' => now(),
                'options' => $item_option
            ];

        }


        $request->merge([
            'total_price' => $total_price,
            'user_id' => Auth::id(),
            'code' => rand(10000, 99999),
            'status' => 'pending',
            'options' => $options,
            'card_ids' => $cardIds
        ]);
        $order = Order::create($request->only([
            'total_price', 'user_id', 'lng', 'lat', 'date', 'time',
            'address', 'status', 'name', 'phone', 'code', 'options', 'card_ids'
        ]));


        foreach ($options as $option) {

            $orderProduct = OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $option['product_id'],
                'total_item_price' => $option['total_item_price'],
                'price' => $option['price'],
                'qty' => $option['qty'],
                'name' => $option['name'],
                'image' => $option['image'],
                'created_at' => $option['created_at'],
                'updated_at' => $option['updated_at']

            ]);

            foreach ($option['options'] as $orderProductOption) {
                OrderProductOptions::create([
                    'order_product_id' => $orderProduct->id,
                    'option_id' => $orderProductOption['option_id'],
                ]);
            }
        }

        Cart::where('id', $cardIds)->delete();
        return $this->success($request->all(), 'Order Successfully Created');

    }

    public function create(CreateRequest $request)
    {
        //get cart items
        //merge order data
        //create order
        //loop, calculate and create orderProduct
        //loop, calculate and create orderProductOption
        //update Order total price
        //clear user cart and cartOption

        $cartProducts = Cart::where('user_id', Auth::id())
            ->with('options', 'product')
            ->get();

        $orderData = [
            'user_id' => Auth::id(),
            'code' => rand(9000, 100000),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'lat' => $request->input('lat'),
            'lng' => $request->input('lng'),
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'status' => 'pending',
            'total_price' => 0,
            'phone' => $request->input('phone')
        ];
        $total = 0;
        $order = Order::create($orderData);
        $cartIds = [];
        foreach ($cartProducts as $cartProduct) {

            $optionsPrice = $cartProduct->options()->sum('price');
            $product = $cartProduct->product;
            $cartIds[] = $cartProduct->id;
            $orderProduct = OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $cartProduct['product_id'],
                'total_item_price' => ($optionsPrice + $cartProduct->product->price) * $cartProduct->qty,
                'price' => $optionsPrice + $cartProduct->product->price,
                'qty' => $cartProduct['qty'],
                'name' => $product->name,
                'image' => $product->image,
                'created_at' => $cartProduct['created_at'],
                'updated_at' => $cartProduct['updated_at']
            ]);

            $total += ($optionsPrice + $cartProduct->product->price) * $cartProduct->qty;

            foreach ($cartProduct->options as $option) {
                OrderProductOptions::create([
                    'order_product_id' => $orderProduct->id,
                    'option_id' => $option->id
                ]);
            }
        }
        $order->update(['total_price' => $total]);

        Cart::where('id', $cartIds)->delete();
        DB::table('carts_options')
            ->whereIn('cart_id', $cartIds)
            ->delete();
        return $this->success($order, 'Order Successfully Created');


    }

    public function update(UpdateRequest $request, $id)
    {
       $order = Order::find($id);
        if (!$order) {
            return $this->fail(400, 'order is not exists');
        }
        $order->update($request->only('status'));
        return $this->success($order, 'Order Successfully Updated');
    }

    public function delete($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return $this->fail(400, 'order is not found');
        }
        $order->orderProducts()->delete();
        return $this->success(['is_success' => $order->delete()]);
    }

    public function get($id)
    {

        $order = Order::with(['user',
            'orderProducts:id,order_id,product_id,name,price,total_item_price,image,qty',
            'orderProducts.orderProductOptions:id,name,price'
        ])
            ->where('id', $id)
            ->first();

        return $this->success($order);
    }

}
