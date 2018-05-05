<?php

namespace app\common\lib;


class Util {
	public static function show( $status, $message = "", $data = [] ) {
		$result = [
			'status'  => $status,
			'message' => $message,
			'data'    => $data
		];
		if ( empty( $data ) ) {
			unset( $result['data'] );
		}

		echo json_encode( $result );
	}
}