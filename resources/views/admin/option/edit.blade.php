@extends('layouts.admin')
@section('OptionEdit')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Option</div>

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

                        <form method="POST" action="{{url('/admin/options/'.$option->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Option Name : </label>
                                <input type="text" name="name" class="form-control" value="{{$option->name}}" placeholder="name...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <select type="text" id="product_id" name="product" class="form-control" >

                                @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" name="price" class="form-control" placeholder="price..." value="{{$option->price}}">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

