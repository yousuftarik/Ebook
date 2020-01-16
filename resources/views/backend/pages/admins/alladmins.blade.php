@extends('backend.layouts.master')

@section('content')
<!-- partial -->


<div class="table-responsive text-nowrap">
  <table class="table">
    <thead class="thead-light">
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Type</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($admins as $admin)
      @if ($admin->type!=0)
      <tr>
        <th scope="row"><img src="{!!asset('images/admin/'.$admin->avatar)!!}" width="50px" height="50px" /></th>
        <td>{{$admin->name}}</td>
        <td>{{$admin->email}}</td>
        <td>{{$admin->phone_no}}</td>

        @if ($admin->type==0)
        <td>Super admin</td>
        @elseif($admin->type==1)
        <td>Admin</td>
        @elseif($admin->type==2)
        <td>Light admin</td>
        @endif

        <td class="row"><a href="{{route('admin.user.edit',$admin->id )}}" class="mt-1 mr-2"><button type="button"
              class="btn btn-primary">Edit</button></a>
          <button href="#deletecatModal{{ $admin->id }}" data-toggle="modal" type="button"
            class="btn btn-danger">Delete</button></td>

      </tr>
      @endif

      <!-- Modal -->
      <div class="modal fade" id="deleteModal{{ $admin->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Please confirm your action.</p>
            </div>
            <div class="modal-footer">
              <form action="{!! route('admin.user.delete', $admin->id) !!}" method="post">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-danger">Yes</button>
              </form>
              <button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>
            </div>
          </div>
        </div>
      </div>
      @endforeach

    </tbody>
  </table>
</div>


@endsection