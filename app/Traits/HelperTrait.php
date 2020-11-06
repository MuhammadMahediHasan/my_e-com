<?php
namespace App\Traits;

trait HelperTrait{
    /**
     * @param $data
     * @param $msg
     * @return array
     */
    public function successResponse($data, $msg) {
        return [
            'status' => 200,
            'msg' => $msg,
            'data' => $data
        ];
    }

    /**
     * @param $data
     * @param $msg
     * @return array
     */
    public function errorResponse($data, $msg) {
        return [
            'status' => 'success',
            'msg' => $msg,
            'data' => [$data, 200],
        ];
    }
}
