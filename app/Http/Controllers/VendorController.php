<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = Vendor::where(function ($data) use ($request){
            if($request->q) {
                $data->where('name', 'like', '%' . $request->q . '%')
                     ->orWhere('phone', 'like', '%' . $request->q . '%')
                     ->orWhere('email', 'like', '%' . $request->q . '%');
            }
        })->paginate($request->row);

        $return_data = $this->successResponse($data, 'Data Retrived!');
        return response()->json($return_data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $data = Vendor::all();

        $return_data = $this->successResponse($data, 'Vendor Data Retrived Successfully');
        return response()->json($return_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = new Vendor;
            $validate = Validator::make($request->all(), $data->validation());
            if ($validate->fails()) {
                $return_data = $this->errorResponse($validate->errors(), 'Validation failed');
                return response()->json($return_data);
            }
            $request->merge(['password' => Hash::make($request->password)]);
            $data->fill($request->all())->save();
            $return_data = $this->successResponse($data, 'Vendor Data Added Successfully');

            DB::commit();
            return response()->json($return_data, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = Vendor::findOrFail($id);
        $data->fill($request->all())->save();
        $return_data = $this->successResponse($data, 'Data Edited!');
        return response()->json($return_data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $data = Vendor::findOrFail($id)->delete();
        $return_data = $this->successResponse($data, 'Data Deleted!');
        return response($return_data, 200);
    }
}
