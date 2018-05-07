<?php

namespace app\admin\controller;


use app\common\lib\Predis;
use app\common\lib\Util;

class Live {
	public function push() {
		$_POST['http_server']->task( [
			'method' => 'pushLive',
			'data'   => $_GET
		] );

		return Util::show( config( 'code.success' ), '信息推送成功' );
	}
}