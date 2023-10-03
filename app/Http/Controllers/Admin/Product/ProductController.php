<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Admin\Option;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function create()
    {

        $categories = Category::get(['id', 'name']);
        return view('admin.product.create', compact('categories'));
    }

    public function store(CreateRequest $request)
    {
        Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'image' => $request->file('image'),
            'category_id' => $request->input('category_id')
        ]);
        $request->session()->flash('alert-success', 'Item have been Created');
        return redirect('/admin/products');
    }

    public function update(UpdateRequest $request, $id)
    {
        $product = Product::where('id', $id)
            ->first();

        if (!$product)
        {
            return redirect('/admin/products')
                ->with('alert-fail', 'Item is not Updated' );
        }

        $product->update($request->only([
            'name', 'price', 'image', 'category_id'
        ]));
        $request->session()->flash('alert-success', 'Item have been Updated');
        return redirect('/admin/products');
    }
    public function edit($id)
    {
        $categories = Category::get(['id', 'name']);
        return view('admin.product.edit', ['product' => Product::find($id)], compact('categories'));
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if (!$product)
        {
            return view('admin.product.index')
                ->with('alert-fail', 'Product is not deleted');
        }
        $product->delete();
            return redirect('/admin/products')
            ->with('alert-success', 'Product has been deleted');
    }

    public function index()
    {

        $products = Product::with(['category:id,name,image','options:id,name,product_id'])
            ->get();

        return view('admin.product.index', compact('products'));
    }

}
