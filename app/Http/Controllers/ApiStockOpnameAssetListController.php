<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiStockOpnameAssetListController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "stock_opname_asset";
        $this->permalink   = "stock_opname_asset_list";
        $this->method_type = "post";
    }


    public function hook_before(&$postdata) {
        //This method will be execute before run the main process

    }

    public function hook_query(&$query) {
        //This method is to customize the sql query
        if (g('search')) {
            $query = $query->where('stock_opname_asset.name','LIKE','%'.g('search').'%');
        }
        if (g('status')) {
            $query = $query->where('stock_opname_asset.status',g('status'));
        }

    }

    public function hook_after($postdata,&$result) {
        //This method will be execute after run the main process
        foreach ($result['data'] as $item) {
            $item->total_stock_opname = totalSoAsset($item->id);
        }

    }

}