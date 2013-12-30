<?php
namespace Drudge;

class HTTPResponse{
    protected $http_version = '1.1';
    protected $headers = array();
    protected $cookies = array();
    protected $status = '200 Ok';

    public function setHeader($name, $value){
        $this->headers[$name] = strval($value);
    }

    public function setCookie($name, $value){
        array_push($this->cookies = "{$name}={$value}");
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function __toString(){
        $response = "HTTP/{$this->http_version} {$this->status}\r\n";
        foreach($this->headers as $name => $value){
            $response .= "{$name}: {$value}\r\n";
        }

        if(count($this->cookies)){
            $cookies = implode(';', $this->cookies);
            $response .= "Cookie: {$cookies}\r\n";
        }

        return $response;
    }
}