@extends('backend.layouts.master')

@section('content')
<!-- partial -->
  <h4 class="col-md-6" style="text-align: center">Edit User</h4>
  <form action="{{ route('admin.user.update', $admin->id) }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="name">Full name</label>
        <input type="name" class="form-control" id="name" name="name" placeholder="Full name" value="{{$admin->name}}">
        </div>
        <div class="form-group col-md-6">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$admin->email}}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="address">Address</label>
          <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" value="{{$admin->address}}">
        </div>
        <div class="form-group col-md-6">
            <label for="phone_no">Phone Number</label>
            <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="phone number" value="{{$admin->phone_no}}">
          </div>
      </div>
      <div class="form-row">
            <div class="form-group col-md-6">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="form-group col-md-6">
              <label for="c_password">Confirm Password</label>
              <input type="password" class="form-control" id="c_password" name="c_password" placeholder="Password">
            </div>
          </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="city">City</label>
          <input type="text" class="form-control" id="city" name="city" value="{{$admin->city}}">
        </div>
        <div class="form-group col-md-6">
          <label for="type">Type</label>
          <select id="type" class="form-control" name="type">
            @if ($admin->type==0)
            <option  value="0" selected>Super admin</option>
            <option value="1">Admin</option>
            <option value="2">Light Admin</option>
            @elseif($admin->type==1)
            <option value="1" selected>Admin</option>
            <option value="2">Light Admin</option>
            @elseif($admin->type==2)
            <option  value="2" selected>Light admin</option>
            <option value="1">Admin</option>
            @endif
          </select>
        </div>
      </div>
      <div class="form-row">
          <div class="form-group col-md-6">
              <label for="description">Old Image</label>
              <img class="mt-3" src="{!!asset('images/admin/'.$admin->avatar)!!}" width="250px"
                  height="200px" />
          </div>
          <div class="form-group col-md-6">
              <label for="image">New Image</label>
              <div class="col-sm-6 imgUp">
                  <div class="imagePreview"></div>
                  <label class="btn btn-primary">
                      Upload<input type="file" class="uploadFile img" value="Upload Photo" name="avatar"
                          style="width: 0px;height: 0px;overflow: hidden;">
                  </label>
              </div>
          </div>
      </div>
      
      <input type="submit" class="btn btn-primary" value="Submit user">
    </form>
  


@endsection