<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cat_order;
use App\Models\Category;
use DB;

class CategoryOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $categories = Category::orderBy('id', 'asc')->get();
        $catOrders = DB::table('cat_orders')
            ->join('categories', 'cat_orders.category_id', '=', 'categories.id')
            ->select('cat_orders.*', 'categories.name as category')
            ->orderBy('serial', 'asc')
            ->get();
        // dd($catOrders);
        return view('backend.pages.cat_orders.index', compact('categories', 'catOrders'));
    }

    public function edit($id)
    {
        $categories = Category::orderBy('id', 'asc')->get();
        $catOrders = DB::table('cat_orders')
            ->join('categories', 'cat_orders.category_id', '=', 'categories.id')
            ->select('cat_orders.*', 'categories.name as category')
            ->orderBy('serial', 'asc')
            ->get();
        $catOrder_old = DB::table('cat_orders')
            ->join('categories', 'cat_orders.category_id', '=', 'categories.id')
            ->select('cat_orders.*', 'categories.name as category')
            ->where('cat_orders.id', $id)
            ->first();
            // dd($catOrder_old->id);
        return view('backend.pages.cat_orders.edit', compact('categories', 'catOrders', 'catOrder_old'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'serial' => 'required'
        ]);

        if (Cat_order::where('serial', '=', $request->serial)->exists()) {
            session()->flash('error', 'Serial ' . $request->serial . ' already taken');
            return back();
        } elseif (Cat_order::where('category_id', '=', $request->category_id)->exists()) {
            session()->flash('error', 'Category already exist');
            return back();
        } else {
            $cat_order = Cat_order::create([
                'category_id' => $request->category_id,
                'serial' => $request->serial,
            ]);
            session()->flash('success', 'Category order added successfully');
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'serial' => 'required'
        ]);
        
        $cat_order = Cat_order::find($id);
        $cat_serial_exist = Cat_order::where('serial', '=', $request->serial)->first();

        if($cat_serial_exist){
            $cat_serial_update = Cat_order::find($cat_serial_exist->id);
            if ($cat_serial_exist->category_id != $id) {
                $cat_serial_update->serial = $cat_order->serial;
                $cat_order->serial = $request->serial;
            } else {
                $cat_serial_update->serial = $cat_order->serial;
                $cat_order->serial = $request->serial;
            }
            $cat_serial_update->save();
            $cat_order->save();
        
            session()->flash('success', 'Category order updated successfully');
            return back();
        }else{
            session()->flash('error', 'Serial not exist');
            return back();
        }
        
       
    }
}
