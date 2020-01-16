@extends('backend.layouts.master')

@section('content')
<!-- partial -->
  <h4 class="col-md-6" style="text-align: center">Create User</h4>
  <form action="{{ route('admin.user.addUser') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="name">Full name</label>
          <input type="name" class="form-control" id="name" name="name" placeholder="Full name">
        </div>
        <div class="form-group col-md-6">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Email">
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
          <label for="address">Address</label>
          <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St">
        </div>
        <div class="form-group col-md-6">
            <label for="phone_no">Phone Number</label>
            <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="phone number">
          </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="city">City</label>
          <input type="text" class="form-control" id="city" name="city">
        </div>
        <div class="form-group col-md-6">
          <label for="type">Type</label>
          <select id="type" class="form-control" name="type">
            <option selected>Choose...</option>
            <option value="1">Admin</option>
            <option value="2">Light Admin</option>
          </select>
        </div>
      </div>
      <div class="form-row">
          <div class="form-group col-md-3">
              <label for="avatar">Picture</label>
              <div class="imgUp" style="width: 200px; height: 150px;">
                  <div class="imagePreview"></div>
                  <label class="btn btn-primary">
                      Upload<input type="file" class="uploadFile img" value="Upload Photo" name="avatar"
                          style="width: 0px;height: 0px;overflow: hidden;">
                  </label>
              </div>
            </div>
            
            <div class="form-group col-md-6  mt-auto">
                <input type="submit" class="btn btn-primary" value="Create User">
            </div>
      </div>
    </form>
  


@endsection