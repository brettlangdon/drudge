<?php
namespace Drudge;

class HTTPRequest{
    public $headers = array();
    public $query_string = NULL;
    public $path = NULL;
    public $method = NULL;
    public $body = NULL;

    public function __construct($raw_request){
        $parsed_request = array();
        $parser = uv_http_parser_init();

        if(uv_http_parser_execute($parser, $raw_request, $parsed_request)){
            $this->headers = $parsed_request['HEADERS'];
            $this->method = $parsed_request['REQUEST_METHOD'];
            $this->path = $parsed_request['PATH'];
            $query_string = $parsed_request['QUERY_STRING'];
            $question_pos = strpos($query_string, '?');
            if($question_pos !== false){
                $this->query_string = substr($query_string, $question_pos + 1);
            }

            if(array_key_exists('BODY', $this->headers)){
                $this->body = $this->headers['BODY'];
                unset($this->headers['BODY']);
            }
        } else{

        }
    }
}