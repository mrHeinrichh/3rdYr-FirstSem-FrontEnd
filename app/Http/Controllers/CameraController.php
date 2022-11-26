<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camera;

class CameraController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Camera::all(),
            'status' => 'success',
            'message' => 'Get camera success',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required|alpha_dash',
            'shutterCount' => 'required|numeric',
            'quantity' => 'required|numeric',
            'costs' => 'required|numeric',
        ]);


        $data = new Camera([
            'model' => $request->get('model'),
            'shutterCount' => $request->get('shutterCount'),
            'quantity' => $request->get('quantity'),
            'costs' => $request->get('costs'),
        ]);


        if (!$data->save()) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Create camera fail',
            ]);
        }

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Create camera success',
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'data' => [Camera::find($id)],
            'status' => 'success',
            'message' => 'Get camera success',
        ]);
    }

    public function update(Request $request, $id)
    {

        $data = Camera::find($id);

        if (!$data) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Camera not found',
            ]);
        }

        $data->model = $request->get('model');
        $data->shutterCount = $request->get('shutterCount');
        $data->quantity = $request->get('quantity');
        $data->costs = $request->get('costs');

        if (!$data->save()) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Update camera fail',
            ]);
        }

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Update camera success',
        ]);
    }

    public function destroy($id)
    {
        $data = Camera::find($id);

        if (!$data) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Delete camera fail',
            ]);
        }

        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete camera success',
        ]);
    }
}