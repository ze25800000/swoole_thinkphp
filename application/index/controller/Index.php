<?php

namespace app\index\controller;

use app\common\lib\Sms;

class Index {
	public function index() {
		var_dump( $_GET );
		echo 'hello world';
	}

	public function yangze() {
		$uid          = 'ze25800000';
		$pwd          = 'yangze1234';
		$sms          = new Sms( $uid, $pwd );
		$contentParam = [ 'code' => rand( 1000, 9999 ) ];
		$template     = "100006";
		$result       = $sms->send( 15148625758, $contentParam, $template );
		echo $result;
	}

	public function hello( $name = 'ThinkPHP5' ) {
		return 'hello,' . $name;
	}
}
