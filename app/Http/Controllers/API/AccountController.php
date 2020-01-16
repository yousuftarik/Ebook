<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;

class AccountController extends Controller
{
   public function myaccount()
   {
    return response()->json(['success' => true, 'user' => Auth::user()]);
   }

   public function changepic(Request $request)
   {
    $file = $request->file('image');

    $user = Auth::user();
    $new_user = User::find($user->id);
    
    if ($file > 0) {
        //Delete the old image
        
        if (File::exists('images/user/' . $user->image)) {
          File::delete('images/user/' . $user->image);
        }
  
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $filename = time() . '.' . $extension;
        $file->move('images/user/', $filename);
        $new_user->image = $filename;
        $new_user->save();
      }
    return response()->json(['success' => true, 'message' => 'Profile picture changed successfully']);
   }
}
