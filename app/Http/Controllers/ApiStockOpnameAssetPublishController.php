<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiStockOpnameAssetPublishController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "stock_opname_asset";
        $this->permalink   = "stock_opname_asset_publish";
        $this->method_type = "post";
    }


    public function hook_before(&$postdata) {
        //This method will be execute before run the main process

        $status = tv(g('id'),'stock_opname_asset','status');
        if ($status == 'PUBLISH') {
            $result['api_status']  = 0;
            $result['api_message'] = "Stock Opname Published";
            $res                   = response()->json($result);
            $res->send();
            exit;
        }

        unset($postdata['id_cms_users']);
        $postdata['status']       = 'PENDING';
        // $postdata['publish_by']   = g('id_cms_users');
        // $postdata['publish_date'] = date('Y-m-d H:i:s');

    }

    public function hook_query(&$query) {
        //This method is to customize the sql query

    }

    public function hook_after($postdata,&$result) {
        //This method will be execute after run the main process
        // if ($result['api_status'] == 1) {
        // 	stockOpnameAssetPublishCondition(g('id'));
        // }

    }

}