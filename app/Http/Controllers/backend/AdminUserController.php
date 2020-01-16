<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Image;
use File;

use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
  //
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function create()
  {
    return view('backend.pages.admins.adduser');
  }

  public function addUser(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'email' => 'required|string|email|max:100|unique:users,email,',
      'password' => 'required|min:6',
      'c_password' => 'required|same:password',
      'address' => 'required',
      'phone_no' => 'required|max:15',
      'city' => 'required',
      'type' => 'required'
    ]);



    $file = $request->file('avatar');
    $extension = $file->getClientOriginalExtension(); // getting image extension
    $filename = time() . '.' . $extension;
    $file->move('images/admin/', $filename);

    // $image = $request->avatar;
    // $img = time() . '.'. $image->getClientOriginalExtension();
    //     $location = public_path('image/admin/' .$img);
    //     Image::make($image)->save($location);


    $admin = Admin::create([
      'name' => $request->name,
      'email' => $request->email,
      'address' => $request->address,
      'city' => $request->city,
      'phone_no' => $request->phone_no,
      'password' => Hash::make($request->password),
      'remember_token'  => str_random(50),
      'type'  => $request->type,
      'avatar' => $filename
    ]);

    session()->flash('success', 'Admin created successfully');
    return redirect(route('admin.user.index'));
  }

  public function index()
  {
    $admins = Admin::orderBy('id', 'desc')->get();
    return view('backend.pages.admins.alladmins')->with('admins', $admins);
  }

  public function edit($id)
  {
    $admin = Admin::find($id);
    return view('backend.pages.admins.edit')->with('admin', $admin);
  }

  public function delete($id)
  {
    $admin = Admin::find($id);

    if (!is_null($admin)) {
      $admin->delete();
      if (File::exists('images/admin/' . $admin->avatar)) {
        File::delete('images/admin/' . $admin->avatar);
      }
    }
    session()->flash('success', 'admin has deleted successfully !!');
    return back();
  }

  public function update(Request $request, $id)
  {

    $this->validate($request, [
      'name' => 'required|string',
      'email' => 'required|string|email|max:100|unique:users,email,',
      'address' => 'required',
      'phone_no' => 'required|max:15',
      'city' => 'required',
      'type' => 'required'
    ]);

    $admin = Admin::find($id);

    $file = $request->file('avatar');

    $password = $request->password;
    $c_password = $request->c_password;

    
     if($password){
      if($password == $c_password){
        $admin->password = Hash::make($password);
      }else{
        return back()->with('error', 'password does not matched');
      }
     }
   

    if ($file > 0) {
      //Delete the old image

      if (File::exists('images/admin/' . $admin->avatar)) {
        File::delete('images/admin/' . $admin->avatar);
      }

      $extension = $file->getClientOriginalExtension(); // getting image extension
      $filename = time() . '.' . $extension;
      $file->move('images/admin/', $filename);
      $admin->avatar = $filename;
    }

    $admin->name = $request->name;
    $admin->email = $request->email;
    $admin->address = $request->address;
    $admin->city = $request->city;
    $admin->phone_no = $request->phone_no;
    $admin->remember_token  = str_random(50);
    $admin->type  = $request->type;

    $admin->save();

    //Insert image into ProductImage model

    session()->flash('success', 'admin user updated successfully !!');
    return redirect(route('admin.user.index'));
  }
}
