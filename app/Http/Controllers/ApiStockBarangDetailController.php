<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiStockBarangDetailController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "item";
        $this->permalink   = "stock_barang_detail";
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
        $result['stock']      = stockItem($result['id']);
        $result['created_at'] = lastUpdateItem($result['id']);
        $result['warehouse']  = DB::table('stock')->where('id_item',$result['id'])->get();
        foreach ($result['warehouse'] as $item) {
            $item->warehouse_name = tv($item->id_warehouse,'warehouse','name');
        }

    }

}