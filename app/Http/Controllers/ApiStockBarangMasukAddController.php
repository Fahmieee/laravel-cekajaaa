<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiStockBarangMasukAddController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "item";
        $this->permalink   = "stock_barang_masuk_add";
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
        if ($result['id']) {
            $item_in = DB::table('item_in')->where('id', $result['id'])->first();
            $qty = TotalQtyItem($postdata['id_item'], $postdata['qty'], $postdata['qty_type']);
            addStock($postdata['id_item'], $qty, $postdata['id_warehouse']);
        }

    }

}