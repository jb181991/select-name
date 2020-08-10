<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;

class HomeController extends Controller
{
    public function getOptions()
    {
        $user = User::selectRaw('id, CONCAT(first_name, " ", last_name, " ") as text')->get();
        return response()->json(['user' => $user]);
    }

    public function addUser(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|string|max:30',
            'lastname'  => 'required|string|max:30',
            'phonenum'  => 'required|numeric',
            'email'     => 'required|string|email|max:255|unique:users'
        ]);

        
        $name = $request->lastname. '.' .$request->firstname;
        $email = strtolower(str_replace(' ', '', $name)). '@mail.com';
        $password = Hash::make('password');

        $user = User::updateOrCreate(
            ['first_name'   => ucwords($request->firstname),
                'last_name'    => ucwords($request->lastname)],
            ['first_name'   => ucwords($request->firstname),
            'last_name'     => ucwords($request->lastname),
            'phone_number'  => $request->phonenum,
            'email'         => $email,
            'password'      => $password]);

        if($user)
        {
            return response()->json(['user' => $user, 'error' => 0]);
        } else {
            return response()->json(['error' => 1]);
        }
    }
}
