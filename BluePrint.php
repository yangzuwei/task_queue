<?php
/**
 * Created by PhpStorm.
 * User: yzw
 * Date: 2018/4/1 0001
 * Time: 下午 21:33
 */
include "JobExample.php";

class BluePrint
{
    protected $isDaemon;
    protected $pid;

    public function __construct()
    {
        $this->setPid();
    }

    //todo
    public function daemon()
    {

    }

    protected function setPid()
    {
        $this->pid = posix_getpid();
        file_put_contents("worker_pid",$this->pid);
    }

    public function run()
    { 
        while(true){
        	$taskList = $this->getTaskList();
        	if(empty($taskList)){
        		$this->stop();
        	}
        	$this->consume($taskList);
        }
    }

    protected function consume($taskList)
    {
    	while(!empty($taskList)){
		    $job = array_pop($taskList);
	        $job = unserialize($job);
	        $job->handle();
    	}
    }

    protected function stop()
    {
        posix_kill($this->pid,SIGSTOP);
    }

    protected function getTaskList()
    {
        //get tasklist from something like redis or database
        $redis = new Redis();
        $redis->connect("127.0.0.1",6379);
        $result = [];
        if($result = $redis->lrange("task_list",0,-1)){
        	$redis->delete("task_list");
        }
    
        return $result;
    }
}

(new BluePrint())->run();
