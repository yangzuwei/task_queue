<?php
/**
 * Created by PhpStorm.
 * User: yzw
 * Date: 2018/4/1 0001
 * Time: 下午 21:33
 */

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
        file_put_contents("worker_pid.txt",$this->pid);
    }

    public function handler($taskListKey)
    {
        $taskList = $this->getTaskList($taskListKey);
        while(true){
            if(empty($taskList)){
                $this->stop();
            }
            $this->consume($taskList);
        }
    }

    protected function stop()
    {
        posix_kill($this->pid,SIGSTOP);
    }

    protected function consume($taskList)
    {
        while(!empty($taskList)) {
            $job = array_pop($taskList);
            $job->doSomething();
        }
    }

    protected function getTaskList($key)
    {
        //get tasklist from something like redis or database
    }
}