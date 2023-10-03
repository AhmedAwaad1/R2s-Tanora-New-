@extends('layouts.admin')
@section('OrderEdit')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Product Details</div>

                    <div class="card-body">
                        @if (session('alert-success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('alert-success') }}
                            </div>
                        @endif
                        @if (session('alert-fail'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('alert-fail') }}
                            </div>
                        @endif
                        <div>
                            <form method="POST" action="{{ url('/admin/orders/'.$order->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="_method" value="PUT">

                                @foreach($order->orderProducts as $orderProduct)
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="p-5 mb-4 bg-light rounded-3">
                                                <div class="container-fluid py-5">
                                                    <h1 class="display-5 fw-bold">Order Details</h1>
                                                    <p class="col-md-8 fs-4">Product Name: {{ $orderProduct->name }}</p>
                                                    <p class="col-md-8 fs-4">Product
                                                        Quantity: {{ $orderProduct->qty }}</p>
                                                    @foreach($orderProduct->orderProductOptions as $ProductOption)
                                                        <p class="col-md-8 fs-4">Product
                                                            Options: {{ $ProductOption->name }}</p>
                                                        <p class="col-md-8 fs-4">Product
                                                            Price: {{ $ProductOption->price }}</p>
                                                    @endforeach
                                                    <p>Product
                                                        Category: {{ $orderProduct->product->category->name }}</p>
                                                    <p>Product Name: {{ $orderProduct->product->name }}</p>
                                                    <p>Product Price: {{ $orderProduct->product->price }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="h-100 p-5 bg-light border rounded-3">
                                                <h2>User Detail</h2>
                                                <p>User Name: {{ $order->name }}</p>
                                                <p>User ID: {{ $order->user_id }}</p>
                                                <p>Order Code: {{ $order->code}}</p>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-md-4">
                                    <div class="form-group">
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors-> all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div>
                                            <table id="productsTable" class="table table-hover table-product"
                                                style="width: 100%"
                                            >
                                                <thead>
                                                <tr>
                                                    <th style="width: max-content;">Name</th>
                                                    <th  style="width: max-content;">Price</th>
                                                    <th  style="width: max-content;">Qty</th>
                                                    <th  style="width: 50%;">Additional Options</th>
                                                    <th  style="width: max-content;">Item Price</th>
                                                    <th  style="width: max-content;">Total Price</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($order->orderProducts as $order_product)
                                                    <tr>
                                                        @php
                                                            $totalOptionPrice = 0
                                                        @endphp
                                                        <td class="text-center">{{$order_product->name }}</td>
                                                        <td class="text-center">{{ $order_product->price }}</td>
                                                        <td class="text-center">{{ $order_product->qty }}</td>
                                                        <td class="text-center">
                                                        @foreach ($order_product->orderProductOptions as $option)
                                                                <button class="btn btn-primary">
                                                                    {{ $option->name }}
                                                                </button>
                                                        @endforeach
                                                        </td>

                                                        <td class="text-center">{{  $order_product->price }}</td>
                                                        <td class="text-center">{{ $order_product->total_item_price }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <label for="status" class="form-label">Status:</label>
                                        <select type="text" id="product" name="status" class="form-control">
                                            <option
                                                value="pending" {{ $order_product->status == 'pending' ? 'selected="true"' : '' }}>
                                                pending
                                            </option>
                                            <option
                                                value="approved" {{ $order_product->status == 'approved' ? 'selected="true"' : '' }}>
                                                approved
                                            </option>
                                        </select>

                                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
@endsection
