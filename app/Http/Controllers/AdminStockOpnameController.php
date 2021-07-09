<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminStockOpnameController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field         = "id";
			$this->limit               = "20";
			$this->orderby             = "id,desc";
			$this->global_privilege    = false;
			$this->button_table_action = true;
			$this->button_bulk_action  = false;
			$this->button_action_style = "button_icon";
			$this->button_add          = true;
			$this->button_edit         = true;
			$this->button_delete       = false;
			$this->button_detail       = false;
			$this->button_show         = true;
			$this->button_filter       = true;
			$this->button_import       = false;
			$this->button_export       = false;
			$this->table               = "stock_opname";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Name","name"=>"name"];
			$this->col[] = ["label"=>"Lokasi","name"=>"id_warehouse","join"=>"warehouse,name"];
			$this->col[] = ["label"=>"Status","name"=>"status"];
			$this->col[] = ["label"=>"Created By","name"=>"id_cms_users","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Created_at","name"=>"created_at"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required','width'=>'col-sm-9'];
			$this->form[] = ['label'=>'Warehouse','name'=>'id_warehouse','type'=>'select2','datatable'=>'warehouse,name','validation'=>'required','width'=>'col-sm-9'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();
	        $this->addaction[] = ['label'=>'Detail','url'=>url('admin/stock_opname/list-item/[id]'),'icon'=>'fa fa-th-list','color'=>'primary'];


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    	if ($column_index == 2) {
	    		if ($column_value == 'PUBLISH') {
	    			$column_value = '<span style="color:green;font-weight:bold;">'.$column_value.'</span>';
	    		}elseif($column_value == 'PENDING') {
	    			$column_value = '<span style="color:orange;font-weight:bold;">'.$column_value.'</span>';
	    		}else {
	    			$column_value = '<span style="color:red;font-weight:bold;">'.$column_value.'</span>';
	    		}
	    	}
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here
			$postdata['id_cms_users'] = CRUDBooster::myId();
			$postdata['status']       = 'DRAFT';

    		$stock_opname = DB::table('stock_opname')->where('id_warehouse',g('id_warehouse'))->orderby('id','desc')->first();
    		$warehouse = tv(g('id_warehouse'),'warehouse','name');
	    	if ($stock_opname->status == 'DRAFT') {
	    		$res = redirect()->back()->with(["message"=>"Failed, There is pending stock opname in warehouse ".$warehouse,'message_type'=>'warning'])->withInput();
		            \Session::driver()->save();
		        $res->send();
		        exit();
	    	}

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here
	        DB::table('stock_opname_item')->where('id_stock_opname',$id)->delete();

	    }



	    //By the way, you can still create your own method in here... :) 

	    public function getListItem($id) {
	        //Your code here

			$data['page_title']        = 'Stock Opname';
			$data['stock_opname_item'] = DB::table('stock_opname_item')->where('id_stock_opname',$id)->orderby('id','desc')->paginate(100);
			$data['id']                = $id;
	    	return view('backend.stock.so-list-item',$data);

	    }
	    public function postAddItem() {

	    	// $item = DB::table('item')->where('sku',g('sku'))->first();
	    	$checkSkuItem = checkSkuItem(g('sku'));
        
	        if (!$checkSkuItem) {
	    		$res = redirect()->back()->with(["message"=>"Barcode not registered",'message_type'=>'warning'])->withInput();
		            \Session::driver()->save();
		        $res->send();
		        exit();
	        }
	        $item = $checkSkuItem;

	    	$stock_opname_item = DB::table('stock_opname_item')->where('id_item',$item->id)->where('id_stock_opname',g('id_stock_opname'))->first();

	    	$checkSkuItem = checkSkuItem(g('sku'));
    		$qty = TotalQtyItem($item->id,g('qty'),$checkSkuItem->qty_type);

	    	if ($stock_opname_item) {
				$p['qty'] = $qty+$stock_opname_item->qty;
				$update   = DB::table('stock_opname_item')->where('id',$stock_opname_item->id)->update($p);
	    	}else{
				$p['id_stock_opname'] = g('id_stock_opname');
				$p['id_item']         = $item->id;
				$p['id_cms_users']    = CRUDBooster::myId();
				$p['created_at']      = date('Y-m-d H:i:s');
				$p['qty']             = $qty;
				DB::table('stock_opname_item')->insert($p);

	    	}

			CRUDBooster::redirect(g('url_callback'), 'Success saving data', 'success');

			
	    }
	  //   public function getDeleteItem($id) {
	  //   	DB::table('stock_opname_item')->where('id',$id)->delete();
			// CRUDBooster::redirect(g('url_callback'), 'Data Berhasil dihapus', 'success');
	  //   }
	    public function getUpdateStatus($id) {
	    	$check = tv($id,'stock_opname','status');
	    	if ($check == 'PUBLISH') {
	    		$res = redirect()->back()->with(["message"=>"Stock Opname Published",'message_type'=>'warning'])->withInput();
		            \Session::driver()->save();
		        $res->send();
		        exit();
	    	}
			$p['status']     = 'PUBLISH';
			$p['publish_by'] = CRUDBooster::myId();
	    	DB::table('stock_opname')->where('id',$id)->update($p);
	    	stockOpnameStockPublishCondition($id);
			CRUDBooster::redirect(g('url_callback'), 'Stock Opname Published', 'success');
	    }


	}