@extends('layouts.admin')
@section('userEdit')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit User</div>

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
                        <form method="POST" action="{{url('/admin/users/'.$user->id)}}" enctype="multipart/form-data">
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
                                <input type="text"  name="name" class="form-control" value="{{ $user->name }}"/>
                                <label class="form-label" for="name">Name</label>
                            </div>
                            <div class="mb-3">
                                <input type="tel"  name="phone" class="form-control" value="{{ $user->phone }}"/>
                                <label class="form-label" for="phone">Phone</label>
                            </div>
                            <div class="mb-3">
                                <input type="email"  name="email" class="form-control" value="{{ $user->email }}"/>
                                <label class="form-label" for="email">Email address</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

