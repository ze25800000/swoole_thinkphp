<?php

namespace app\index\controller;


use app\common\lib\Predis;
use app\common\lib\Sms;
use app\common\lib\Util;
use think\Controller;

class Send extends Controller {
	public function index() {
		$phone = intval( $_GET['phone_num'] );
		if ( empty( $phone ) || ! is_numeric( $phone ) || strlen( $phone ) != 11 ) {
			return Util::show( config( 'code.error' ), 'error' );
		}
		$code = rand( 1000, 9999 );

		$_POST['http_server']->task( [
			'method' => 'sendSms',
			'data'   => [
				'phone' => $phone,
				'code'  => $code
			]
		] );

//		return Util::show( config( 'code.success' ), 'success' );

	}
}