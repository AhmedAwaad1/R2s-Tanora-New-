<?php

namespace App\Http\Controllers\Api\User\Product;

use App\Helpers\ResponsesHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    use ResponsesHelper;
    public function index(Request $request)
    {
        $options = Option::Orderby('id');

        if ($request->keyword)
        {
            return $options->where('name', 'like', '%'.$request->keyword.'%' );
        }
        return $this->success($options->paginate());
    }

}
