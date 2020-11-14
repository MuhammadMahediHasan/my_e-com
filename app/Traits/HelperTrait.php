<?php
namespace App\Traits;

use App\Models\Product;

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
            'status' => '201',
            'msg' => $msg,
            'data' => $data,
        ];
    }

    /**
     * @return string
     */
    public function productCode() {
        $make_order_num = Product::latest()->first();
        $year = date('y');
        $month = date('m');

        if (strlen(date('d')) == 1)
            $date = '0'.date('d');
        else
            $date = date('d');

        if (!empty($make_order_num)) {
            $code_no = (int) $make_order_num->id + 1;

            if (strlen($code_no) == 1)
                $code_no = '00'.$code_no;

            if (strlen($code_no) == 2)
                $code_no = '00'.$code_no;

            if (strlen($code_no) == 3)
                $code_no = '0'.$code_no;
        }
        else
            $code_no = 0001;

        $make_product_num_code = $year . $month . $date . $code_no;

        return $make_product_num_code;
    }
}
