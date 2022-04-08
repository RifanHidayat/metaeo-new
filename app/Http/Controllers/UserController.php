<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['group'])->get();
        return view('user.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        $groups = Group::all();
        return view('user.create', [
            'groups' => $groups,
        ]);
    }

    public function store(Request $request)
    {

        $username = $request->username;
        $email = $request->email;
        $usernameExist = User::where('username', $username)->first();
        if ($usernameExist !== null) {
            return response()->json([
                'message' => 'Username sudah digun
                akan',
                'code' => 400,
                'error' => true,
                'error_type' => 'val`idation',
            ], 400);
        }

        $emailExist = User::where('email', $email)->first();
        if ($emailExist !== null) {
            return response()->json([
                'message' => 'Email sudah digunakan',
                'code' => 400,
                'error' => true,
                'error_type' => 'validation',
            ], 400);
        }

        $user = new User;
        $user->name = $request->name;
        $user->position = $request->position;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->group_id = $request->group;

        try {
            $user->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }
    }

    public function edit($id)
    {
        $groups = Group::all();
        $user = User::findOrFail($id);
        return view('user.edit', [
            'user' => $user,
            'groups' => $groups,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->position = $request->position;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->group_id = $request->group;
    

        try {
            $user->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }
    }

    public function updateUserInfo(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->position = $request->position;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;
        // $user->username = $request->username;
        // $user->password = Hash::make($request->password);
        // $user->group_id = $request->group;

        try {
            $user->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }
    }

    public function updateAccount(Request $request, $id)
    {
        $user = User::find($id);
        $username = $request->username;
        $currentPassword = $request->current_password;

        // $isPasswordCorrect = User::query()->where('username', $username)->whereNotIn('id', [$id])->first();

        if (!Hash::check($currentPassword, $user->password)) {
            return response()->json([
                'message' => 'Password salah',
                'code' => 400,
                'error' => true,
            ], 400);
        }

        $usernameExist = User::query()->where('username', $username)->whereNotIn('id', [$id])->first();

        if ($usernameExist !== null) {
            return response()->json([
                'message' => 'Username telah digunakan',
                'code' => 400,
                'error' => true,
            ], 400);
        }

        $user->username = $request->username;

        if ($request->password !== null && $request->password !== '') {
            $user->password = Hash::make($request->password);
        }

        try {
            $user->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        try {
            $user->delete();
            return [
                'message' => 'data has been deleted',
                'error' => false,
                'code' => 200,
            ];
        } catch (Exception $e) {
            return [
                'message' => 'internal error',
                'error' => true,
                'code' => 500,
                'errors' => $e,
            ];
        }
    }
}
