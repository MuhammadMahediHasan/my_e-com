<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Product::where(function ($data) use ($request) {
            if ($request->q) {
                $data->where('name', 'like', '%' . $request->q . '%');
            }
        })->with(['category',
            'sub_category',
            'child_category',
            'vendor',
            'attribute.attribute_value.attribute'])
            ->orderBy('created_at', 'DESC')
            ->paginate($request->row);

        $data = $data->setCollection(
            $data->getCollection()->map(function($data) {
                return [
                    "category_name" => $data->category->name,
                    "sub_category_name" => $data->sub_category->name,
                    "child_category_name" => $data->child_category->name,
                    "vendor_name" => $data->vendor->name,
                ];
            })
        );

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
        $data = Attribute::with('attribute_values')->get();
        $return_data = $this->successResponse($data, 'Data Retrived!');
        return response($return_data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Product;
        $product_tag = new ProductTag;
        $tags = Tag::all();
        $data->code = $this->productCode();
        $data->fill($request->all())->save();

        if (count($request->tags) > 0) {
            foreach ($request->tags as $key => $value) {
                $tag = collect($tags)->where('name', $value)->first();
                if ($tag){
                    $product_tag->product_id = $data->id;
                    $product_tag->tag_id = $tag->id;
                    $product_tag->save();
                } else {
                    $tag = new Tag;
                    $tag->name = strtolower($value);
                    $tag->save();
                    $product_tag->product_id = $data->id;
                    $product_tag->tag_id = $tag->id;
                    $product_tag->save();
                }
            }
        }

        if (count($request->size) > 0) {
            foreach ($request->size as $key => $value) {
                $product_attr = new ProductAttribute;
                $product_attr->product_id = $data->id;
                $product_attr->size_id = $value;
                $product_attr->save();
            }
        }

        if (count($request->color) > 0) {
            foreach ($request->color as $key => $value) {
                $product_attr = new ProductAttribute;
                $product_attr->product_id = $data->id;
                $product_attr->color_id = $value;
                $product_attr->save();
            }
        }

        $return_data = $this->successResponse($data, 'Product Added Successfully');
        return response()->json($return_data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $child_category = Category::whereChildCategoryId($id)->whereType(3)->get();
        $return_data = $this->successResponse($child_category, 'Data Retrived!');
        return response($return_data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        $data->fill($request->all())->save();
        $return_data = $this->successResponse($data, 'Data Edited!');
        return response($return_data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::findOrFail($id)->delete();
        $return_data = $this->successResponse($data, 'Data Deleted!');
        return response($return_data, 200);
    }
}
