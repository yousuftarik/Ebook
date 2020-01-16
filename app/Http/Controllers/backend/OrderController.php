<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Sale;

use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
     //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
  
    public function deliverd($id)
    {
      $order = Order::find($id);
      $order->is_completed = 1;
      $order->save();

      $sale = new Sale;
      $sale->book_id = $order->book_id;
      $sale->quantity = $order->quantity;
      $sale->price = $order->total_price;
      $sale->save();

      session()->flash('success', 'order successfully set to delivered');
      return back();
    }
  
    public function seen($id)
    {
      $order = Order::find($id);
      $order->is_seen_by_admin = 1;
      $order->save();
      session()->flash('success', 'order successfully set to seen by admin');
      return back();
    }
  
    public function delete($id)
    {
      $order = Order::find($id);
      $order->delete();
      session()->flash('success', 'Order deleted successfully');
      return back();
    }
}
