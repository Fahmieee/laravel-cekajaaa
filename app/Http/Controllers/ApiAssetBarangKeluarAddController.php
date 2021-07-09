<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiAssetBarangKeluarAddController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "item_out_asset";
        $this->permalink   = "asset_barang_keluar_add";
        $this->method_type = "post";
    }


    public function hook_before(&$postdata) {
        //This method will be execute before run the main process
        $check_item_in = DB::table('item_in_asset')->where('code',g('code'))->where('id_item_out_asset',NULL)->first();
        if (!$check_item_in) {
            $result['api_status']  = 0;
            $result['api_message'] = "Item not registered in warehouse";
            $res                   = response()->json($result);
            $res->send();
            exit;
        }
        $postdata['id_item_in_asset'] = $check_item_in->id;

    }

    public function hook_query(&$query) {
        //This method is to customize the sql query

    }

    public function hook_after($postdata,&$result) {
        //This method will be execute after run the main process
        $id_item_in_asset       = tv($result['id'],'item_out_asset','id_item_in_asset');
        $p['id_item_out_asset'] = $result['id'];
        DB::table('item_in_asset')->where('id',$id_item_in_asset)->update($p);

        $item_in_asset = DB::table('item_in_asset')->where('id',$id_item_in_asset)->first();
        addStock($item_in_asset->id_item,-1,$item_in_asset->id_warehouse);

    }

}