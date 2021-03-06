<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;
use App\Models\User;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::where(function ($data) use ($request){
            if($request->q) {
                $data->where('name', 'like', '%' . $request->q . '%')
                     ->orWhere('phone', 'like', '%' . $request->q . '%')
                     ->orWhere('email', 'like', '%' . $request->q . '%');
            }
        })->whereUserType(2)->paginate($request->row);

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
        if (auth()->user()->user_type == 1)
            $data = User::where('user_type', 2)->get();
        else
            $data = User::where('id', auth()->user()->id)->get();

        $return_data = $this->successResponse($data, 'Vendor Data Retrived Successfully');
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
        $data = new User;
        $validate = Validator::make($request->all(), $data->vendor_validation());
        if ($validate->fails()){
            $return_data = $this->errorResponse($validate->errors(), 'Validation faild');
            return response()->json($return_data);
        }
        $data->user_type = 2;
        $data->password = Hash::make($request->password);
        $data->fill($request->all())->save();
        $return_data = $this->successResponse($data, 'Vendor Data Added Successfully');
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
        $data = User::findOrFail($id);
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
        $data = User::findOrFail($id)->delete();
        $return_data = $this->successResponse($data, 'Data Deleted!');
        return response($return_data, 200);
    }
}
