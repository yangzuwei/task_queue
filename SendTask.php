<?php
/**
 * Created by PhpStorm.
 * User: yzw
 * Date: 2018/4/1 0001
 * Time: 下午 21:53
 */

class SendTask
{
    protected $workerPid;
    protected $job;

    public function __construct($job)
    {
        $this->job = $job;
        $this->getWorkerPid();
    }

    public function getTaskContainer()
    {
        $redis = new Redis();
        $redis->connect("127.0.0.1",6379);
        return $redis;
    }

    public function pushTask()
    {
        //store job in the redis or other database
        $this->storeTask();
        var_dump($this->workerPid);
        $this->wakeupWorker();
    }

    protected function storeTask()
    {
        //store job in the redis or other database like this
        $redis = $this->getTaskContainer();
        $redis->lpush("task_list",serialize($this->job));
        //job must implements interface hanler
    }

    protected function wakeupWorker()
    {
        posix_kill($this->workerPid,SIGCONT);
    }

    protected function getWorkerPid()
    {
        $this->workerPid = (int)file_get_contents("worker_pid");
    }
}