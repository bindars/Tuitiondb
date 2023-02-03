<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();

        if (! $user) {
            return response()->json(['message' => 'Invalid credentials'], 400);
        }

        if ($request->password== $user->password) {
            return response()->json(['message' => 'Success','user'=>$user], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 400);
        }
    }
}
