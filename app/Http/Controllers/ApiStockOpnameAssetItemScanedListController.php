<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiStockOpnameAssetItemScanedListController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "stock_opname_asset_item";
        $this->permalink   = "stock_opname_asset_item_scaned_list";
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

        $item = DB::table('stock_opname_asset_item')
            ->select('id_item')
            ->where('id_stock_opname_asset',g('id_stock_opname_asset'))
            ->where('id_item',g('id_item'))
            ->groupby('id_item')
            ->first();

        $id_warehouse      = tv(g('id_stock_opname_asset'),'stock_opname_asset','id_warehouse');
        $detail_item['item_name']   = tv($item->id_item,'item','name');
        $detail_item['item_sku']    = tv($item->id_item,'item','sku');
        $detail_item['warehouse']   = tv($id_warehouse,'warehouse','name');
        $detail_item['qty']         = totalSoAssetPerItem(g('id_stock_opname_asset'),$item->id_item);
        $detail_item['last_insert'] = lastInsertSoAssetItem(g('id_stock_opname_asset'),$item->id_item);

        $result['detail_item'] = $detail_item;

    }

}