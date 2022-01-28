
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
    @include('management.inc.sidebar')
        <div class="col-md-8"><i class="fas fa-align-justify"></i> Edit a Category
        <!-- <a  href="category/create" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Create Category</a> -->
        <hr>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>

            </div>

        @endif
        <form action="/management/category/{{$category->id}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <lable for="categoryName">Category Name</lable>
                <input type="text" value="{{$category->name}}" class="form-control" placeholder="Category Name..." name="name">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    </div>
</div>

@endsection

