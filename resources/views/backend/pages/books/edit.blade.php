@extends('backend.layouts.master')

@section('content')
<!-- partial -->
<h4 class="col-md-6" style="text-align: center">Edit Book</h4>
<form autocomplete="off" action="{{ route('admin.book.update', $book->id) }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="name">Title</label>
      <input type="name" class="form-control" value="{{$book->title}}" id="name" name="title" placeholder="Title">
    </div>
    <div class="form-group col-md-6">
      <label for="type">Category</label>
      <input class="typeahead form-control" id="category" type="text" value="{{$old_category ? $old_category->name : ''}}">
      <input name="category_id" id="category_id" hidden type="text" value="{{$old_category ? $book->category_id : ''}}">
      <div id="catList">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="summary">Summary</label>
    <textarea class="form-control" id="summary" name="summary" rows="3">{{$book->summary}}</textarea>
  </div>

  <div class="form-row">
    <div class="form-group col-md-2">
      <label for="country">Country</label>
      <input type="text" class="form-control" id="country" name="country" value="{{$book->country ? $book->country : ''}}">
    </div>
    <div class="form-group col-md-2">
      <label for="stock">Stock</label>
      <input type="number" class="form-control" name="stock" placeholder="stock" value="{{$book->stock}}">
    </div>
    <div class="form-group col-md-2">
      <label for="old_price">Price</label>
      <input type="number" maxlength="5" class="form-control" value="{{$book->old_price}}" name="old_price"
        placeholder="enter old price">
    </div>
    <div class="form-group col-md-2">
      <label for="page">Total page</label>
      <input type="number" maxlength="5" class="form-control" value="{{$book->page}}" name="page"
        placeholder="enter total page">
    </div>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <textarea style="outline: 1px solid gray;" class="form-control" id="description" name="description"
      rows="3">{{$book->description}}</textarea>
  </div>
  <div class="form-row" style="height: 263px;">

    <div class="form-group col-md-3">
      <label for="description">Old Image</label>
      @if($book->cover == null)
      <img class="mt-3" src="{!!asset('images/book/cover/default.png')!!}" width="250px" height="200px" />
      @else
      <img class="mt-3" src="{!!asset($book->cover)!!}" width="250px" height="200px" />
      @endif

    </div>
    <div class="form-group col-md-3">
      <label for="image">New Image</label>
      <div class="imgUp">
        <div class="imagePreview"></div>
        <label class="btn btn-primary">
          Upload<input type="file" class="uploadFile img" value="Upload Photo" name="cover"
            style="width: 0px;height: 0px;overflow: hidden;">
        </label>
      </div>
    </div>

    <div class="form-group col-md-6">
      <label for="tag">Tag</label>
      <input id="form-tags-1" type="text" name="tag" value="{{$all_tags}}">
      <div class="form-row pt-3">
        <div class=" col-md-6">
          <label for="type">Author</label>
          <input class="typeahead form-control" id="author" type="text" value="{{$old_author ? $old_author->name : ' '}}">
          <input name="author_id" id="author_id" hidden type="text" value="{{$old_author ? $old_author->id : ''}}">
          <div id="authList"></div>
        </div>
        <div class=" col-md-6">
          <div class="col-md-2">
            <label for="language">Language</label>
            <input type="text" id="language" name="language" value="{{$book->language}}">
          </div>
        </div>
      </div>
      <div class="form-row pt-3">
        <div class=" col-md-4">
          <label for="type">Publisher</label>
          <input class="typeahead form-control" id="publisher" type="text" value="{{$old_publisher ? $old_publisher->name : ''}}">
          <input name="publisher_id" id="publisher_id" hidden type="text" value="{{$old_publisher ? $old_publisher->id : ''}}">
          <div id="pubList"></div>
        </div>

        <div class="col-md-3" style="
            margin-right: 42px;;
        ">
        <label for="discount">Discount</label>
         <div class="input-group">
            <input style="width: 63px;" value="{{$book->discount}}" type="number" id="discount" name="discount"
              placeholder="discount">
              <div class="input-group-append">
                  <span class="input-group-text">%</span>
              </div>
            </div>
        </div>
        <div class="col-md-3">
          <label for="discount">Upcoming</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="upcoming" id="upcoming1" value="1" @if ($book->upcoming
            == 1)
            checked
            @endif>
            <label class="form-check-label" for="upcoming1">
              Yes
            </label>
          </div>
          <div class="form-check">
            <input @if ($book->upcoming == 0)
            checked
            @endif
            class="form-check-input" type="radio" name="upcoming" id="upcoming2" value="0">
            <label class="form-check-label" for="upcoming2">
              No
            </label>
          </div>
        </div>
      </div>
          
    </div>
  </div>

  <div class="form-row">
    <h4>Upload image of book pages</h4>
  </div>
  <div class="form-row">
    <div class="col-sm-2 imgUp">
      <div class="imagePreview"></div>
      <label class="btn btn-primary">
        Upload<input type="file" class="uploadFile img" value="Upload Photo"
          style="width: 0px;height: 0px;overflow: hidden;" 
          name="book_pageImages[]">
      </label>
    </div>
    <i class="fa fa-plus imgAdd"></i>
  </div>

  <div class="row">
      <input type="submit" class="btn btn-success" value="Update book">
      <button class="btn btn-primary ml-3" type="button" class="btn btn-primary" data-toggle="modal" data-target="#bookPages">Book pages</button>    
  </div>
