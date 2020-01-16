<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\BookImage;
use App\Models\Tag;

use Image;
use File;

use Illuminate\Support\Facades\Hash;

class AdminbookController extends Controller
{
  //
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function create()
  {
    $categories = Category::orderBy('id', 'desc')->get();
    $authors = Author::orderBy('id', 'desc')->get();
    $publishers = Publisher::orderBy('id', 'desc')->get();

    return view('backend.pages.books.addbook', compact('categories', 'authors', 'publishers'));
  }

  public function addbook(Request $request)
  {
    $this->validate($request, [
      'title' => 'required|string',
      'category_id' => 'required',
      'country' => 'required',
      'old_price' => 'required',
    //   'page' => 'required',
    //   'tag' => 'required',
      'author_id' => 'required',
      'language' => 'required',
      'publisher_id' => 'required',
      'upcoming' => 'required',
      'cover' => 'max:500',
      'book_pageImages' => 'max:1024',
      'discount' => 'numeric|max:99'
    ]);

    

    $tags = explode(",", $request->tag);

    $book_cover = $request->file('cover');
    $extension = $book_cover->getClientOriginalExtension(); // getting image extension
    $book_coverName = time() . '.' . $extension;
    $book_cover->move('images/book/cover/', $book_coverName);



    $bookPages = $request->file('book_pageImages');


    $book = Book::create([
      'title' => $request->title,
      'category_id' => $request->category_id,
      'summary' => $request->summary,
      'country' => $request->country,
      'stock' => $request->stock,
      'old_price' => $request->old_price,
      'page' => $request->page,
      'description' => $request->description,
      'cover' => config('rootUrl') . 'images/book/cover/' .$book_coverName,
      'author_id' => $request->author_id,
      'language' => $request->language,
      'publisher_id' => $request->publisher_id,
      'discount' => $request->discount,
      'upcoming' => $request->upcoming,
      'editor' =>$request->editor,
      'edition' => $request->edition
    ]);


    if (count((array)$bookPages) > 0) {
      // dd($bookPages);
      foreach ($bookPages as $bookPage) {
        $extension1 = $bookPage->getClientOriginalExtension(); // getting image extension
        $bookPageName = time() . rand(10, 100) . '.' . $extension1;
        $bookPage->move('images/book/pages/', $bookPageName);

        $book_image = new BookImage;
        $book_image->book_id = $book->id;
        $book_image->image =  config('rootUrl') . 'images/book/pages/' . $bookPageName;
        $book_image->save();
      }
    }
    //  dd($tags);
    if (count($tags) > 0) {
      foreach ($tags as $tagText) {
        $tag = new Tag;
        $tag->book_id = $book->id;
        $tag->name = $tagText;
        $tag->save();
      }
    }

    session()->flash('success', 'Book created successfully');
    return redirect(route('admin.book.index'));
  }

  public function index()
  {
    $books = Book::orderBy('id', 'asc')->paginate(20);
    
    foreach ($books as $key => $value) {
      $books[$key]->new_price = (int)$books[$key]->old_price - (int)($books[$key]->old_price * ($books[$key]->discount / 100));
    }

    return view('backend.pages.books.allbooks')->with('books', $books);
  }

  public function edit($id)
  {
    $categories = Category::orderBy('id', 'desc')->get();
    $authors = Author::orderBy('id', 'desc')->get();
    $publishers = Publisher::orderBy('id', 'desc')->get();
   
    
    $tags = Tag::where('book_id', $id)->get();


    $all_tags = "";
    foreach ($tags as $tag) {
      $all_tags = $all_tags . "," . $tag->name;
    }

    $book = Book::find($id);
    $old_category = Category::find($book->category_id);
    $old_publisher = Publisher::find($book->publisher_id);
    $old_author = Author::find($book->author_id);

    $bookImages = BookImage::where("book_id", $id)->get();

    // dd($bookImages);

    // dd($categories, $authors, $publishers, $book, $old_category, $old_author, $all_tags, $old_publisher);
    return view('backend.pages.books.edit', compact('categories', 'authors', 'publishers', 'book', 'old_category', 'old_author', 'all_tags', 'old_publisher', 'bookImages'));
  }

