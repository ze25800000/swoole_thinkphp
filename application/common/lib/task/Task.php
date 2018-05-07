<?php

namespace app\common\lib\task;

use app\common\lib\Predis;
use app\common\lib\Sms;

class Task {
	public function sendSms( $data, $server ) {
		$uid      = 'ze25800000';
		$pwd      = 'yangze1234';
		$smsObj   = new Sms( $uid, $pwd );
		$template = "100006";
		try {
			$result = $smsObj->send( $data['phone'], $data['code'], $template );
		} catch ( \Exception $e ) {
			return false;
		}
		if ( $result['stat'] == 102 ) {
			Predis::getInstance()->set( Predis::smsKey( $data['phone'] ), $data['code'], config( 'redis.out_time' ) );
		}
		print_r( $result );
		echo $data['code'];

		return true;
	}

	public function pushLive( $data, $server ) {
		$clients = Predis::getInstance()->sMembers( config( 'redis.live_game_key' ) );
		foreach ( $clients as $fd ) {
			$server->push( $fd, json_encode( $data ) );
		}

		return true;
	}
}