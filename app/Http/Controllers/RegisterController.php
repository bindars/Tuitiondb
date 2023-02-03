<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'phone' => 'required|unique:users|max:255',
            'password' => 'required|min:6',
            'gender' => 'required|max:255',
      //      'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         //   'firebase_token' => 'required',
            'is_tutor' => 'required|boolean'
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'error' => $validatedData->errors()
            ], 400);
        }


        
        $user = new User;
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->password = $request->input('password');
        $user->gender = $request->input('gender');
     //   $user->firebase_token = $request->input('firebase_token');
        $user->is_tutor = $request->input('is_tutor');


        //  //check if post has photo
        //  if($request->profile_pic != ''){
        //     //choose a unique name for photo
        //     $profile_pic = time().'.jpg';
        //     file_put_contents('storage/profile_pic/'.$profile_pic,base64_decode($request->profile_pic));
        //     $user->profile_pic = $profile_pic;
        // }

        try {
            $user->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Successfully registered',
          //  'success' => true,
          //  'user' => $user
        ], 201);
    }








    
        public function updateFirebaseToken(Request $request)
        {
            $user = User::find($request->id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
            
            $user->firebase_token = $request->firebase_token;
            $user->save();
            
            return response()->json(['message' => 'Firebase token updated successfully'], 200);
            }









            public function resetPassword(Request $request)
            {
                $user = User::where('phone', $request->phone)->first();
            
                if (!$user) {
                    return response()->json(['message' => 'User not found'], 404);
                }
            
                $user->password = $request->password;
                $user->save();
            
                return response()->json(['message' => 'Password reset successfully'], 200);
            }
            
                    
        }






    

