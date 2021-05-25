<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\FrontendApiRepository;

class FrontendApiController extends Controller
{
    protected $data;

    /**
     * FrontendApiController constructor.
     * @param FrontendApiRepository $data
     */
    public function __construct(FrontendApiRepository $data)
    {
        $this->data = $data;
    }

    public function menus() {
        $menu = $this->data->menus();

        return $menu;
    }
}
