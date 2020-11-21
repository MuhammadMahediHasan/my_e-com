<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Image;
use File;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Slider::where(function ($data) use ($request){
            if($request->q){
                $data->where('title', 'like', '%' . $request->q . '%');
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
        $data = new Slider;
        $requested_data = $request->all();
        $name = time().".webp";
        $upload_path = "backend_assets/image/slider/". $name;
        $image_upload = Image::make($request->image)->resize(960, 480);
        $image_upload->save($upload_path);
        $requested_data['image'] = $name;
        $data->fill($requested_data)->save();

        $return_data = $this->successResponse($data, 'Slider Data Added Successfully');
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
        $data = Slider::findOrFail($id);
        if ($data->status == 1)
            $data->update(['status' => 0]);
        else
            $data->update(['status' => 1]);

        $return_data = $this->successResponse($data, 'Status changed!');
        return response($return_data, 200);
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
        $data = Slider::findOrFail($id);
        $requested_data = $request->all();

        if ($data->image != $request->image) {
            if (File::exists('backend_assets/image/slider/'.$data->image)) {
                File::delete('backend_assets/image/slider/'.$data->image);
            }
            $name = time().".webp";
            $upload_path = "backend_assets/image/slider/". $name;
            $image_upload = Image::make($request->image)->resize(960, 480);
            $image_upload->save($upload_path);
            $requested_data['image'] = $name;
        }

        $data->fill($requested_data)->save();
        $return_data = $this->successResponse($data, 'Slider Data Added Successfully');
        return response()->json($return_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
