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

    public function getTaskContainer()
    {
        $redis = new Redis();
        return $redis;
    }

    public function pushTask($job)
    {
        //store job in the redis or other database
        $this->storeTask($job);
        $this->wakeupWorker();
    }

    protected function storeTask($job)
    {
        //store job in the redis or other database like this
        $redis = $this->getTaskContainer();
        $redis->lpush("task_key",serialize($job));
    }

    protected function wakeupWorker()
    {
        posix_kill($this->workerPid,SIGCONT);
    }

    protected function getWorkerPid()
    {
        $this->workerPid = file_get_contents("worker_pid.txt");
    }
}