</form>

<!-- Modal -->
<div class="modal fade" id="bookPages" tabindex="-1" role="dialog" aria-labelledby="bookPagesLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h5 class="modal-title" id="bookPagesLabel">Book pages</h5>
          <form action="{!! route('admin.book.destroyImage', $book->id) !!}" method="post">
              {{ csrf_field() }}
              <button type="submit" class="btn btn-danger ml-3">Delete all</button>
          </form>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="height: 500px; overflow-y: scroll;">
          @foreach($bookImages as $bookImages)
        <img src="{{$bookImages->image}}" style="width: 100%"/>
          @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection

@section('scripts')
<script>
  $(document).ready(function(){
     $('#category').keyup(function(){ 
      
            var query = $(this).val();
            if(query != '')
            {
              axios.get("{{route('api.cat_search')}}",{params: {query: query}}).
              then(response => {

              console.log(response);
              $('#catList').fadeIn();  
              $('#catList').html(response.data);
              });
            }else{
              $('#catList').fadeOut();
            }
        });
    
        $(document).on('click', '.cat_li', function(){  
            $('#category').val($(this).text());
            $('#category_id').val($(this).attr('category_id'))  
            $('#catList').fadeOut();  
        }); 
        
        $('#publisher').keyup(function(){ 
      
            var query = $(this).val();
            if(query != '')
            {
              // console.log(query)
              axios.get("{{route('api.pub_search')}}",{params: {query: query}}).
              then(response => {

              console.log(response);
              $('#pubList').fadeIn();  
              $('#pubList').html(response.data);
              });
            }else{
              $('#pubList').fadeOut();
            }
        });

        $(document).on('click', '.pub_li', function(){  
            $('#publisher').val($(this).text());
            $('#publisher_id').val($(this).attr('publisher_id'))  
            $('#pubList').fadeOut();  
        }); 

        $('#author').keyup(function(){ 
      
            var query = $(this).val();
            if(query != '')
            {
              // console.log(query)
              axios.get("{{route('api.auth_search')}}",{params: {query: query}}).
              then(response => {

              console.log(response);
              $('#authList').fadeIn();  
              $('#authList').html(response.data);
              });
            }else{
              $('#authList').fadeOut();
            }
        });

        $(document).on('click', '.auth_li', function(){  
            $('#author').val($(this).text());
            $('#author_id').val($(this).attr('author_id'))  
            $('#authList').fadeOut();  
        }); 
    
    });
</script>
@endsection