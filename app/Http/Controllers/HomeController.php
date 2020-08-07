<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class HomeController extends Controller
{
    public function getOptions()
    {
        $user = User::select('id', 'name as text')->get();
        return response()->json(['user' => $user]);
    }

    public function addName(Request $request)
    {
        $email = strtolower(str_replace(' ', '', $request->name)). '@mail.com';
        $password = Hash::make('password');

        $user = User::updateOrCreate(
            ['name'     => ucwords($request->name)],
            ['name'     => ucwords($request->name),
            'email'     => $email,
            'password'  => $password]);

        return response()->json(['user' => $user]);
    }
}
