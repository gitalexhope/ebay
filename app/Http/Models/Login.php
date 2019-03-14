<?php

namespace App\Http\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
     protected $table = 'users';
     public static function getAllUser(){
			$result =  DB::table('users')->get();
			return $result;
	}
	public static function insertUser($userDetail){
			$result =  DB::table('users')->insert($userDetail);
			return $result;
	}
	public static function userLogin($emailId){
		$result =  DB::table('users')->select('*',DB::raw('AES_DECRYPT(emailId,"/*awshp$*/") as email') )->where(DB::raw('AES_DECRYPT(emailId,"/*awshp$*/")'),$emailId)->get();
		return $result;
	}
}
