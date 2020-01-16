<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Models\Payment;
use App\Models\District;

use App\Notifications\VerifyRegistration;

class RegisterController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  use RegistersUsers;

  /**
  * Where to redirect users after registration.
  *
  * @var string
  */
  protected $redirectTo = '/';

  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('guest');
  }

/**
 * @override
 * showRegistrationForm
 *
 * Display the registration form
 *
 * @return void view
 */
  public function showRegistrationForm()
  {
    $payments = Payment::orderBy('priority', 'asc')->get();
    return view('auth.register', compact('payments'));
  }



  /**
  * Get a validator for an incoming registration request.
  *
  * @param  array  $data
  * @return \Illuminate\Contracts\Validation\Validator
  */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'first_name' => 'required|string|max:30',
      'last_name' => 'nullable|string|max:15',
      'email' => 'required|string|email|max:100|unique:users',
      'password' => 'required|string|min:6|confirmed',
      'phone_no' => 'required|max:15',
      'country' => 'required|max:100',
      'payment' => 'required|max:100',
      'transactionNo' => 'required|max:100',
      // 'payment_id' => 'required|numeric',
      
    ]);

  }

  /**
  * Create a new user instance after a valid registration.
  *
  * @param  array  $data
  * @return \App\User
  */
  protected function register(Request $request)
  {

   
      // if ($request->transaction_id == NULL || empty($request->transaction_id)) {
      //   session()->flash('sticky_error', 'Please give transaction ID for your payment');
      //   return back();
      // }
    
    $user = User::create([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'company_name' => $request->company_name,
      'country' => $request->country,
      'username' => str_slug($request->first_name.$request->last_name),
      'phone_no' => $request->phone_no,
      'ip_address' => request()->ip(),
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'remember_token'  =>str_random(50),
      'payment' => $request->payment,
      'transactionNo' => $request->transactionNo,
      'status'  => 0,
    ]);

     // 'full_name' => $request->full_name,
    //   'company_name' => $request->company_name,
    //   'country' => $request->country,
    //   'email' => $request->email,
    //   'phone_no' => $request->phone_no,
    //   'ip_address' => request()->ip(),
    //   'password' => Hash::make($request->password),
    //   'remember_token' => str_random(50),
    //   'status'  => 0,

    $user->notify(new VerifyRegistration($user));

    session()->flash('success', 'A confirmation email has sent to you.. Please check and confirm your email');
    return redirect('/');;


  }
}
