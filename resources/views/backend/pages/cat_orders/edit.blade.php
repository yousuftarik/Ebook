@extends('backend.layouts.master')

@section('content')
<!-- partial -->
<h4 style="text-align: center">Edit category order</h4>
<form action="{{ route('admin.cat_order.update',$catOrder_old->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="type">Category</label>
            <select id="type" class="form-control" name="category_id">
                <option value="{{$catOrder_old->category_id}}" selected>{{$catOrder_old->category}}</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="name">Serial</label>
        <input value="{{$catOrder_old->serial}}" type="number" class="form-control col-md-6" id="serial" name="serial" placeholder="serial">
        </div>
    </div>


    <input type="submit" class="btn btn-primary" value="Update category order">
</form>
<h4 class="mt-2" style="text-align: center">Ctegory order</h4>
<div class="table-wrapper-scroll-y my-custom-scrollbar">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Serial number</th>
                <th scope="col">Category name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($catOrders as $catOrder)
            <tr>
                <td>{{$catOrder->serial}}</td>
                <td>{{$catOrder->category}}</td>
                <td class="row"><a href="{{route('admin.cat_order.edit',$catOrder->id )}}" class="mt-1 mr-2"><button
                            type="button" class="btn btn-primary">Edit</button></a>
                    <button href="#deletecatModal{{ $catOrder->id }}" data-toggle="modal" type="button"
                        class="btn btn-danger">Delete</button></td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="deletecatModal{{ $catOrder->id }}" tabindex="-1" role="dialog"
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
                            <form action="{!! route('admin.cat_order.delete', $catOrder->id) !!}" method="post">
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
</div>

@endsection