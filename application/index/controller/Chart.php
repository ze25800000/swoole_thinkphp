<?php

namespace app\index\controller;


use app\common\lib\Util;

class Chart {
	public function index() {

		return Util::show( config( 'code.success' ), '发送成功' );
	}
}