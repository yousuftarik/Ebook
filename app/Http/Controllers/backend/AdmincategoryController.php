<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Image;
use File;


class AdmincategoryController extends Controller
{
  //
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function create()
  {
    $categories = Category::orderBy('id', 'asc')->paginate(20);
    return view('backend.pages.categories.addcategory')->with('categories', $categories);
  }

  public function addcategory(Request $request)
  {

    $this->validate($request, [
      'name' => 'required|string',
    ]);
    

    $category_exist = Category::where('name', $request->name)->exists();
    
    if(!$category_exist){
        $category = Category::create([
            'name' => $request->name,
          ]);
          $categories = Category::orderBy('id', 'asc')->paginate(20);

          session()->flash('success', 'category created successfully');
          return view('backend.pages.categories.addcategory', compact('categories'));
    }else{
        return back()->with('error', 'category already exist');
    }
    
  }

 
  public function search(Request $request)
  {
      $data = $request->get('search');

      $categories = Category::where('name', 'like', "%{$data}%")->paginate(20);

      return view('backend.pages.categories.addcategory')->with('categories', $categories);
  }

  public function edit($id)
  {
    $category_edit = Category::find($id);
    $categories = Category::orderBy('id', 'asc')->paginate(20);
    return view('backend.pages.categories.edit', compact('categories', 'category_edit'));
  }

  public function delete($id)
  {
    $category = Category::find($id);

    if (!is_null($category)) {
      $category->delete();
    }
    session()->flash('success', 'category has deleted successfully !!');
    return redirect(route('admin.category.create'));
  }

  public function update(Request $request, $id)
  {

    $this->validate($request, [
      'name' => 'required|string',
    ]);

    $category = Category::find($id);
   

    $category->name = $request->name;
        $category->save();
        session()->flash('success', 'category updated successfully');
        return redirect(route('admin.category.create'));
    


  }
}
