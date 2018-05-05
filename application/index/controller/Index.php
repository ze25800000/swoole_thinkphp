<?php

namespace app\index\controller;

class Index {
	public function index() {
		var_dump( $_GET );
		echo 'hello world';
	}

	public function yangze() {
		echo time();
	}

	public function hello( $name = 'ThinkPHP5' ) {
		return 'hello,' . $name;
	}
}
