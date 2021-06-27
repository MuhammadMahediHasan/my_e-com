<?php
namespace App\Traits;

use App\Models\Product;

trait HelperTrait{
    /**
     * @param $data
     * @param $msg
     * @return array
     */
    public function successResponse($data, $msg) : array {
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
    public function errorResponse($data, $msg) : array {
        return [
            'status' => '201',
            'msg' => $msg,
            'data' => $data,
        ];
    }

    /**
     * @return int
     */
    public function productCode() : int {
        $make_order_num = Product::latest()->first();
        $year = date('y');
        $month = date('m');

        strlen( date('d') ) == 1
            ? $date = '0'.date('d')
            : $date = date('d');

        $code_no = (int) (isset($make_order_num) ? $make_order_num->id : 0) + 1;

        switch ( strlen($code_no) ) {
            case 1 :
                $code_no = '000'.$code_no;
                break;
            case 2 :
                $code_no = '00'.$code_no;
                break;
            case 3 :
                $code_no = '0'.$code_no;
                break;
            default :
                $code_no = 0001;
        }

        return $year . $month . $date . $code_no;
    }
}