  public function delete($id)
  {
    $bookImages = BookImage::where("book_id", $id)->get();

    foreach ($bookImages as $bookImage ){
      $bookImage = explode("/", $bookImage->image);
      // dd($bookImage);
      if (File::exists('images/book/pages/' . end($bookImage))) {
        File::delete('images/book/pages/' . end($bookImage));
      }
    }


    $book = Book::find($id);
    $tags = Tag::where('book_id', $id);
    $bookCover = explode("/", $book->cover);

    if (File::exists('images/book/cover/' . end($bookCover))) {
      File::delete('images/book/cover/' . end($bookCover));
    }
    
    if (!is_null($book)) {
      $book->delete();
      $tags->delete();

    }
    session()->flash('success', 'book has deleted successfully !!');
    return back();
  }
  

  public function destroyImage($id)
  {
    $bookImages = BookImage::where("book_id", $id)->get();

    foreach ($bookImages as $bookImage ){
      $bookImage = explode("/", $bookImage->image);
      // dd($bookImage);
      if (File::exists('images/book/pages/' . end($bookImage))) {
        File::delete('images/book/pages/' . end($bookImage));
      }
    }

    BookImage::where('book_id', $id)->delete();
    
    return back()->with('success', 'Deleted all page images of this book');
  }


  public function search(Request $request)
    {
        $data = $request->get('search');

        $books = Book::where('title', 'like', "%{$data}%")->paginate(20);

        foreach ($books as $key => $value) {
            $author = Author::where('id', $books[$key]->author_id)->first();
            //$books[$key]->author = $author->name;
        }

        return view('backend.pages.books.allbooks')->with('books', $books);
    }

  public function update(Request $request, $id)
  {
    
    $this->validate($request, [
      'title' => 'required|string',
      'category_id' => 'required',
      'country' => 'required',
      'old_price' => 'required',
    //   'page' => 'required',
    //   'tag' => 'required',
      'author_id' => 'required',
      'language' => 'required',
      'publisher_id' => 'required',
      'upcoming' => 'required',
      'cover' => 'max:500',
      'discount' => 'numeric|max:99'
    ]);
    $tags = explode(",", $request->tag);

    $book_cover = $request->file('cover');
    
    $book = Book::find($id);

    if($book_cover){
      $extension = $book_cover->getClientOriginalExtension(); // getting image extension
      $book_coverName = time() . '.' . $extension;
      $book_cover->move('images/book/cover/', $book_coverName);
      
      if (File::exists('images/book/cover/' . $book->cover)) {
        File::delete('images/book/cover/' . $book->cover);
      }
      $book->cover = config('rootUrl') . 'images/book/cover/' .$book_coverName;
    }


    $book->title = $request->title;
    $book->category_id = $request->category_id;
    $book->summary = $request->summary;
    $book->country = $request->country;
    $book->stock = $request->stock;
    $book->old_price = $request->old_price;
    $book->page = $request->page;
    $book->description = $request->description;
    $book->author_id = $request->author_id;
    $book->language = $request->language;
    $book->publisher_id = $request->publisher_id;
    $book->discount = $request->discount;
    $book->upcoming = $request->upcoming;
    $editor =$request->editor;
    $edition = $request->edition;
    $book->save();
    
   

    $tag = Tag::where('book_id', $id);
    $tag->delete();

    //  dd($tags);
    if (count($tags) > 0) {
      foreach ($tags as $tagText) {
        $tag = new Tag;
        $tag->book_id = $book->id;
        $tag->name = $tagText;
        $tag->save();
      }
    }

    $bookPages = $request->file('book_pageImages');

    if (count((array)$bookPages) > 0) {
      // dd($bookPages);
      foreach ($bookPages as $bookPage) {
        $extension1 = $bookPage->getClientOriginalExtension(); // getting image extension
        $bookPageName = time() . rand(10, 100) . '.' . $extension1;
        $bookPage->move('images/book/pages/', $bookPageName);

        $book_image = new BookImage;
        $book_image->book_id = $book->id;
        $book_image->image =  config('rootUrl') . 'images/book/pages/' . $bookPageName;
        $book_image->save();
      }
    }

    session()->flash('success', 'Book updated successfully');
    return redirect(route('admin.book.index'));
  }

}
