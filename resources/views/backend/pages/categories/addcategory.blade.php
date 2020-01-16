@extends('backend.layouts.master')

@section('content')
<!-- partial -->
<h4 style="text-align: center">Create category</h4>
<form action="{{ route('admin.category.addcategory') }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="form">
    <div class="form-group">
      <label for="name">Title</label>
      <input type="name" class="form-control col-md-6" id="name" name="name" placeholder="Category title">
    </div>
  </div>

  <input type="submit" class="btn btn-primary" value="Create category">
</form>
<div class="row m-2 pt-5">
  <div class="col-md-6">
    All categories
  </div>
  <div class="col-md-4">
    <form action="{{route('admin.category.search')}}">
      @csrf
      <div class="row">
        <input type="search" name="search" class="form-control mr-2" style="width: 60%">
        <span style="width: 30%">
          <button type="submit" class="btn btn-primary mt-0">Search</button>
        </span>
      </div>
    </form>
  </div>
</div>
<div class="">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Category name</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($categories as $category)
      <tr>
        <th>{{$category->id}}</th>
        <td>{{$category->name}}</td>
        <td class="row"><a href="{{route('admin.category.edit',$category->id )}}" class="mt-1 mr-2"><button
              type="button" class="btn btn-primary">Edit</button></a>
          <button href="#deletecatModal{{ $category->id }}" data-toggle="modal" type="button"
            class="btn btn-danger">Delete</button></td>
      </tr>

      <!-- Modal -->
      <div class="modal fade" id="deletecatModal{{ $category->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete this category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Please confirm your action.</p>
            </div>
            <div class="modal-footer">
              <form action="{!! route('admin.category.delete', $category->id) !!}" method="post">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-danger">Yes</button>
              </form>
              <button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>
            </div>
          </div>
        </div>
        @endforeach
    </tbody>
  </table>
  {{$categories->links()}}
</div>

@endsection