<?php

namespace App\Http\Controllers\Api\User\Product;

use App\Helpers\ResponsesHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponsesHelper;

    public function index(Request $request)
    {
        $products = Product::Orderby('id');

        if ($request->keyword)
        {
            $products->where('name', 'like', '%'.$request->keyword.'%');
        }
        return $this->success($products->paginate());
    }

}
