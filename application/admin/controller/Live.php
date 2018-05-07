<?php

namespace app\admin\controller;


use app\common\lib\Predis;

class Live {
	public function push() {
		$clients = Predis::getInstance()->sMembers( config( 'redis.live_game_key' ) );
		foreach ( $clients as $fd ) {
			$_POST['http_server']->push( $fd, json_encode( $_GET ) );
		}
	}
}