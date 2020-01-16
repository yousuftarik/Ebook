@extends('backend.layouts.master')

@section('content')
<!-- partial -->
<h4 class="col-md-6" style="text-align: center">Add Book</h4>
<form action="{{ route('admin.book.addbook') }}" method="post" enctype="multipart/form-data" autocomplete="off">
  @csrf
  <example-component></example-component>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label value="{{old('title')}}" for="title">Title</label>
      <input type="title" class="form-control" id="title" name="title" placeholder="Title">
    </div>
    <div class="form-group col-md-6">
      <label for="type">Category</label>
      <input class="typeahead form-control" value="{{old('category')}}" id="category" type="text">
      <input name="category_id" value="{{old('category_id')}}" id="category_id" hidden type="text">
      <div id="catList">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="summary">Summary</label>
    <textarea class="form-control" id="summary" name="summary" rows="3">{{old('summary')}}</textarea>
  </div>

  <div class="form-row">
    <div class="form-group col-md-2">
      <label for="country">Country</label>
      <input type="text" value="{{old('country')}}" class="form-control" id="country" name="country">
    </div>
    <div class="form-group col-md-2">
      <label for="stock">Stock</label>
      <input type="number" value="{{old('stock')}}" class="form-control" name="stock" placeholder="stock">
    </div>
    <div class="form-group col-md-2">
      <label for="old_price">Price</label>
      <input type="number" value="{{old('old_price')}}" class="form-control" name="old_price"
        placeholder="enter old price">
    </div>
    <div class="form-group col-md-2">
      <label for="page">Total page</label>
      <input type="number" value="{{old('page')}}" class="form-control" name="page" placeholder="enter total page">
    </div>
    <div class="form-group col-md-2">
      <label for="page">Editor</label>
      <input type="text" value="{{old('editor')}}" class="form-control" name="editor" placeholder="enter editor name">
    </div>
    <div class="form-group col-md-2">
      <label for="page">Edition</label>
      <input type="text" value="{{old('edition')}}" class="form-control" name="edition" placeholder="enter edition name">
    </div>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <textarea style="outline: 1px solid gray;" class="form-control" id="description" name="description"
      rows="3">{{old('description')}}</textarea>
  </div>
  <div class="form-row" style="height: 263px;">
    <div class="form-group col-md-3">
      <label>Book cover</label>
      <div class="imgUp" style="width: 150px; height: 100px;">
        <div class="imagePreview"></div>
        <label class="btn btn-primary">
          Upload<input type="file" value="{{old('cover')}}" class="uploadFile img" value="Upload Photo" name="cover"
            style="width: 0px;height: 0px;overflow: hidden;">
        </label>
      </div>
    </div>
    <div class="form-group col-md-9">
    <label for="tag">Tag</label>
      <input id="form-tags-1" value="{{old('tag')}}" type="text" name="tag" value="jQuery,Script,Net">
      <label for="tag">Tag</label>
      <input id="form-tags-1" value="{{old('tag')}}" type="text" name="tag" value="jQuery,Script,Net">
      <div class="form-row pt-3">
        <div class=" col-md-6">
          <label for="type">Author</label>
          <input class="typeahead form-control" value="{{old('author_id')}}" id="author" type="text">
          <input name="author_id" id="author_id" hidden type="text">
          <div id="authList"></div>
        </div>
        <div class=" col-md-6">
          <div class="col-md-2">
            <label for="language">Language</label>
            <input type="text" value="{{old('language')}}" id="language" name="language">
          </div>
        </div>
      </div>
      <div class="form-row pt-3">
        <div class=" col-md-4">
          <label for="type">Publisher</label>
          <input class="typeahead form-control" id="publisher" type="text">
          <input name="publisher_id" value="{{old('publisher_id')}}" id="publisher_id" hidden type="text">
          <div id="pubList"></div>
        </div>

        <div class="col-md-3" style="
            margin-right: 42px;
        ">
          <label for="discount">Discount</label>
          <div class="input-group">
          <input style="width: 86px;" value="{{old('discount')}}" type="number" id="discount" name="discount"
            placeholder="discount">
            <div class="input-group-append">
                <span class="input-group-text">%</span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <label for="discount">Upcoming</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="upcoming" id="upcoming1" value="1" checked>
            <label class="form-check-label" for="upcoming1">
              Yes
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="upcoming" id="upcoming2" value="0">
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
          style="width: 0px;height: 0px;overflow: hidden;" value="{{old('book_pageImages[]')}}"
          name="book_pageImages[]">
      </label>
    </div>
    <i class="fa fa-plus imgAdd"></i>
  </div>



  <input type="submit" class="btn btn-primary" value="Create book">
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