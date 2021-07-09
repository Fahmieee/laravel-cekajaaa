<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiAssetBarangMasukAddController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "item_in_asset";
        $this->permalink   = "asset_barang_masuk_add";
        $this->method_type = "post";
    }


    public function hook_before(&$postdata) {
        //This method will be execute before run the main process
        $check_item_in = DB::table('item_in_asset')->where('code',g('code'))->where('id_item_out_asset',NULL)->first();
        $gudang        = tv($check_item_in->id_warehouse,'warehouse','name');
        if ($check_item_in) {
            $result['api_status']  = 0;
            $result['api_message'] = "item is already in warehouse ".$gudang;
            $res                   = response()->json($result);
            $res->send();
            exit;
        }

    }

    public function hook_query(&$query) {
        //This method is to customize the sql query

    }

    public function hook_after($postdata,&$result) {
        //This method will be execute after run the main process
        $item_in_asset = DB::table('item_in_asset')->where('id',$result['id'])->first();
        addStock($item_in_asset->id_item,1,$item_in_asset->id_warehouse);

    }

}