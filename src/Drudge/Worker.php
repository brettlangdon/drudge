<?php
namespace Drudge;

class Worker{
    private $script = NULL;
    private $loop = NULL;
    public $pipe = NULL;

    public function __construct($script, $loop){
        $this->script = $script;
        $this->loop = $loop;
    }

    public function start(){
        $this->pipe = uv_pipe_init($loop, 1);
        uv_pipe_open($this->pipe, 1);
    }
}