<?php

class Websocket {
	const HOST = '0.0.0.0';
	CONST PORT = 8081;
	public $websocket = null;

	public function __construct() {
		$this->websocket = new swoole_websocket_server( self::HOST, self::PORT );
		$this->websocket->set( [
			'enable_static_handler' => true,
			'document_root'         => '/home/work/swoole_thinkphp/public/static',
			'worker_num'            => 4,
			'task_worker_num'       => 4
		] );
		$this->websocket->on( 'workerstart', [ $this, 'onWorkerStart' ] );
		$this->websocket->on( 'open', [ $this, 'onOpen' ] );
		$this->websocket->on( 'message', [ $this, 'onMessage' ] );
		$this->websocket->on( 'request', [ $this, 'onRequest' ] );
		$this->websocket->on( 'task', [ $this, 'onTask' ] );
		$this->websocket->on( 'finish', [ $this, 'onFinish' ] );
		$this->websocket->on( 'close', [ $this, 'onClose' ] );
		$this->websocket->start();
	}


	public function onWorkerStart( $server, $worker_id ) {
		// 定义应用目录
		define( 'APP_PATH', __DIR__ . '/../application/' );
		// 加载基础文件
//		require __DIR__ . '/../thinkphp/base.php';
		require __DIR__ . '/../thinkphp/start.php';
	}

	public function onOpen( $ws, $request ) {
		echo "监听客户端fd：" . $request->fd . "\n";
	}

	public function onMessage( $ws, $frame ) {
		$ws->push( $frame->fd, $frame->data . date( "Y-m-d H:i:s" ) );
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

		$_POST['http_server'] = $this->websocket;

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
		$obj    = new app\common\lib\task\Task;
		$method = $data['method'];
		$flag   = $obj->$method( $data['data'] );

		return $flag;
	}

	public function onFinish( $http, $taskId, $data ) {
		echo "taskId:{$taskId}\n";
		echo "finish_data_success:{$data}\n";
	}

	public function onClose( $http, $fd ) {
	}
}

new Websocket();