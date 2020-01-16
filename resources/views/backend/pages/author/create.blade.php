@extends('backend.layouts.master')

@section('content')
<!-- partial -->
<h4 style="text-align: center">Create author</h4>
<form action="{{ route('admin.author.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form">
        <div class="form-group">
            <label for="name">Title</label>
            <input type="name" class="form-control col-md-6" id="name" name="name" placeholder="author title">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="form-row" style="height: 263px;">
            <div class="form-group col-md-3">
                <label for="image">Picture</label>
                <div class="imgUp" style="width: 150px; height: 100px;">
                    <div class="imagePreview"></div>
                    <label class="btn btn-primary">
                        Upload<input type="file" class="uploadFile img" value="Upload Photo" name="image"
                            style="width: 0px;height: 0px;overflow: hidden;">
                    </label>
                </div>
            </div>
            <div class="form-group col-md-9 mt-auto">
                <input type="submit" class="btn btn-primary" value="Create author">
            </div>
        </div>
    </div>

</form>
<div class="row m-2 pt-5">
    <div class="col-md-6">
        All authors
    </div>
    <div class="col-md-4">
        <form action="{{route('admin.author.search')}}">
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
                <th scope="col">author image</th>
                <th scope="col">author name</th>
                <th scope="col">Weekly top</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $author)

            <tr>
                <th>{{$author->id}}</th>
                <td> 
                    @if($author->image == null)
                        <img src="{!!asset('images/default/default-avatar.png')!!}" width="50px" height="50px" />
                    @else
                        <img src="{!!asset($author->image)!!}" width="50px" height="50px" />
                    @endif
                    </td>
                <td>{{$author->name}}</td>
                <td>
                    <form action="{!! route('admin.author.set_top', $author->id) !!}" method="post">
                        {{ csrf_field() }}
                        @if ($author->weekly_top == 0)
                        <input hidden name="weekly_top" value="1" />
                        <button type="submit" class="btn btn-success">Set as top</button>
                        @endif
                        @if ($author->weekly_top == 1)
                        <input hidden name="weekly_top" value="0" />
                        <button type="submit" class="btn btn-info">Set back to normal</button>
                        @endif

                    </form>
                </td>
                <td class="row"><a href="{{route('admin.author.edit',$author->id )}}" class="mt-1 mr-2"><button
                            type="button" class="btn btn-primary">Edit</button></a>
                    <button href="#deletecatModal{{ $author->id }}" data-toggle="modal" type="button"
                        class="btn btn-danger mr-2">Delete</button>
                </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="deletecatModal{{ $author->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete this author</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Please confirm your action.</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{!! route('admin.author.delete', $author->id) !!}" method="post">
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
{{$authors->links()}}
@endsection