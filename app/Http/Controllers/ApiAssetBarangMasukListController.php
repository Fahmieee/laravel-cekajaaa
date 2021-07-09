<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiAssetBarangMasukListController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "item_in_asset";
        $this->permalink   = "asset_barang_masuk_list";
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
        foreach ($result['data'] as $item) {
            $item->item_sku       = tv($item->id_item,'item','sku');
            $item->item_name      = tv($item->id_item,'item','name');
            $item->cms_users_name = tv($item->id_cms_users,'cms_users','name');
            $item->warehouse_name = tv($item->id_warehouse,'warehouse','name');
        }

    }

}