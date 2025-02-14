<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'role_id' => 'required',
            'name' => 'required|min:4|string',
            'email' => 'required|email|string',
            'password' => 'required|min:8|string'
        ]);

        $user = User::create([
            'role_id' => $fields['role_id'],
            'company_id' => $request['company_id'],
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        return $user;

        $token = $user->createToken('API_TOKEN')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);

    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!Auth::attempt(['email' => $fields['email'], 'password' => $fields['password']]))
        {
            return response([
                'message' => 'Check login credentials'
            ], 401);
        }

        $token = $user->createToken('API_TOKEN', ['server:update'])->plainTextToken;
        $role = Role::where('id', $user->role_id)->first();

        return response()->json([
            'user' => $user,
            'token' => $token,
            'role' => $role->name,
            'company_id' => $user->company_id
        ], 201);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return ['Logged out'];
    }

    public function index(){
        return User::all();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $company = $user->ms_company()->delete();
        
        return $user->delete();
    }

    public function getSingleUser($id)
    {
        return User::find($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());

        return $user;
    }
}
