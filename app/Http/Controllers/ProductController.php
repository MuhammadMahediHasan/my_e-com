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
        })->with(['category', 'sub_category', 'child_category', 'vendor', 'unit', 'color.color', 'size.size'])
            ->orderBy('created_at', 'DESC')
            ->paginate($request->row);

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
        $tags = Tag::all();
        $data->code = $this->productCode();
        $data->fill($request->all())->save();

        if (count($request->tags) > 0) {
            foreach ($request->tags as $key => $value) {
                $tag = collect($tags)->where('name', $value)->first();
                $product_tag = new ProductTag;
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
                $product_attr->type = 2;
                $product_attr->product_id = $data->id;
                $product_attr->size_id = $value;
                $product_attr->save();
            }
        }

        if (count($request->color) > 0) {
            foreach ($request->color as $key => $value) {
                $product_attr = new ProductAttribute;
                $product_attr->type = 1;
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
        $data = Product::with(['color', 'size'])->findOrFail($id);
        $color = ProductAttribute::where('product_id', $id)->where('type', 1)->get()->pluck('color_id');
        $size = ProductAttribute::where('product_id', $id)->where('type', 2)->get()->pluck('size_id');
        $tags = ProductTag::where('product_id', $id)->with('tag')->get()->pluck('tag.name');
        $return_data = $this->successResponse(['data' => $data, 'color'=>$color, 'size'=>$size, 'tags'=>$tags], 'Data Retrived!');
        return response($return_data, 200);
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
        $tags = Tag::all();
        $data->fill($request->all())->save();

        if (count($request->tags) > 0) {
            ProductTag::where('product_id', $id)->delete();
            foreach ($request->tags as $key => $value) {
                $product_tag = new ProductTag;
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
            ProductAttribute::where('product_id', $id)->where('type', 2)->delete();
            foreach (array_unique($request->size) as $key => $value) {
                $product_attr = new ProductAttribute;
                $product_attr->type = 2;
                $product_attr->product_id = $data->id;
                $product_attr->size_id = $value;
                $product_attr->save();
            }
        }

        if (count($request->color) > 0) {
            ProductAttribute::where('product_id', $id)->where('type', 1)->delete();
            foreach (array_unique($request->color) as $key => $value) {
                $product_attr = new ProductAttribute;
                $product_attr->type = 1;
                $product_attr->product_id = $data->id;
                $product_attr->color_id = $value;
                $product_attr->save();
            }
        }

        $return_data = $this->successResponse($data, 'Product Edited Successfully');
        return response()->json($return_data);
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
