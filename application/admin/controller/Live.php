<?php

namespace app\admin\controller;


class Live {
	public function push() {
		print_r( $_GET );
		$_POST['http_server']->push( 2, 'hello world' );
	}
}