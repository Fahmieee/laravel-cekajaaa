<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiStockBarangMasukScanController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "item";
        $this->permalink   = "stock_barang_masuk_scan";
        $this->method_type = "post";
    }


    public function hook_before(&$postdata) {
        //This method will be execute before run the main process

        $checkSkuItem = checkSkuItem($postdata['sku']);

        if ($checkSkuItem) {

            $result['api_status']  = 1;
            $result['api_message'] = 'success';
            $result['data']        = $checkSkuItem;
        }else{
            $result['api_status']  = 0;
            $result['api_message'] = 'Barcode not registered';
        }

        $res                   = response()->json($result);
        $res->send();
        exit;
        // $b = TotalQtyItem(3,5,'Kardus');
        // dd($b);

    }

    public function hook_query(&$query) {
        //This method is to customize the sql query

    }

    public function hook_after($postdata,&$result) {
        //This method will be execute after run the main process

    }

}