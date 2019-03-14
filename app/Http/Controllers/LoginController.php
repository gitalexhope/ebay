<?php

namespace App\Http\Controllers;
use Helper;
use DB;
use Validator;
use Hash;
use Session;
//use App\User;
//use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Login as Login;
class LoginController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
     public function loginUserTest()
    {
    		$length = 5;
    		$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    		$randomString1 = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    		$randomString = $randomString.$randomString1;
    		$hashToStoreInDb = Hash::make('123456');
    		$emailId ='admin@gmail.com';
    		$detail =array(
    			'userRef' =>$randomString,
    			'emailId' =>DB::raw("AES_ENCRYPT('".$emailId."','/*awshp$*/')"),
    			'password' =>$hashToStoreInDb,
    			'userType' =>1,
    			'status' =>1
    		);
    		//$cars = Login::getAllUser();
    	 //$cars = Login::all();
    	  Login::insertUser($detail);
    		echo Helper::loginHeader();
    		return view('login.login');
    }
    public function loginUser(Request $request)
    {
		$data = array();
		if($_POST){
		 $v = Validator::make($request->all(), [
            'emailId'   => 'required',
            'password' => 'required',
        ]);
        if ($v->fails()) {
           return redirect()->back()->withErrors($v);
        }
		//print_r($request->all());die;
		$returnVal = Login::userLogin($request->input('emailId'));
    if(count($returnVal) > 0){
		if (Hash::check($request->input('password'), $returnVal[0]->password)) {
				Session::put('amaEbaySessId',$returnVal[0]->userRef);
        $arr = array();
        Session::push('imageSess',$arr);
				return redirect('dashboard');
			}
			else{
				$passError = "Your emailId/Password wrong. Please try again.";
				return redirect()->back()->withErrors($passError);
			}

	}
  else{
    $passError = "Your emailId/Password wrong. Please try again.";
    return redirect()->back()->withErrors($passError);
  }
}

		echo Helper::loginHeader();
		return view('login.login',$data);
    }

    public function logOutUser()
    {
          Session::flush();
          return redirect('/');
    }

}
?>
