<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    function index(Request $request){

        // $user = new User();
        // $user->name = 'Jhonny';
        // $user->email = 'asd@asd.com';
        if($request->isJson()){
            $user = User::all();
            return response()->json($user, 200);
        }
        return response()->json(['user'=>'Unauthorized'], 401, []);
    }

    function create(Request $request){
        if($request->isJson()){
           // TODO: Create
           $data = $request->json()->all();
           $user = User::create([
               'name' => $data['name'],
               'lastname' => $data['lastname'],
               'desc' => $data['desc'],
               'email' => $data['email'],
               'password' => Hash::make($data['password']),
               'api_token' => str_random(60)

           ]);
           return response()->json($user, 200);
        }
        return response()->json(['user'=>'Unauthorized'], 401, []);
    }

    function getUserById(Request $request, $id){
        if($request->isJson()){
            try {
                $user = User::findOrFail($id);
                return response()->json($user, 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error'=>$e], 406);
            }
        }
        return response()->json(['user'=>'Unauthorized'], 401, []);
    }

    function updateUserById(Request $request, $id){
        if($request->isJson()){
            try {
                $user = User::findOrFail($id);

                $data = $request->json()->all();

                $user->name = $data['name'];
                $user->lastname = $data['lastname'];
                $user->desc = $data['desc'];
                
                $user->save();
                return response()->json($user, 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error'=>$e], 406);
            }
        }
        return response()->json(['user'=>'Unauthorized'], 401, []);
    }

    function deleteUserById(Request $request, $id){
        if($request->isJson()){
            try {
                $user = User::findOrFail($id);
                $user->delete();

                return response()->json($user, 200);

            } catch (ModelNotFoundException $e) {
                return response()->json(['error'=>$e], 406);
            }
        }
        return response()->json(['user'=>'Unauthorized'], 401, []);
    }

    function getToken(Request $request){
        if($request->isJson()){
            try {
                $data = $request->json()->all();
                $user = User::where('email', $data['email'])->first();
                if($user && Hash::check($data['password'], $user->password)) {
                    return response()->json($user, 200);
                }else{
                    return response()->json(['error'=>'No content'], 406);
                }
            } catch (\Throwable $e) {
                return response()->json(['error'=>$e], 406);
            }
        }
        return response()->json(['user'=>'Unauthorized'], 401, []);
    }
}
