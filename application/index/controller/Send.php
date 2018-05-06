<?php

namespace app\index\controller;


use app\common\lib\Redis;
use app\common\lib\Sms;
use app\common\lib\Util;
use think\Controller;

class Send extends Controller {
	public function index() {
		$phone = $_GET['phone_num'];
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
//
//			$redis = new \Swoole\Coroutine\Redis();
//			$redis->connect( config( 'redis.host' ), config( 'redis.port' ) );
//			$redis->set( Redis::smsKey( $phone ), $code, config( 'redis.timeout' ) );
			$redisClient = new \swoole_redis;
			$redisClient->connect( config( 'redis.host' ), config( 'redis.port' ), function ( \swoole_redis $redisClient, $result ) {
				echo "connected" . PHP_EOL;
			} );
			echo Redis::smsKey( $phone );
//			$redisClient->set( Redis::smsKey( $phone ), $code, function ( \swoole_redis $client, $result ) use ( $code ) {
//				var_dump( $result );
//				echo "set success" . PHP_EOL;
//
//				return Util::show( config( 'code.success' ), '验证码发送成功', $code );
//			} );


		} else {
			return Util::show( config( 'code.error' ), '验证码发送失败' );
		}

		return Util::show( config( 'code.success' ), 'success' );

	}
}