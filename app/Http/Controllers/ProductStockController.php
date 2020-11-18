<?php

namespace App\Http\Controllers;

use App\Models\ProductChildStock;
use App\Models\ProductStock;
use App\Models\ProductTotalStock;
use Illuminate\Http\Request;
use App\Models\Product;
use Str;

class ProductStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Product::where(function ($data) use ($request){
            if($request->q){
                $data->where('name', 'like', '%' . $request->q . '%')
                     ->orWhere('slug', 'like', '%' . $request->q . '%')
                     ->orWhere('code', 'like', '%' . $request->q . '%');
            }
            if ($request->category_id) {
                $data->where('category_id', $request->category_id);
            }
            if ($request->sub_category_id) {
                $data->where('sub_category_id', $request->sub_category_id);
            }
            if ($request->child_category_id) {
                $data->where('child_category_id', $request->child_category_id);
            }
        })->with(['color.color', 'size.size'])->limit(25)->get();

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
        $product_stock = new ProductStock;
        $product_stock->fill($request->all())->save();

        $total_stocks = ProductTotalStock::all();
        foreach ($request->stock_cart as $key => $value) {
            $data = collect($total_stocks)->where('product_id', $value['product_id'])
                                          ->where('color_id', $value['color_id'])
                                          ->where('size_id', $value['size_id'])
                                          ->first();
            if ($data) {
                $stock = ProductTotalStock::where('product_id', $value['product_id'])->first();
                $stock->update(['quantity' => $data->quantity + $value['quantity']]);
            } else {
                $stock = new ProductTotalStock;
                $stock->sku = Str::random(3).substr(time(), 6,8). Str::random(3);
                $stock->fill($value)->save();
            }

            $stock_child = new ProductChildStock;
            $stock_child->product_stock_id = $product_stock->id;
            $stock_child->fill($value)->save();
        }

        $return_data = $this->successResponse($total_stocks, 'Product stocked!!');
        return response($return_data, 200);
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
        //
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

    /**
     * @param Request $request
     */
    public function productStockSummary(Request $request) {
        $data = ProductTotalStock::with(['product','color', 'size'])
            ->whereHas('product',function ($data) use ($request){
            if($request->q){
                $data->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('slug', 'like', '%' . $request->q . '%');
            }
        })->paginate($request->row);

        $return_data = $this->successResponse($data, 'Data Retrived!');
        return response($return_data, 200);
    }
}
