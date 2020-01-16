@extends('backend.layouts.master')

@section('content')
<form autocomplete="off" action="{{ route('admin.discount.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group pt-3">
        <label for="type">Publisher</label>
        <input placeholder="Pblisher" class="typeahead form-control" id="publisher" type="text">
        <input name="publisher_id" value="{{old('publisher_id')}}" id="publisher_id" hidden type="text">
        <div id="pubList"></div>
    </div>
    <div class="form-group pt-3">
        <label for="type">Author</label>
        <input placeholder="Author" class="typeahead form-control" value="{{old('author_id')}}" id="author" type="text">
        <input name="author_id" id="author_id" hidden type="text">
        <div id="authList"></div>
    </div>
    <label for="demo">Discount</label>
    <div class="col-md-2 input-group mb-3">
        <input type="text" class="form-control" value="{{old('discount')}}" type="number" placeholder="Discount" id="discount" name="discount">
        <div class="input-group-append">
            <span class="input-group-text">%</span>
        </div>
    </div>
    <button type="submit" class="btn btn-success ml-2">Save</button>
</form>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        
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