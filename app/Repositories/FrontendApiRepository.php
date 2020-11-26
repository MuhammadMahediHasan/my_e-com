<?php
namespace App\Repositories;

use App\Models\Category;
use App\Http\Resources\CategoryResource;

class FrontendApiRepository implements FrontendApiRepositoryInterface
{
    public function menus() {
        $data = Category::whereType(1)->whereStatus(1)->with(['sub_categories.child_categories'])->get();

        return CategoryResource::collection($data);
    }
}
