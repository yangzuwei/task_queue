<?php
include "JobExample.php";
include "SendTask.php";

$job = new JobExample("big_file");
$sender = new SendTask($job);
$sender->pushTask();
