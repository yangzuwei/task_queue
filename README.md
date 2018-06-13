## 节省资源的任务队列处理器
- 单进程
- 守护进程
- 死循环中采用SIGSTOP去实现,避免了pause在死循环中的坑
- 有任务到来给处理器发个SIGCONT信号唤醒处理器进程
- 任务队列为空则给自身发个SIGSTOP信号

## 使用方法
1. 启动消费任务进程,php BluePrint.php
2. 写一个自定义的任务类继承Handler接口，例如JobExample
3. 推送任务到队列中，例程见PushJobTest.php
4. 执行php PushJobTest.php

## 只是一个简单demo没有使用composer等自动加载类，后续再优化
