<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Image;
use File;


class publisherController extends Controller
{
  //
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function create()
  {
    $publishers = Publisher::orderBy('id', 'asc')->paginate(20);
    return view('backend.pages.publisher.create')->with('publishers', $publishers);
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'image' => 'max:500',
    ]);
    
    $file = $request->file('image');

    $publisher_exist = Publisher::where('name', $request->name)->exists();
    
    if(!$publisher_exist){
      if($file != null){
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $filename = time() . '.' . $extension;
        $file->move('images/publisher/', $filename);
        
        $publisher = Publisher::create([
          'name' => $request->name,
          'description' => $request->description,
          'image' => config('rootUrl') . 'images/publisher/' .$filename
        ]);
        session()->flash('success', 'publisher created successfully');
        return back();
      }else{
         $publisher = Publisher::create([
          'name' => $request->name,
          'description' => $request->description,
        ]);
        session()->flash('success', 'publisher created successfully');
        return back();
      }
        
    }else{
        return back()->with('error', 'publisher already exist');
    }
    
  }

 
  public function search(Request $request)
  {
    $data = $request->get('search');

    $publishers = Publisher::where('name', 'like', "%{$data}%")->paginate(20);

    return view('backend.pages.publisher.create')->with('publishers', $publishers);
  }

  public function edit($id)
  {
    $publisher_edit = Publisher::find($id);
    $publishers = Publisher::orderBy('id', 'asc')->paginate(20);
    return view('backend.pages.publisher.edit', compact('publishers', 'publisher_edit'));
  }

  public function delete($id)
  {
    $publisher = Publisher::find($id);

    if (!is_null($publisher)) {
      $publisher->delete();
      $publisherImage = explode("/", $publisher->image);
      if (File::exists('images/publisher/' . end($publisherImage))) {
        File::delete('images/publisher/' . end($publisherImage));
      }
    }
    session()->flash('success', 'publisher has deleted successfully !!');
    return redirect(route('admin.publisher.create'));
  }

  public function update(Request $request, $id)
  {

    $this->validate($request, [
      'name' => 'required|string',
      'image' => 'max:500',
    ]);
    
    $file = $request->file('image');

    $publisher = Publisher::find($id);
   
    
    if ($file > 0) {
        //Delete the old image
        
        $publisherImage = explode("/", $publisher->image);
        if (File::exists('images/publisher/' . end($publisherImage))) {
          File::delete('images/publisher/' . end($publisherImage));
        }
  
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $filename = time() . '.' . $extension;
        $file->move('images/publisher/', $filename);
        $publisher->image = config('rootUrl') . 'images/publisher/' .$filename;
      }

    $publisher->name = $request->name;
    $publisher->description = $request->description;
    $publisher->save();
    session()->flash('success', 'publisher updated successfully');
    return redirect(route('admin.publisher.create'));
    


  }
}
