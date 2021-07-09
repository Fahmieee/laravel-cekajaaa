<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiStockOpnameStockAddController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "stock_opname";
        $this->permalink   = "stock_opname_stock_add";
        $this->method_type = "post";
    }


    public function hook_before(&$postdata) {
        //This method will be execute before run the main process
        $stock_opname = DB::table('stock_opname')->where('id_warehouse',g('id_warehouse'))->orderby('id','desc')->first();
        if ($stock_opname->status != 'PUBLISH') {
            $result['api_status']  = 0;
            $result['api_message'] = "Failed, There is pending stock opname in warehouse";
            $res                   = response()->json($result);
            $res->send();
            exit;
        }
        $postdata['status'] = 'DRAFT';

    }

    public function hook_query(&$query) {
        //This method is to customize the sql query

    }

    public function hook_after($postdata,&$result) {
        //This method will be execute after run the main process

    }

}