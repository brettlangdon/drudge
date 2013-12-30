<?php
namespace Brettlangdon\Drudge;

class Server{
    protected $host = '0.0.0.0';
    protected $port = 80;
    protected $handler = NULL;

    private $server = NULL;

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

    }

    public function __destruct(){

    }
}