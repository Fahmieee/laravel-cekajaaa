<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class ApiUserForgotPasswordController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {
        $this->table       = "cms_users";
        $this->permalink   = "user_forgot_password";
        $this->method_type = "post";
    }


    public function hook_before(&$postdata) {
        //This method will be execute before run the main process
        $email       = $postdata['email'];
        $check_email = DB::table('cms_users')->where('email',$email)->first();

        if (!$check_email) {
            $result['api_status']  = 0;
            $result['api_message'] = 'Your email not registered';
            $res                   = response()->json($result);
            $res->send();
            exit;

        }
        $password        = uniqid();
        $p['password']   = \Hash::make($password);
        $p['updated_at'] = date('Y-m-d H:i:s');

        DB::table('cms_users')->where('id',$check_email->id)->update($p);

        $appname = CRUDBooster::getSetting('appname');
        $email = tv($check_email->id,'cms_users','email');
        $html  = "<h2>".$appname.", Forgot Password</h2>
		                <p>Please login to apps ".$appname." with account bellow :</p>
		                <p>Email : ".$email."</p>
		                <p>Password : ".$password."</p>";
        $config['to'] = $email;
        $config['data'] = ['password'=>$password];
        $config['template'] = "forgot_password_backend";
        CRUDBooster::sendEmail($config);

        $result['api_status']  = 1;
        $result['api_message'] = 'Forgot password success, Please check email';
        $res                   = response()->json($result);
        $res->send();
        exit;

    }

    public function hook_query(&$query) {
        //This method is to customize the sql query

    }

    public function hook_after($postdata,&$result) {
        //This method will be execute after run the main process

    }

}