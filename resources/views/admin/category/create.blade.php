@extends('layouts.admin')
@section('CategoryCreate')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create Category</div>

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

                        <form method="POST" action="{{url('/admin/categories')}}" enctype="multipart/form-data">
                            @csrf
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
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="name...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
