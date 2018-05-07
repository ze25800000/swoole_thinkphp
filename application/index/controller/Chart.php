<?php

namespace app\index\controller;


use app\common\lib\Util;

class Chart {
	public function index() {
		foreach ( $_POST['http_server']->ports[1]->connections as $fd ) {
			$_POST['http_server']->push( $fd, 'hello' . $fd );
		}

		return Util::show( config( 'code.success' ), '发送成功' );
	}
}