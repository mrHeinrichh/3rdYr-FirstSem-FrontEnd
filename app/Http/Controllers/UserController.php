<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        return response()->json([
            'data' => User::all(),
            'status' => 'success',
            'message' => 'Get user success',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'firstName' => 'required',
            'lastName' => 'required',
            'age' => 'required',
            'password' => 'required'
        ]);

        $data = new User([
            'email' => $request->get('email'),
            'firstName' => $request->get('firstName'),
            'lastName' => $request->get('lastName'),
            'age' => $request->get('age'),
            'password' => bcrypt($request->get('password'))
        ]);


        if (!$data->save()) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Create user fail',
            ]);
        }

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Create user success',
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'data' => [User::find($id)],
            'status' => 'success',
            'message' => 'Get user success',
        ]);
    }

    public function update(Request $request, $id)
    {

        $data = User::find($id);

        if (!$data) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'User not found',
            ]);
        }

        $data->firstName = $request->get('firstName');
        $data->lastName = $request->get('lastName');
        $data->age = $request->get('age');

        if (!$data->save()) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Update user fail',
            ]);
        }

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Update user success',
        ]);
    }

    public function destroy($id)
    {
        $data = User::find($id);

        if (!$data) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Delete user fail',
            ]);
        }

        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete user success',
        ]);
    }
}