<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    


    public function usersShow($id)
    {
        $userwise = User::findOrFail($id);
        return response()->json(['data' => $userwise]);
    }
    
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json(['data' => $users]);
    }
    
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;

        $user->phone = $request->phone;
        $user->company_name = $request->company_name;
        $user->designation = $request->designation;
        $user->userStatus = $request->userStatus;
        $user->address = $request->address;

      
        $user->password = bcrypt($request->password);
        $user->save();

        return $user;
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            $user->api_token = Str::random(60);
            $user->save();

            return $user;
        }

        return response()->json(['message' => 'Something went wrong'], 401);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();
        $user->api_token = null;
        $user->save();

        return response()->json(['message' => 'You are successfully logged out'], 200);
    }


    public function updateStatus(Request $request, $id)
{
    $user = User::findOrFail($id);

    $currentStatus = $user->userStatus;

    // Toggling the status dynamically
    $newStatus = $currentStatus === 'active' ? 'inactive' : 'active';
    
    $user->userStatus = $newStatus;
    $user->save();

    return response()->json(['message' => 'User status updated to ' . $newStatus]);
}

}