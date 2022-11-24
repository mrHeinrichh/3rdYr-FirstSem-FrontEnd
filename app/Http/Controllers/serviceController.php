<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class serviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = service::orderBy('service_id', 'DESC')->get();
        return response()->json($service);
    }

    public function getService()
    {
        return view('ser i dx.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $operator = new operator;
        $operator->name = $request->name;
        $operator->contact_number = $request->contact_number;
        $operator->age = $request->age;
        $operator->address = $request->address;

        $files = $request->file('uploads');

        $operator->image_path = 'uploads/' . $files->getClientOriginalName();
        $operator->save();

        Storage::put('uploads/' . $files->getClientOriginalName(), file_get_contents($files));

        return response()->json(["success" => "Operator Created Successfully.", "operator" => $operator, "status" => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $operator = operator::find($id);
        return response()->json($operator);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $operator = operator::find($id);
        $operator = $operator->update($request->all());
        $operator = operator::find($id);

        return response()->json($operator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $operator = operator::findOrFail($id);

        if (File::exists("storage/" . $operator->image_path)) {
            File::delete("storage/" . $operator->image_path);
        }

        $operator->delete();

        $data = array('success' => 'deleted', 'code' => '200');
        return response()->json($data);
    }
}   
