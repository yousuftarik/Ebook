<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Book;

class DiscountController extends Controller
{
     //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::orderBy('id', 'desc')->get();
        $publishers = Publisher::orderBy('id', 'desc')->get();
        return view('backend.pages.discount.index', compact('authors', 'publishers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'discount' => 'numeric|max:99'
        ]);

        if(intval($request->publisher_id)){
          Book::where('publisher_id', '=', $request->publisher_id)->update(['discount' => $request->discount]);
          if(intval($request->author_id)){
            Book::where('author_id', '=', $request->author_id)->update(['discount' => $request->discount]);
              return back()->with('success', 'Discount set successfull to '.$request->discount.'%');
            }else{
                return back()->with('success', 'Discount set successfull to '.$request->discount.'%');
            }
        }else{
            return back()->with('error', 'Something went wrong');
        }
        
       

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
