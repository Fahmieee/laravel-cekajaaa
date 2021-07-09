<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiStockOpnameAssetItemListController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "stock_opname_asset_item";
        $this->permalink   = "stock_opname_asset_item_list";
        $this->method_type = "post";
    }


    public function hook_before(&$postdata) {
        //This method will be execute before run the main process

        $query = DB::table('stock_opname_asset_item')
            ->select('id_item')
            ->where('id_stock_opname_asset',g('id_stock_opname_asset'))
            ->groupby('id_item')
            ->get();

        foreach ($query as &$item) {
            $id_warehouse      = tv(g('id_stock_opname_asset'),'stock_opname_asset','id_warehouse');
            $item->item_name   = tv($item->id_item,'item','name');
            $item->item_sku    = tv($item->id_item,'item','sku');
            $item->item_sku    = tv($item->id_item,'item','sku');
            $item->warehouse   = tv($id_warehouse,'warehouse','name');
            $item->qty         = totalSoAssetPerItem(g('id_stock_opname_asset'),$item->id_item);
            $item->last_insert = lastInsertSoAssetItem(g('id_stock_opname_asset'),$item->id_item);
        }


        $result['api_status']  = 1;
        $result['api_message'] = "Success";
        $result['data']        = $query;
        $res                   = response()->json($result);
        $res->send();
        exit;

    }

    public function hook_query(&$query) {
        //This method is to customize the sql query
        // $query = $query->select('id_item')->groupby('id_item');

    }

    public function hook_after($postdata,&$result) {
        //This method will be execute after run the main process

    }

}