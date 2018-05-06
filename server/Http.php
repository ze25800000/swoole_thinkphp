<?php

class Http {
	const HOST = '0.0.0.0';
	CONST PORT = 8081;
	public $http = null;

	public function __construct() {
		$this->http = new swoole_http_server( self::HOST, self::PORT );
		$this->http->set( [
			'enable_static_handler' => true,
			'document_root'         => '/home/work/swoole_thinkphp/public/static',
			'worker_num'            => 4,
			'task_worker_num'       => 4
		] );
		$this->http->on( 'workerstart', [ $this, 'onWorkerStart' ] );
		$this->http->on( 'request', [ $this, 'onRequest' ] );
		$this->http->on( 'task', [ $this, 'onTask' ] );
		$this->http->on( 'finish', [ $this, 'onFinish' ] );
		$this->http->on( 'close', [ $this, 'onClose' ] );
		$this->http->start();
	}


	public function onWorkerStart( $server, $worker_id ) {
		// 定义应用目录
		define( 'APP_PATH', __DIR__ . '/../application/' );
		// 加载基础文件
		require __DIR__ . '/../thinkphp/base.php';
	}

	public function onRequest( $request, $response ) {
		$_SERVER = [];
		if ( isset( $request->server ) ) {
			foreach ( $request->server as $k => $v ) {
				$_SERVER[ $k ] = $v;
			}
		}
		if ( isset( $request->header ) ) {
			foreach ( $request->header as $k => $v ) {
				$_SERVER[ $k ] = $v;
			}
		}

		$_GET = [];
		if ( isset( $request->get ) ) {
			foreach ( $request->get as $k => $v ) {
				$_GET[ $k ] = $v;
			}
		}
		$_POST = [];
		if ( isset( $request->post ) ) {
			foreach ( $request->post as $k => $v ) {
				$_POST[ $k ] = $v;
			}
		}
		ob_start();
		try {
			think\Container::get( 'app', [ APP_PATH ] )
			               ->run()
			               ->send();
		} catch ( \Exception $e ) {
			// todo
		}
		$res = ob_get_contents();
		ob_end_clean();
		$response->end( $res );
	}



	public function onTask( $http, $taskId, $workerId, $data ) {
		print_r( $data );
		for ( $i = 0; $i < 10; $i ++ ) {
			sleep( $i );
			$http->push( $data['fd'], $i . '--' . date( "H:i:s" ) );
		}

		return 'on task finish';
	}

	public function onFinish( $http, $taskId, $data ) {
		echo "taskId:{$taskId}\n";
		echo "finish_data_success:{$data}\n";
	}

	public function onClose( $http, $fd ) {
		echo "客户端 {$fd} 关闭\n";
	}
}

new Http();