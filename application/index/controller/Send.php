<?php

namespace app\index\controller;


use app\common\lib\Util;
use think\Controller;

class Send extends Controller {
	public function index() {
		$phone = $_GET['phone_num'];
		if ( empty( $phone ) ) {
			return Util::show( config( 'code.error' ), 'error' );
		}


	}
}