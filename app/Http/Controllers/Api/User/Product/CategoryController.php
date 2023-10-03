<?php

namespace App\Http\Controllers\Api\User\Product;

use App\Helpers\ResponsesHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ResponsesHelper;

    public function index(Request $request)
    {
        $category = Category::Orderby('id');

        if ($request->keyword)
        {
            $category->where('name', 'like', '%'.$request->keyword .'%');
        }
        return $this->success($category->paginate());
    }

}
