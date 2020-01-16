<template>
   <form @submit.prevent="addContact" class="form form-vertical" enctype="multipart/form-data" >
    <label for="type">Category</label>
      <input class="typeahead form-control"  v-model="category" @change="myFunction()" type="text">
      <div id="catList">
          <ul class="dropdown-menu" style="display:block; position:relative">
              <li><a href="#">'.$row->name.'</a></li>
              </ul>
      </div>
      </form>
</template>

<script>
   export default {
  data() {
    return {
      category: '',
     
    };
  },
 
  created() {

  },

 methods:{
     myFunction() {
        var context = this;
            alert(context.category);

    }
 }
 
};
</script>
