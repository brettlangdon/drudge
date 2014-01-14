<?php
namespace Drudge;

class WorkerPool{
    private $workers = array();
    private $numWorkers = 1;
    private $script = NULL;

    public function __construct($script, $numWorkers=1){
        $this->numWorkers = $numWorkers;
        $this->script = $script;
        for($i = 0; $i < $this->numWorkers; ++$i){
            array_push($this->workers, new \Drudge\Worker($this->script));
        }
    }

    public function run(){

    }
}