<?php

namespace app\common\lib;


class Predis {
	public $redis = '';
	private static $_instance = null;
	public static $smsPre = "sms_";
	public static $userPre = "user_";


	public static function getInstance() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	private function __construct() {
		$this->redis = new \Redis();
		$result      = $this->redis->connect( config( 'redis.host' ), config( 'redis.port' ), config( 'redis.time_out' ) );
		if ( $result == false ) {
			throw new \Exception( 'redis connect error' );
		}
	}

	public static function smsKey( $phone ) {
		return self::$smsPre . $phone;
	}

	public static function userKey( $phone ) {
		return self::$userPre . $phone;
	}


	public function set( $key, $value, $time = 0 ) {
		if ( ! $key ) {
			return '';
		}
		if ( is_array( $value ) ) {
			$value = json_encode( $value );
		}
		if ( ! $time ) {
			return $this->redis->set( $key, $value );
		}

		return $this->redis->setex( $key, $time, $value );
	}

	public function get( $key ) {
		if ( ! $key ) {
			return '';
		}

		return $this->redis->get( $key );
	}

	/*public function sAdd( $key, $value ) {
		return $this->redis->sAdd( $key, $value );
	}*/

	/*public function sRem( $key, $value ) {
		return $this->redis->sRem( $key, $value );
	}*/

	public function sMembers( $key ) {
		return $this->redis->sMembers( $key );
	}

	public function del( $key ) {
		return $this->redis->del( $key );
	}

	public function __call( $name, $arguments ) {
		if ( count( $arguments ) != 2 ) {
			return '';
		}
		$this->redis->$name( $arguments[0], $arguments[1] );
	}
}