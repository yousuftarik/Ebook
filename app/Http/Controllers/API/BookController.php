<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookImage;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Review;
use App\Models\Book;
use App\Models\WishList;
use App\Models\Order;
use App\Models\Cat_order;

use Illuminate\Support\Facades\DB;
use Auth;

class BookController extends Controller
{
    
public function book($id)
    {
        $book = DB::table('books')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
            ->select('books.*', 'categories.name as category', 'authors.name as author', 'publishers.name as publisher')
            ->where('books.id', $id)
            ->first();


        $book_pages = BookImage::where('book_id', $id)->select('image')->get();

        $book->new_price = (int) $book->old_price - (int) ($book->old_price * ($book->discount / 100));


        return response()->json(['success' => true, 'book' => $book, 'pages' => $book_pages]);
    }


    public function authors()
    {

        $authors = Author::orderBy('id')->take(50)->inRandomOrder()->get();

        return response()->json(['success' => true, 'authors' => $authors]);
    }

    public function authors_all()
    {

        $authors = Author::orderBy('id')->paginate(50);

        return response()->json(['success' => true, 'authors' => $authors]);
    }

    public function authors_top()
    {

        $authors = Author::orderBy('id', 'desc')->where('weekly_top', 1)->get();

        return response()->json(['success' => true, 'authors' => $authors]);
    }

    public function authorBooks($id)
    {

        $books = 'test';
        $author = Author::where('id', $id)->first();

        return response()->json(['success' => true, 'author' => $author, 'books' => $books]);
    }

    public function author($id)
    {

        $author = Author::where('id', $id)->first();
        // $author->image = config('rootUrl') . 'images/author/' . $author->image;

        return response()->json(['success' => true, 'author' => $author]);
    }

    public function categories()
    {

        $categories = Category::orderBy('id', 'asc')->get();

        return response()->json(['success' => true, 'categories' => $categories]);
    }

    public function categories_all()
    {

        $categories = Category::orderBy('id')->paginate(50);

        return response()->json(['success' => true, 'categories' => $categories]);
    }

    public function category($id)
    {

        $category = Category::where('id', $id)->first();
        $books = DB::table('books')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
            ->select('books.*', 'categories.name as category', 'authors.name as author', 'publishers.name as publisher')
            ->where('books.category_id', $id)
            ->paginate(20);

        foreach ($books as $book) {
            $book->new_price = (int) $book->old_price - (int) ($book->old_price * ($book->discount / 100));
        }
        return response()->json(['success' => true, 'category' => $category, 'books' => $books,]);
    }

    public function publishers()
    {

        $publishers = Publisher::orderBy('image', 'desc')->take(50)->inRandomOrder()->get();
        return response()->json(['success' => true, 'publishers' => $publishers]);
    }

    public function publisher_all()
    {

        $publishers = Publisher::orderBy('id')->paginate(50);

        return response()->json(['success' => true, 'publishers' => $publishers]);
    }

    public function publisherBooks($id)
    {

        // $books = Book::where('publisher_id', $id)->get();
        $publisher = Publisher::where('id', $id)->first();

        $books = DB::table('books')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->select('books.*', 'categories.name as category', 'authors.name as author')
            ->where('books.publisher_id', $id)
            ->paginate(20);


        return response()->json(['success' => true, 'publisher' => $publisher, 'books' => $books]);
    }

    public function publisher($id)
    {

        $publisher = Publisher::where('id', $id)->get();
        // $publisher[0]->image = public_path().'/uploads/images/'.$publisher[0]->image;
        return response()->json(['success' => true, 'publisher' => $publisher]);
    }

    public function reviews($id)
    {

        $reviews = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->select('reviews.*', 'users.name as username')
            ->where('reviews.book_id', $id)
            ->get();

        $fivestar = Review::where('rating', '=', 5)->where('book_id', $id)->count();
        $fourstar = Review::where('rating', '=', 4)->where('book_id', $id)->count();
        $threestar = Review::where('rating', '=', 3)->where('book_id', $id)->count();
        $twostar = Review::where('rating', '=', 2)->where('book_id', $id)->count();
        $onestar = Review::where('rating', '=', 1)->where('book_id', $id)->count();

        return response()->json([
            'success' => true, 'fivestar' => $fivestar,
            'fourstar' => $fourstar,
            'threestar' => $threestar,
            'twostar' => $twostar,
            'onestar' => $onestar,
            'reviews' => $reviews
        ]);
    }

    public function reviewDelete($id)
    {
        $user_id = Auth::user();
        $review = Review::where('id', $id)->where('user_id', $user_id->id)->first();
        $review->delete();

        return response()->json(['success' => true, 'message' => 'review deleted successfully']);
    }

    public function review(Request $request)
    {
        $request->validate([
            'book_id' => 'required',
            'rating' => 'required',
        ]);

        $user = Auth::user();

        $existing_review = Review::where('book_id', '=', $request->book_id)
            ->where('user_id', '=', $user->id)->first();

        if (
            Review::where('book_id', '=', $request->book_id)
            ->where('user_id', '=', $user->id)
            ->exists()
        ) {
            $review = Review::find($existing_review->id);

            $review->rating = $request->rating;
            $review->review_text = $request->review_text;
            $review->save();
            return response()->json(['success' => true, 'reviews' => $review]);
        } else {
            $review = Review::create([
                'book_id' => $request->book_id,
                'user_id' => $user->id,
                'rating' => $request->rating,
                'review_text' => $request->review_text,
                'like' => 0,
                'dislike' => 0

            ]);

            return response()->json(['success' => true, 'reviews' => $review]);
        }
    }

