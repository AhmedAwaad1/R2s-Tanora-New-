<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catergory\CreateRequest;
use App\Http\Requests\Catergory\UpdateRequest;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create()
    {

        return view('admin.category.create');
    }

    public function store(CreateRequest $request)
    {
        Category::create($request->only([
            'name', 'image'
        ]));

        $request->session()->flash('alert-success', 'Item Created Successfully');
        return redirect('/admin/categories');
    }

    public function update(UpdateRequest $request, $id)
    {

        $category = Category::where('id', $id)
            ->first();

        if (!$category) {
            return redirect('/admin/categories')
            ->with('alert-fail', 'Item is not Created' );
        }

        $request->session()->flash('alert-success', 'Item Saved Successfully');
        return redirect('/admin/categories');
    }

    public function edit($id)
    {
        return view('admin.category.edit', ['category' => Category::find($id)]);
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return view('admin.category.index')
                ->with('message', 'Item Is Not Found');
        }
        $category->delete();
        return redirect('/admin/categories')
            ->with('alert-success', 'Category has Been Deleted');
    }

    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index',compact('categories'));
    }
}
