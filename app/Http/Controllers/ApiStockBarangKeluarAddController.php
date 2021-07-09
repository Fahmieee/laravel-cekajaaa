<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiStockBarangKeluarAddController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "item_out";
        $this->permalink   = "stock_barang_keluar_add";
        $this->method_type = "post";
    }


    public function hook_before(&$postdata) {
        //This method will be execute before run the main process

    }

    public function hook_query(&$query) {
        //This method is to customize the sql query

    }

    public function hook_after($postdata,&$result) {
        //This method will be execute after run the main process
        if ($result['api_status'] == 1) {
            $item_out = DB::table('item_out')->where('id',$result['id'])->first();
            $qty      = TotalQtyItem($postdata['id_item'],$postdata['qty'],$postdata['qty_type']);
            addStock($item_out->id_item,-$qty,$item_out->id_warehouse);
        }

    }

}