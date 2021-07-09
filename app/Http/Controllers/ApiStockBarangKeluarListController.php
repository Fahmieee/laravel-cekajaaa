<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiStockBarangKeluarListController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "item_out";
        $this->permalink   = "stock_barang_keluar_list";
        $this->method_type = "post";
    }


    public function hook_before(&$postdata) {
        //This method will be execute before run the main process

    }

    public function hook_query(&$query) {
        //This method is to customize the sql query
        if (g('search')) {
            $query = $query->where('item.name','LIKE','%'.g('search').'%');
        }

    }

    public function hook_after($postdata,&$result) {
        //This method will be execute after run the main process
        if($result['data']) {
            foreach ($result['data'] as $item) {
                $item_table = DB::table('item')->where('id', $item->id_item)->first();
                $warehouse = DB::table('warehouse')->where('id', $item->id_warehouse)->first();
                $item->qty = $item->qty . ' ' . $item->qty_type;
                $item->item_name = $item_table->name;
                $item->warehouse_name = $warehouse->name;
            }
        }

    }

}