<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accessory;

class AccessoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Accessory::all(),
            'status' => 'success',
            'message' => 'Get accessory success',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|alpha_dash',
            'quantity' => 'required|numeric',
            'costs' => 'required|numeric',
        ]);


        $data = new Accessory([
            'description' => $request->get('description'),
            'quantity' => $request->get('quantity'),
            'costs' => $request->get('costs'),
        ]);


        if (!$data->save()) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Create accessory fail',
            ]);
        }

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Create accessory success',
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'data' => [Accessory::find($id)],
            'status' => 'success',
            'message' => 'Get accessory success',
        ]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'description' => 'alpha_dash',
            'quantity' => 'numeric',
            'costs' => 'numeric',
        ]);

        $data = Accessory::find($id);

        if (!$data) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Accessory not found',
            ]);
        }

        $data->description = $request->get('description');
        $data->quantity = $request->get('quantity');
        $data->costs = $request->get('costs');

        if (!$data->save()) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Update accessory fail',
            ]);
        }

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Update accessory success',
        ]);
    }

    public function destroy($id)
    {
        $data = Accessory::find($id);

        if (!$data) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Delete accessory fail',
            ]);
        }

        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete accessory success',
        ]);
    }
}