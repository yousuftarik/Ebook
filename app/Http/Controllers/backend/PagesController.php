<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Excel;

// use App\Models\Product;
// use App\Models\ProductImage;
use Image;

class PagesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }
  

  public function index()
  {

    // dd($total_revenue);
    $orders =  DB::table('orders')
    ->join('books', 'orders.book_id', '=', 'books.id')
    ->join('authors', 'books.author_id', '=', 'authors.id')
    ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
    ->select('orders.*', 'books.title as book' 
    ,'authors.name as author'
    ,'publishers.name as publisher'
    )
    ->where('is_completed', 0)
    ->orderBy('id', 'desc')
    ->get();

    $total_orders = count($orders);

    $delivered =  DB::table('orders')
    ->join('books', 'orders.book_id', '=', 'books.id')
    ->join('authors', 'books.author_id', '=', 'authors.id')
    ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
    ->select('orders.*', 'books.title as book' 
    ,'authors.name as author'
    ,'publishers.name as publisher'
    )
    ->where('is_completed', 1)
    ->orderBy('id', 'desc')
    ->get();

    $sales = Sale::get()->count();

    $total_revenue = Sale::get(['price'])->sum('price');
    // $total_revenue = Sale::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get(['price'])->sum('price');

    $bookSold =  DB::table('sales')->join('books', 'sales.book_id', '=', 'books.id')
    ->join('authors', 'books.author_id', '=', 'authors.id')
    ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
    ->select('sales.*', 'sales.updated_at as sell_date', 'books.*',
    'authors.name as author'
    ,'publishers.name as publisher'
    )->get();

    // dd($bookSold);

    // dd($orders);

    $orderFrom = null;
    $orderTo = null;  
    $dOrderFrom = null;
    $dOrderTo = null;
    $sellTo = null;
    $sellFrom = null;

    return view('backend.pages.index', compact('total_orders', 'orders', 'sales', 'total_revenue', 'delivered', 'bookSold'
    ,'orderFrom', 'orderTo', 'dOrderFrom', 'dOrderTo', 'sellFrom', 'sellTo'
  ));
  }

  public function orderFiltered(Request $request)
  {

    // return [$request->from, $request->to];

    if($request->from){
      $orders =  DB::table('orders')
    ->join('books', 'orders.book_id', '=', 'books.id')
    ->join('authors', 'books.author_id', '=', 'authors.id')
    ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
    ->select('orders.*', 'books.title as book' 
    ,'authors.name as author'
    ,'publishers.name as publisher'
    )
    ->where('is_completed', 0)
    ->whereBetween(
      'orders.created_at', 
        [
            $request->from,
            $request->to
        ]
    )
    ->orderBy('id', 'desc')
    ->get();
    
    $orderFrom = $request->from;
    $orderTo = $request->to;
    $dOrderFrom = null;
    $dOrderTo = null;
    $sellTo = null;
    $sellFrom = null;

    $total_orders = count($orders);

    $delivered =  DB::table('orders')
    ->join('books', 'orders.book_id', '=', 'books.id')
    ->join('authors', 'books.author_id', '=', 'authors.id')
    ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
    ->select('orders.*', 'books.title as book' 
    ,'authors.name as author'
    ,'publishers.name as publisher'
    )
    ->where('is_completed', 1)
    ->orderBy('id', 'desc')
    ->get();

    $sales = Sale::get()->count();

    $total_revenue = Sale::get(['price'])->sum('price');
    // $total_revenue = Sale::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get(['price'])->sum('price');

    $bookSold =  DB::table('sales')->join('books', 'sales.book_id', '=', 'books.id')
    ->join('authors', 'books.author_id', '=', 'authors.id')
    ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
    ->select('sales.*', 'sales.updated_at as sell_date', 'books.*',
    'authors.name as author'
    ,'publishers.name as publisher'
    )->get();

    // dd($bookSold);

    // dd($orders);
    return view('backend.pages.index', compact('total_orders', 'orders', 'sales', 'total_revenue', 'delivered', 'bookSold'
    ,'orderFrom', 'orderTo', 'dOrderFrom', 'dOrderTo', 'sellFrom', 'sellTo'
    ));
    }else if($request->dOrderFrom){
      $orders =  DB::table('orders')
      ->join('books', 'orders.book_id', '=', 'books.id')
      ->join('authors', 'books.author_id', '=', 'authors.id')
      ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
      ->select('orders.*', 'books.title as book' 
      ,'authors.name as author'
      ,'publishers.name as publisher'
      )
      ->where('is_completed', 0)
      ->orderBy('id', 'desc')
      ->get();
      
      $orderFrom = null;
      $orderTo = null;
      $dOrderFrom = $request->dOrderFrom;
      $dOrderTo = $request->dOrderTo;
      $sellTo = null;
      $sellFrom = null;

      $total_orders = count($orders);
  
      $delivered =  DB::table('orders')
      ->join('books', 'orders.book_id', '=', 'books.id')
      ->join('authors', 'books.author_id', '=', 'authors.id')
      ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
      ->select('orders.*', 'books.title as book' 
      ,'authors.name as author'
      ,'publishers.name as publisher'
      )
      ->where('is_completed', 1)
      ->whereBetween(
        'orders.created_at', 
          [
              $request->dOrderFrom,
              $request->dOrderTo
          ]
      )
      ->orderBy('id', 'desc')
      ->get();
  
      $sales = Sale::get()->count();
  
      $total_revenue = Sale::get(['price'])->sum('price');
      // $total_revenue = Sale::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get(['price'])->sum('price');
  
      $bookSold =  DB::table('sales')->join('books', 'sales.book_id', '=', 'books.id')
      ->join('authors', 'books.author_id', '=', 'authors.id')
      ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
      ->select('sales.*', 'sales.updated_at as sell_date', 'books.*',
      'authors.name as author'
      ,'publishers.name as publisher'
      )->get();
  
      // dd($bookSold);
  
      // dd($orders);
      return view('backend.pages.index', compact('total_orders', 'orders', 'sales', 'total_revenue', 'delivered', 'bookSold'
      ,'orderFrom', 'orderTo', 'dOrderFrom', 'dOrderTo', 'sellFrom', 'sellTo'
      ));
    }else if($request->sellTo){
      // dd($total_revenue);
    $orders =  DB::table('orders')
    ->join('books', 'orders.book_id', '=', 'books.id')
    ->join('authors', 'books.author_id', '=', 'authors.id')
    ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
    ->select('orders.*', 'books.title as book' 
    ,'authors.name as author'
    ,'publishers.name as publisher'
    )
    ->where('is_completed', 0)
    ->orderBy('id', 'desc')
    ->get();

    $total_orders = count($orders);

    $delivered =  DB::table('orders')
    ->join('books', 'orders.book_id', '=', 'books.id')
    ->join('authors', 'books.author_id', '=', 'authors.id')
    ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
    ->select('orders.*', 'books.title as book' 
    ,'authors.name as author'
    ,'publishers.name as publisher'
    )
    ->where('is_completed', 1)
    ->orderBy('id', 'desc')
    ->get();

    $sales = Sale::get()->count();

    $total_revenue = Sale::get(['price'])->sum('price');
    // $total_revenue = Sale::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get(['price'])->sum('price');
    
    $orderFrom = null;
    $orderTo = null;  
    $dOrderFrom = null;
    $dOrderTo = null;
    $sellTo = $request->sellTo;
    $sellFrom = $request->sellFrom;

    $bookSold =  DB::table('sales')->join('books', 'sales.book_id', '=', 'books.id')
    ->join('authors', 'books.author_id', '=', 'authors.id')
    ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
    ->select('sales.*', 'sales.updated_at as sell_date', 'books.*',
    'authors.name as author'
    ,'publishers.name as publisher'
    )
    ->whereBetween(
      'sales.created_at', 
        [
            $sellFrom,
            $sellTo
        ]
    )
    ->get();

    // dd($bookSold);

    // dd($orders);


    return view('backend.pages.index', compact('total_orders', 'orders', 'sales', 'total_revenue', 'delivered', 'bookSold'
    ,'orderFrom', 'orderTo', 'dOrderFrom', 'dOrderTo', 'sellFrom', 'sellTo'
  ));
    }
  }

  public function exportOrdersPDF(Request $request)
  {
    $data = $request->orderNotdelivered;

    return Excel::store('itsolutionstuff_example', function($excel) use ($data) {
      $excel->sheet('mySheet', function($sheet) use ($data)
        {
        $sheet->fromArray($data);
        });
       })->download("pdf");
  }
  
  public function dashboard()
  {
    
    return view('backend.pages.dashboard');
  }

 
}
