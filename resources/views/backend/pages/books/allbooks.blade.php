@extends('backend.layouts.master')

@section('content')
<!-- partial -->
<div class="row m-2">
    <div class="col-md-6">
        All books
    </div>
    <div class="col-md-4">
        <form action="{{route('admin.book.search')}}">
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

<div class="table-responsive text-nowrap">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>Id</th>
                <th>Cover</th>
                <th>Title</th>
                <th>New price</th>
                <th>Old price</th>
                <th>Stock</th>
                <th>Discount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)

            <tr>
                <td>{{$book->id}}</td>
                <td>
                    @if($book->cover == null)
                    <img src="{!!asset('images/book/cover/default.png')!!}" style="width: 75px; height: 95px;"
                        alt="book" />
                    @else
                    <img src="{!!asset($book->cover)!!}" style="width: 75px; height: 95px;"
                        alt="book" />
                    @endif
                </td>
                <td>{{$book->title}}</td>
                <td>৳ {{$book->new_price}}</td>
                <td>৳ {{$book->old_price}}</td>
                <td>{{$book->stock}}</td>
                <td>{{$book->discount > 0 ? $book->discount : 0}}%</td>

                <td class="row mt-5"><a href="{{route('admin.book.edit',$book->id )}}" class="mt-1 mr-2"><button
                            type="button" class="btn btn-primary">Edit</button></a>
                    <button href="#deletebookModal{{ $book->id }}" data-toggle="modal" type="button"
                        class="btn btn-danger">Delete</button></td>

            </tr>

            <!-- Modal -->
            <div class="modal fade" id="deletebookModal{{ $book->id }}" tabindex="-1" role="dialog"
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
                            <form action="{!! route('admin.book.delete', $book->id) !!}" method="post">
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
    {{$books->links()}}
</div>


@endsection