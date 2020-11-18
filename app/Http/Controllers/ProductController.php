<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductMultipleImage;
use App\Models\ProductTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;
use Image;

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
        })->with(['category', 'sub_category', 'child_category', 'vendor', 'unit', 'material', 'color.color', 'size.size'])
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

        ProductTag::where('product_id', $id)->delete();
        if (count($request->tags) > 0) {
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

        ProductAttribute::where('product_id', $id)->where('type', 2)->delete();
        if (count($request->size) > 0) {
            foreach (array_unique($request->size) as $key => $value) {
                $product_attr = new ProductAttribute;
                $product_attr->type = 2;
                $product_attr->product_id = $data->id;
                $product_attr->size_id = $value;
                $product_attr->save();
            }
        }

        ProductAttribute::where('product_id', $id)->where('type', 1)->delete();
        if (count($request->color) > 0) {
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

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function productMultipleImage($id){
        $return_data = array();
        $data = Product::where('slug', $id)->first();
        $return_data['product'] = $data;
        $data = ProductMultipleImage::where('product_id', $data->id)->select('id', 'image','product_id')->get();
        $return_data['image'] = $this->successResponse($data, count($data) == 0 ? 'Image Not Found!' : 'Image Found');

        return response($return_data, 200);
    }

    /**
     * @param Request $request
     */
    public function uploadImage(Request $request){
        $data = Product::where('slug', $request->product_id)->first();
        if ($request->type == 1) {
            //Thumbnail Image
            $upload_path="backend_assets/image/thumbnails/".$data->slug.".webp";
            $image_upload=Image::make($request->image)->resize(225, 247);
            $image_upload->save($upload_path);

            //MultipleImage
            //$multiple_image = ProductMultipleImage::where('image', $data->slug.".webp")->first();
            //$upload_path="backend_assets/image/multiple_image/".$data->slug.".webp";
            //$image_upload=Image::make($request->image)->resize(720, 792);
            //$image_upload->save($upload_path);
            //if (!$multiple_image) {
            //    $multiple_image = new ProductMultipleImage;
            //    $multiple_image->image = $data->slug.".webp";
            //    $multiple_image->product_id = $data->id;
            //    $multiple_image->save();
            //}
        } else {
            $upload_path="backend_assets/image/multiple_image/".$data->slug."-".time().".webp";
            $image_upload=Image::make($request->image)->resize(720, 792);
            $image_upload->save($upload_path);
            $multiple_image = new ProductMultipleImage;
            $multiple_image->image = $data->slug."-".time().".webp";
            $multiple_image->product_id = $data->id;
            $multiple_image->save();
        }
    }

    /**
     * @param $image_id
     * @param $product_id
     */
    public function productImageDelete($image_id, $product_id) {
        $data = ProductMultipleImage::findOrFail($image_id);
        if(\File::exists('backend_assets/image/multiple_image/'.$data->image)){
            \File::delete('backend_assets/image/multiple_image/'.$data->image);
        }
        $data->delete();
        $return_data = $this->successResponse($data, 'Image Deleted!');
        return response($return_data, 200);
    }
}
