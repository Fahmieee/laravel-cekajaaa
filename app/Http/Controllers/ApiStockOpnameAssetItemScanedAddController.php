<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiStockOpnameAssetItemScanedAddController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "stock_opname_asset_item";
        $this->permalink   = "stock_opname_asset_item_scaned_add";
        $this->method_type = "post";
    }


    public function hook_before(&$postdata) {
        //This method will be execute before run the main process

        $code_exist = DB::table('item_asset_code')->where('code',g('code'))->first();
        if (!$code_exist) {
            $result['api_status']  = 0;
            $result['api_message'] = "Barcode not registered";
            $res                   = response()->json($result);
            $res->send();
            exit;
        }

        $code_ready = DB::table('stock_opname_asset_item')->where('code',g('code'))->where('id_stock_opname_asset',g('id_stock_opname_asset'))->first();
        if ($code_ready) {
            $result['api_status']  = 0;
            $result['api_message'] = "Item is Already in";
            $res                   = response()->json($result);
            $res->send();
            exit;
        }

        $postdata['id_item'] = tv_where(g('code'),'item_asset_code','code','id_item');

    }

    public function hook_query(&$query) {
        //This method is to customize the sql query

    }

    public function hook_after($postdata,&$result) {
        //This method will be execute after run the main process

    }

}