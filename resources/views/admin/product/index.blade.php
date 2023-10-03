@extends('layouts.admin')
@section('content_Product')
    {{--    @section('title', 'Admin Dashboard')--}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        #outer {
            display: flex;
        }
    </style>

    <div class="content-wrapper">
        <div class="content">
            <!-- Table Product -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card">
                            <div class="card-header card-header-boarder-bottom d-flex justify-content-between">
                                <a href="/admin/products/create" class="btn btn-primary btn-sm">Create Product</a>
                            </div>
                            <div class="card-header">
                                <h2>Products</h2>

                            </div>
                            <div class="card-body">
                                @if(session('alert-success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('alert-success') }}
                                    </div>
                                @endif

                                @if(count($products)>0)
                                    <table id="productsTable" class="table table-hover table-product"
                                           style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Product Option</th>
                                            <th>Category Name</th>
                                            <th>Price</th>
                                            <th>Image</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($products as $product)
                                            <tr>

                                                <td>{{ $product->name }}</td>
                                                <td>
                                                    @foreach($product->options as $option)
                                                        <i>{{$option->name}}</i><br>
                                                    @endforeach
                                                </td>
                                                <td>{{ $product->category->name }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td class="py-0">
                                                    <img src="{{ $product->image }}" alt="Product Image">
                                                </td>
                                                <td id="outer">
                                                    <a href="{{ url('admin/products/edit/'.$product->id) }}"
                                                       class="btn btn-success btn-sm inner"><i class="fas fa-edit"></i></a>
                                                    <form method="POST"
                                                          action="{{url('admin/products/'.$product->id)}}"
                                                          class="inner">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <h4 class="text-danger text-center text-bold">No Product Found</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Stock Modal -->
                <div class="modal fade modal-stock" id="modal-stock" aria-labelledby="modal-stock" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                        <form action="#">
                            <div class="modal-content">
                                <div class="modal-header align-items-center p3 p-md-5">
                                    <h2 class="modal-title" id="exampleModalGridTitle">Add Stock</h2>
                                    <div>
                                        <button type="button" class="btn btn-light btn-pill mr-1 mr-md-2"
                                                data-dismiss="modal"> cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary  btn-pill" data-dismiss="modal">
                                            save
                                        </button>
                                    </div>

                                </div>
                                <div class="modal-body p3 p-md-5">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h3 class="h5 mb-5">Product Information</h3>
                                            <div class="form-group mb-5">
                                                <label for="new-product">Product Title</label>
                                                <input type="text" class="form-control" id="new-product"
                                                       placeholder="Add Product">
                                            </div>
                                            <div class="form-row mb-4">
                                                <div class="col">
                                                    <label for="price">Price</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">$</span>
                                                        </div>
                                                        <input type="text" class="form-control" id="price"
                                                               placeholder="Price" aria-label="Price"
                                                               aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="sale-price">Sale Price</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">$</span>
                                                        </div>
                                                        <input type="text" class="form-control" id="sale-price"
                                                               placeholder="Sale Price" aria-label="SalePrice"
                                                               aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="product-type mb-3 ">
                                                <label class="d-block" for="sale-price">Product Type <i
                                                        class="mdi mdi-help-circle-outline"></i> </label>
                                                <div>

                                                    <div class="custom-control custom-radio d-inline-block mr-3 mb-3">
                                                        <input type="radio" id="customRadio1" name="customRadio"
                                                               class="custom-control-input" checked="checked">
                                                        <label class="custom-control-label" for="customRadio1">Physical
                                                            Good</label>
                                                    </div>

                                                    <div class="custom-control custom-radio d-inline-block mr-3 mb-3">
                                                        <input type="radio" id="customRadio2" name="customRadio"
                                                               class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio2">Digital
                                                            Good</label>
                                                    </div>

                                                    <div class="custom-control custom-radio d-inline-block mr-3 mb-3">
                                                        <input type="radio" id="customRadio3" name="customRadio"
                                                               class="custom-control-input">
                                                        <label class="custom-control-label"
                                                               for="customRadio3">Service</label>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="editor">
                                                <label class="d-block" for="sale-price">Description <i
                                                        class="mdi mdi-help-circle-outline"></i></label>
                                                <div id="standalone">
                                                    <div id="toolbar">
                                  <span class="ql-formats">
                                    <select class="ql-font"></select>
                                    <select class="ql-size"></select>
                                  </span>
                                                        <span class="ql-formats">
                                    <button class="ql-bold"></button>
                                    <button class="ql-italic"></button>
                                    <button class="ql-underline"></button>
                                  </span>
                                                        <span class="ql-formats">
                                    <select class="ql-color"></select>
                                  </span>
                                                        <span class="ql-formats">
                                    <button class="ql-blockquote"></button>
                                  </span>
                                                        <span class="ql-formats">
                                    <button class="ql-list" value="ordered"></button>
                                    <button class="ql-list" value="bullet"></button>
                                    <button class="ql-indent" value="-1"></button>
                                    <button class="ql-indent" value="+1"></button>
                                  </span>
                                                        <span class="ql-formats">
                                    <button class="ql-direction" value="rtl"></button>
                                    <select class="ql-align"></select>
                                  </span>
                                                    </div>
                                                </div>
                                                <div id="editor"></div>

                                                <div class="custom-control custom-checkbox d-inline-block mt-2">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="customCheck2">
                                                    <label class="custom-control-label" for="customCheck2">Hide product
                                                        from published site</label>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFile"
                                                       placeholder="please imgae here">
                                                <span class="upload-image">Click here to <span class="text-primary">add product image.</span> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
@endsection