    public function wishlistAdd(Request $request)
    {
        $request->validate([
            'book_id' => 'required',
        ]);

        $user = Auth::user();
        if (WishList::where('book_id', '=', $request->book_id)
            ->where('user_id', '=', $user->id)
            ->exists()
        ) {
            return response()->json(['error' => true, 'message' => 'Book already exist to list']);
        } else {
            $wish = new WishList;
            $wish->book_id = $request->book_id;
            $wish->user_id = $user->id;
            $wish->save();
            return response()->json(['success' => true, 'message' => 'Book added to wishlist']);
        }
    }

    public function orderAdd(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'book_id' => 'required',
            'payment_method' => 'required',
            'quantity' => 'required',
            'phone_number' => 'required',
            'shiping_address' => 'required',
            'order_type' => 'required',
            'total_price' => 'required',
            'location' => 'required'
        ]);


        $order = new Order;
        $order->book_id = $request->book_id;

        if ($request->user_id) {
            $order->user_id = $request->user_id;
        } else if (Auth::user()) {
            $user = Auth::user();
            $order->user_id = $user->id;
        } else {
            $order->user_id = 0;
        }

        $order->name = $request->name;
        $order->location = $request->location;
        $order->ip_address = $request->ip();
        $order->payment_method = $request->payment_method;
        $order->quantity = $request->quantity;
        $order->phone_number = $request->phone_number;
        $order->shiping_address = $request->shiping_address;
        $order->transection_id = $request->transection_id;
        $order->order_type = $request->order_type;
        $order->total_price = $request->total_price;
        $order->is_completed = 0;
        $order->is_seen_by_admin = 0;


        if ($order->save()) {
            return response()->json([
                'success' => true,
                'message' => 'order successfull',
                'order' => $order
            ]);
        } else {
            return response()->json([
                'error' => 'Error occured',
            ]);
        }
    }

    public function orders()
    {
        $user = Auth::user();

        $orders = DB::table('orders')
            ->join('books', 'orders.book_id', '=', 'books.id')
            ->select('orders.*', 'books.title as book_name', 'books.cover as cover')
            ->where('user_id', '=', $user->id)
            ->get();

        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }

    public function most_discounted()
    {
        $books = Book::where('discount', '>', 30)->get();
        return response()->json([
            'success' => true,
            'books' => $books
        ]);
    }

    public function book_order()
    {
        $cat_orders = DB::table('cat_orders')
            ->join('categories', 'cat_orders.category_id', '=', 'categories.id')
            ->select('cat_orders.*', 'categories.name as category')
            ->orderBy('serial', 'asc')
            ->get();

        foreach ($cat_orders as $key => $value) {
            $books = Book::where('category_id', $cat_orders[$key]->category_id)->orderBy('cover', 'desc')->take(20)->get();
            foreach ($books as $book) {
                $book->new_price = (int) $book->old_price - (int) ($book->old_price * ($book->discount / 100));
                // return response()->json($books[$key]->cover);
            }
            $cat_orders[$key]->books = $books;
        }

        return response()->json([
            'success' => true,
            'cat_orders' => $cat_orders
        ]);
    }

    public function author_filter(Request $request)
    {
        $data = $request->get('data');

        $authors = Author::where('name', 'like', "%{$data}%")
            ->take(20)
            ->get();

        return response()->json([
            'success' => true,
            'authors' => $authors
        ]);
    }


    public function publisher_filter(Request $request)
    {
        $data = $request->get('data');

        $publishers = Publisher::where('name', 'like', "%{$data}%")
            ->take(20)
            ->get();

        return response()->json([
            'success' => true,
            'publishers' => $publishers
        ]);
    }

    public function search(Request $request)
    {
        $data = $request->get('data');

        $joinAuthor = Author::where('name', 'like', "%{$data}%")->first();
        $joinPublisher = Publisher::where('name', 'like', "%{$data}%")->first();
        $joinCategory = Category::where('name', 'like', "%{$data}%")->first();

        $books = Book::where('title', 'like', "%{$data}%")
            ->orWhere('description', 'like', "%{$data}%")
            ->orWhere('summary', 'like', "%{$data}%")
            // ->orWhere('author_id', 'like', "%{$joinAuthor->id}%")
            // ->orWhere('publisher_id', 'like', "%{$joinPublisher->id}%")
            // ->orWhere('category_id', 'like', "%{$joinCategory->id}%")
            ->take(10)
            ->get();

        foreach ($books as $key => $value) {
            $books[$key]->new_price = (int) $books[$key]->old_price - (int) ($books[$key]->old_price * ($books[$key]->discount / 100));
            $author = Author::where('id', $books[$key]->author_id)->first();
            $books[$key]->author = $author->name;
        }

        return response()->json([
            'success' => true,
            'books' => $books
        ]);
    }

    public function category_search(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = Category::where('name', 'LIKE', "%{$query}%")->take(10)->get();

            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach ($data as $row) {
                $output .= '
        <li category_id="' . $row->id . '" class="search_sugestion cat_li">' . $row->name . '</li>
        ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    public function publisher_search(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = Publisher::where('name', 'LIKE', "%{$query}%")->take(10)->get();

            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach ($data as $row) {
                $output .= '
        <li publisher_id="' . $row->id . '" class="search_sugestion pub_li">' . $row->name . '</li>
        ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    public function author_search(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = Author::where('name', 'LIKE', "%{$query}%")->take(10)->get();

            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach ($data as $row) {
                $output .= '
        <li author_id="' . $row->id . '" class="search_sugestion auth_li">' . $row->name . '</li>
        ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
}
