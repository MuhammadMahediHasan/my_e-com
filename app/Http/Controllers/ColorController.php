<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Color::where(function ($data) use ($request){
            if($request->q){
                $data->where('name', 'like', '%' . $request->q . '%');
            }
        })->paginate($request->row);

        $return_data = $this->successResponse($data, 'Data Retrived!');
        return response($return_data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Color::all();
        $return_data = $this->successResponse($data, 'Color Data Retrived Successfully');
        return response()->json($return_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Color;
        $data->fill($request->all())->save();
        $return_data = $this->successResponse($data, 'Color Data Added Successfully');
        return response()->json($return_data);
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
        //
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
        $data = Color::findOrFail($id);
        $data->fill($request->all())->save();
        $return_data = $this->successResponse($data, 'Data Edited!');
        return response($return_data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Color::findOrFail($id)->delete();
        $return_data = $this->successResponse($data, 'Data Deleted!');
        return response($return_data, 200);
    }
}
