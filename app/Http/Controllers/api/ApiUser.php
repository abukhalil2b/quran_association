<?php

namespace App\Http\Controllers\api;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
class ApiUser extends Controller
{
	public function login(Request $request) {

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response(['success'=>false,'message'=>"البيانات خاطئة"], 201);
    }

    $response = [
        'success'=>true,
        'userType'=>$user->userType,
        'token' => $user->createToken('user')->plainTextToken
    	];
    return response($response, 201);
            

	}


    public function getUserInfo(Request $request) {
        try {
            $user = auth()->user();
            $response['user'] = new UserResource($user);
            $response['success']=true;
            return response($response, 201);
        } catch (Exception $e) {
            $response['success']=false;
            $response['message']=$e;
            return response($response, 500);
        }

    }


}
	
