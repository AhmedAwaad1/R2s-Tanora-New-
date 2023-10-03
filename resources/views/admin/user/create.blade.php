@extends('layouts.admin')
@section('userCreate')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create User</div>

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
                        <form method="POST" action="{{url('/admin/users')}}" enctype="multipart/form-data">
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
                                <input type="text" id="name" name="name" class="form-control" />
                                <label class="form-label" for="name">Name</label>
                            </div>
                            <div class="mb-3">
                                <input type="tel" id="phone" name="phone" class="form-control" />
                                <label class="form-label" for="phone">Phone</label>
                            </div>
                            <div class="mb-3">
                               <input type="password" id="password" name="password" class="form-control" />
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <div class="mb-3">
                                <input type="email" id="email" name="email" class="form-control" />
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

