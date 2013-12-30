<?php
namespace Drudge;

class Server{
    protected $host = '0.0.0.0';
    protected $port = 80;
    protected $handler = NULL;

    private $server = NULL;
    private $clients = array();

    public function __construct($params, $handler){
        if(!is_array($params)){
            throw new InvalidArgumentException('Brettlangdon\\Drudge\\Server requires param 1 to be an array');
        }

        if(!is_callable($handler)){
            throw new InvalidArgumentException('Brettlangdon\\Drudge\\Server requires param 2 to be a callable');
        }

        if(array_key_exists('host', $params)){
            $this->host = $params['host'];
        }

        if(array_key_exists('port', $params)){
            $this->port = intval($params['port']);
        }

        $this->handler = $handler;
    }

    public function run(){
        $this->server = uv_tcp_init();

        uv_tcp_bind($this->server, uv_ip4_addr($this->host, $this->port));
        uv_listen($this->server, 100, array($this, '_listen'));
        uv_run(uv_default_loop());
    }

    private function _listen($stream){
        $client = uv_tcp_init();
        uv_accept($stream, $client);

        $this->clients[(int)$client] = $client;

        uv_read_start($client, array($this, '_read'));
    }

    private function _read($client, $nread, $buffer){
        if($nread < 0){
            uv_shutdown($client, array($this, '_close'));
        } else if($nread == 0){
            if(uv_last_error() == UV::EOF){
                uv_shutdown($client, array($this, '_close'));
            }
        } else{
            $request = new \Drudge\HTTPRequest($buffer);
            $response = new \Drudge\HTTPResponse();

            $handler = $this->handler;
            $data = $handler($request, $response);

            uv_write($client, "{$response}\r\n{$data}", array($this, '_close'));
        }
    }

    private function _close($client){
        uv_close($client, function($client){
            unset($this->clients[(int)$client]);
        });
    }
}