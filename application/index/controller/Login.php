<?php

namespace app\index\controller;

use app\common\lib\Util;
use app\common\lib\Predis;


class Login {
	public function index() {
		$phone = intval( $_GET['phone_num'] );
		$code  = intval( $_GET['code'] );
		if ( empty( $phone ) || empty( $code ) ) {
			return Util::show( config( 'code.success' ), 'success' );
		}
		$redisCode = Predis::getInstance()->get( Predis::smsKey( $phone ) );
		if ( $redisCode == $code ) {
			$data = [
				'user'    => $phone,
				'srcKey'  => md5( Predis::userKey( $phone ) ),
				'time'    => time(),
				'isLogin' => true
			];
			Predis::getInstance()->set( Predis::userKey( $phone ), $data );

			return Util::show( config( 'code.success' ), 'ok', $data );
		} else {
			return Util::show( config( 'code.error' ), 'error' );
		}
	}
}