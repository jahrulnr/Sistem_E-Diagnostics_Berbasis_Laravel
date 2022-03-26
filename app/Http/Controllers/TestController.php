<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller {

	public function __construct(){
	    $this->middleware(function ($request, $next) {
	        return $next($request);
    	});
	}

	function test(Request $req){
		$subject = "Test email";
		$msg = [
			'title' => "Just Test",
			'body'	=> "Yang ini dari host biasa"
		];

		// send email
		\Mail::to('jahrulnr@gmail.com')->send(new \App\Mail\eMail($subject, $msg));

		return $msg;
	}
}

?>