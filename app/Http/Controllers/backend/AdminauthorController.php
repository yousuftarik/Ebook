<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;
use Image;
use File;

use Illuminate\Support\Facades\Hash;

class AdminauthorController extends Controller
{
  //
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function create()
  {
    $authors = Author::orderBy('id', 'asc')->paginate(20);
    return view('backend.pages.author.create')->with('authors', $authors);
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'image' => 'max:500',
    ]);

    $file = $request->file('image');


    $author_exist = Author::where('name', $request->name)->exists();

    if (!$author_exist) {

      if($file != null){
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $filename = time() . '.' . $extension;
        $file->move('images/author/', $filename);

        $author = Author::create([
          'name' => $request->name,
          'description' => $request->description,
          'image' => config('rootUrl') . 'images/author/' .$filename
        ]);
      }else{
        $author = Author::create([
          'name' => $request->name,
          'description' => $request->description,
        ]);
      }


     
      session()->flash('success', 'author created successfully');
      return back();
    } else {
      return back()->with('error', 'author already exist');
    }
  }

  public function search(Request $request)
  {
    $data = $request->get('search');

    $authors = Author::where('name', 'like', "%{$data}%")->paginate(20);

    return view('backend.pages.author.create')->with('authors', $authors);
  }

  public function edit($id)
  {
    $author_edit = Author::find($id);
    $authors = Author::orderBy('id', 'asc')->paginate(20);
    return view('backend.pages.author.edit', compact('authors', 'author_edit'));
  }

  public function delete($id)
  {
    $author = Author::find($id);

    if (!is_null($author)) {
      $author->delete();
      $authorImage = explode("/", $author->image);
      if (File::exists('images/author/' . end($authorImage))) {
        File::delete('images/author/' . end($authorImage));
      }
    }
    session()->flash('success', 'author has deleted successfully !!');
    return redirect(route('admin.author.create'));
  }

  public function update(Request $request, $id)
  {

    $this->validate($request, [
      'name' => 'required|string',
      'image' => 'max:500',
    ]);

    $file = $request->file('image');

    $author = Author::find($id);


    if ($file > 0) {
      //Delete the old image

      $authorImage = explode("/", $author->image);
      if (File::exists('images/author/' . end($authorImage))) {
        File::delete('images/author/' . end($authorImage));
      }

      $extension = $file->getClientOriginalExtension(); // getting image extension
      $filename = time() . '.' . $extension;
      $file->move('images/author/', $filename);
      $author->image = config('rootUrl') . 'images/author/' .$filename;
    }

    $author->name = $request->name;
    $author->description = $request->description;
    $author->save();
    session()->flash('success', 'author updated successfully');
    return redirect(route('admin.author.create'));
  }

  public function set_top(Request $request, $id)
  {
    $this->validate($request, [
      'weekly_top' => 'required|string',
    ]);

    $author = Author::find($id);


    $author->weekly_top = $request->weekly_top;

    $author->save();
    session()->flash('success', 'author added to weekly top successfully');
    return back();
  }
}
