<?php

namespace App\Http\Controllers\Api\User\Order;

use App\Helpers\ResponsesHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CreateRequest;
use App\Http\Requests\Cart\UpdateRequest;
use App\Models\User\Order\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use ResponsesHelper;

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function create(CreateRequest $request)
    {
        $request->merge(['user_id' => Auth::id()]);

        $cart = Cart::create($request->only([
            'product_id', 'qty', 'user_id'
        ]));
        //cart options

        if ($request->options) {
            $cart->options()->sync($request->options);
        }
        return $this->success(['is_success' => 1], 'Cart Has been Created');
    }

    public function update(UpdateRequest $request, $id)
    {

        $cart = Cart::where('id', $id)
            ->first();

        if (!$cart) {
            return $this->fail(400, 'Cart Cant be Found');
        }

        return $this->success(['is_success' => $cart->update($request->only(['qty']))]);
    }

    public function delete($id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart) {
            return $this->fail(400, 'Cart Is Not Found');
        }
        return $this->success(['is_success' => $cart->delete()], 'Cart Has Been Deleted');
    }

    public function index($returnJason = true)
    {
        $carts = Cart::where('user_id', Auth::id())
            ->with('product', 'options')
            ->get();
        if ($returnJason)
            return $this->success($carts);

        return ($carts);
    }

}
