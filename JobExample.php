<?php

include "Handler.php";

class JobExample implements Handler
{
	protected $file;

	public function __construct($file)
	{
		$this->file = $file;
	}

	public function handle()
	{
		sleep(3);// pretend this is a time-consuming operation
		file_put_contents("test.txt","I am upload file ".$this->file." at ".date("Y-m-d H:i:s",time())." \n",FILE_APPEND);
	}
}
