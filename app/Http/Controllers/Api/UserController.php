<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class UserController extends ApiController
{
    public function register(Request $request) {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        //$token = JWTAuth::fromUser($user); // For JWT
        $token = $user->createToken('myAppToken')->plainTextToken;

        return response()->json(compact('user','token'), 201);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->json()->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Email or Password is incorrect!'], 400);
        }

        $token = $user->createToken('myAppToken')->plainTextToken;

        return response()->json(compact('user','token'), 201);
    }

    public function getAuthenticatedUser(Request $request) {
        $user = auth()->user();
        $token = $request->bearerToken();

        return response()->json(compact('user','token'), 201);
    }

    public function logout() {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'You have been successfully logged out!']);
    }

    public function index(Request $request)
    {
        return new DataTableCollectionResource(User::paginate());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        return new DataTableCollectionResource(User::paginate());
    }

    public function destroy(User $user)
    {
        $user->delete();

        return new DataTableCollectionResource(User::paginate());
    }
}
