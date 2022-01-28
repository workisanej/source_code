
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
    @include('management.inc.sidebar')
        <div class="col-md-8"><i class="fas fa-hamburger"></i> Create a Menu
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
        <form action="/management/menu" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="form-group">
                <lable for="menuName">Menu Name</lable>
                <input type="text" class="form-control" placeholder="Menu Name..." name="name">
            </div>
            <lable for="menuPrice">Price</lable>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">R</span>
                </div>
                <input type="text" class="form-control" aria-label="Amount (to the nearest dollor)" name="price">
                <div class="input-group-append">
                    <span class="input-group-text">.00</span>
                </div>
            </div>
            <label for="MenuImage">Image</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Upload</span>
            </div>
            <div class="custom-file">
              <input type="file" name="image" class="custom-file-input" id="inputGroupFile01">
              <label class="custom-file-label" for="inputGroupFile01">Choose File</label>
            </div>
          </div>

          <div class="form-group">
            <label for="Description">Description</label>
            <input type="text" name="description" class="form-control" placeholder="Description...">
          </div>

          <div class="form-group">
            <label for="Category">Category</label>
            <select class="form-control" name="category_id">
              @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>

              @endforeach
            </select>
          </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
    </div>
</div>

@endsection

