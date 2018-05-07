<?php

class Monitor {
	const PORT = 8081;

	public function port() {
		$shell = "netstat -anp 2>/dev/null |grep " . self::PORT . " |wc -l";

		$result = shell_exec( $shell );
		if ( $result != 1 ) {
			//发送短信邮件
			echo date( "Ymd H:i:s" ) . " error " . PHP_EOL;
		} else {
			echo date( "Ymd H:i:s" ) . " success " . PHP_EOL;
		}
	}
}

swoole_timer_tick( 2000, function ( $timer_id ) {
	( new Monitor() )->port();
} );
