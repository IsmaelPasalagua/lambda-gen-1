<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Api\ResponseController;

use App\Models\Users;
use App\Models\Roles;

class AuthController extends ResponseController
{
    // Sign in //
    public function signIn(Request $request)
    {
        // Validate request //
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check validation //
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Check if user exists //
        $user = Users::where('email', $request->email)->first();

        // Check validation //
        if (!$user) {
            return $this->sendError('User not found.', ['email' => 'User not found.']);
        }

        // Check if password is correct //
        if (!Hash::check($request->password, $user->password)) {
            return $this->sendError('Password is incorrect.', ['password' => 'Password is incorrect.']);
        }

        // Get user role //
        $role = Roles::where('_id', $user->role_id)->first();

        // Check validation //
        if (!$role) {
            return $this->sendError('Role not found.', ['role_id' => 'Role not found.']);
        }

        // Generate token //
        $token = $user->createToken($role->name);

        // Prepare response //
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        // Return response //
        return $this->sendResponse($response, 'User logged in successfully.');
    }

    // Sign out //
    public function signOut(Request $request)
    {
        // Check if user is logged in //
        if (!Auth::check()) {
            return $this->sendError('User not logged in.', ['user' => 'User not logged in.']);
        }

        // Get user and delete all tokens //
        $user = Auth::user();
        $user->tokens()->delete();

        // Return response //
        return $this->sendResponse([], 'User logged out successfully.');
    }

    // Sign up //
    public function signUp(Request $request)
    {
        // Validate request //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        // Check validation //
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Check if user exists //
        $user = Users::where('email', $request->email)->first();

        // Check validation //
        if ($user) {
            return $this->sendError('User already exists.', ['email' => 'User already exists.']);
        }

        // Get user role //
        $role = Roles::where('name', 'user')->first();

        // Create user //
        $user = Users::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->_id
        ]);

        // Check validation //
        if (!$user) {
            return $this->sendError('Something went wrong.', ['error' => 'Something went wrong.']);
        }

        // Prepare response //
        $response = [
            'user' => $user
        ];

        // Return response //
        return $this->sendResponse($response, 'User created successfully.');
    }
}

