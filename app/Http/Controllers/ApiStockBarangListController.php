<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiStockBarangListController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "item";        
				$this->permalink   = "stock_barang_list";    
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
                foreach ($result['data'] as $item) {
                    $item->stock = stockItem($item->id);
                    $item->id_cms_users = tv($item->id,'item','id_cms_users');
                    $item->created_at = lastUpdateItem($item->id);
                }

		    }

		}