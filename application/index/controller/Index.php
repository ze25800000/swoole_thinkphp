<?php

namespace app\index\controller;

class Index {
	public function index() {
		return 'hello world';
	}

	public function hello( $name = 'ThinkPHP5' ) {
		return 'hello,' . $name;
	}
}
