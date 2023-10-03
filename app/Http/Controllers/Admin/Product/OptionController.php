<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Option\CreateRequest;
use App\Http\Requests\Option\UpdateRequest;
use App\Models\Admin\Option;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class OptionController extends Controller
{

    public function index()
    {
        $options = Option::with('product')
            ->get();
        return view('admin.option.index', compact('options'));
    }

    public function create()
    {
        $products = Product::get(['id', 'name']);

        return view('admin.option.create', compact('products'));
    }

    public function store(CreateRequest $request)
    {
        Option::create($request->only([
            'name', 'price', 'product_id'
        ]));
        return redirect('admin/options');
    }

    public function edit($id)
    {
        $products = Product::get(['id', 'name']);
        $option = Option::find($id);
        return view('admin.option.edit' , compact('products','option'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $option = Option::where('id', $id)
        ->first();
        if (!$option) {
            return redirect('admin/products')
                ->with('alert-fail', 'item not found');
        }
        $option->update($request->only([
            'name', 'price'
        ]));
        return redirect('admin/options');
    }

    public function delete($id)
    {
        $option = option::find($id);

        if (!$option) {
            return redirect('admin/options')
                ->with('alert-fail', 'item not found');
        }
        $option->delete();
        return redirect('/admin/options')
            ->with('alert-success', 'Option has been deleted');
    }
}
