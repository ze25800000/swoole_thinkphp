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
		$code     = rand( 1000, 9999 );
		$uid      = 'ze25800000';
		$pwd      = 'yangze1234';
		$sms      = new Sms( $uid, $pwd );
		$template = "100006";
		$result   = $sms->send( $phone, $code, $template );
		if ( $result['stat'] == '102' ) {
			Predis::getInstance()->set( Predis::smsKey( $phone ), $code, config( 'redis.out_time' ) );

			return Util::show( config( 'code.success' ), '验证码发送成功', $code );
		} else {
			return Util::show( config( 'code.error' ), '验证码发送失败' );
		}

		return Util::show( config( 'code.success' ), 'success' );

	}
}