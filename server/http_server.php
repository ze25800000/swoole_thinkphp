<?php
$http = new swoole_http_server( '0.0.0.0', '8081' );
$http->set( [
	'enable_static_handler' => true,
	'document_root'         => '/home/work/swoole_thinkphp/public/static',
	'worker_num'            => 5
] );

$http->on( 'WorkerStart', function ( swoole_server $server, $worker_id ) {

// 定义应用目录
	define( 'APP_PATH', __DIR__ . '/../application/' );
	// 加载基础文件
	require __DIR__ . '/../thinkphp/base.php';

} );

$http->on( 'request', function ( $request, $response ) {

	if ( isset( $request->server ) ) {
		foreach ( $request->server as $k => $v ) {
			$_SERVER[ $k ] = $v;
		}
	}

	if ( isset( $request->get ) ) {
		foreach ( $request->get as $k => $v ) {
			$_GET[ $k ] = $v;
		}
	}

	if ( isset( $request->post ) ) {
		foreach ( $request->post as $k => $v ) {
			$_POST[ $k ] = $v;
		}
	}

	// 执行应用并响应
	think\Container::get( 'app', [ APP_PATH ] )
	               ->run()
	               ->send();

	$response->cookie( "yangze", "asdfasdf", time() + 1000 );
	$response->end( "<h1>" . json_encode( $request->get ) . "</h1>" );
} );

$http->start();