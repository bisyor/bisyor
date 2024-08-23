<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Models\References\UserHistory;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * Redirect route
     *
     * @return string
     */
    protected function redirectTo()
    {
        return route('verify-code-get');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        $phone = str_replace('-', '', $data['phone']);
        $data['phone'] = $phone;
        $validator = Validator::make($data, [
//            'password' => ['required', 'string', 'min:6'],
//            'email' => !empty($data['email']) ? ['string', 'max:255', 'unique:users', 'email'] : [],
            'phone' => ['string', 'max:255', 'unique:users'],
            'agree' => ['required'],
        ],[
            'phone.unique' => trans('messages.This phone have in other user')
        ])->setAttributeNames(
            ['agree' => "\"" . trans('messages.Terms link') . "\""],
        );;

        $validator->after(function ($validator) use ($data) {
            if (empty($data['email']) && empty($data['phone'])) {
                $validator->errors()->add('phone_email', trans('messages.Enter phone number') );
            }
        });

        return $validator;
    }

    public function register(Request $request)
    {
        if(empty($request->email)) $login = $request->phone;
        else $login = $request->email;
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user) ?: redirect()->route('verify-code-get', ['login' => $login ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $phone = str_replace('-', '', $data['phone']);
        $user = User::create([
            'phone' => $phone,
//            'email' => $data['email'],
            'password' => Hash::make($phone),
        ]);
        if($user != null) UserHistory::setValue(2, $user->id);
        return $user;
    }
}
