# timePHP

##timePHP用途？
timePHP是一个基于php cli开发的定时脚本框架,可以实现简单的配置,自己的逻辑代码纯php无需写shell脚本
易管理,易开发。简单的配置一下就可以根据需求开发自己的逻辑代码。

##timePHP操作命令
##全部启动命令
```
[root@iZbp1if228spaovivfbbyjZ CronTab]# php ./start.php start all &
[启动成功]
```
##单一启动命令
```
[root@iZbp1if228spaovivfbbyjZ CronTab]# php ./start.php start backup
[启动成功]
```
###关闭命令
```
[root@iZbp1if228spaovivfbbyjZ CronTab]# php ./start.php kill
[关闭成功]
```
###单一关闭命令
```
[root@iZbp1if228spaovivfbbyjZ CronTab]# php ./start.php kill backup
[关闭成功]
```
###查看命令
```
[root@iZbp1if228spaovivfbbyjZ CronTab]# php ./start.php select

----------------------- timePHP -----------------------------
timePHP version:1.0          PHP version:5.6.22
------------------------ timePHP -------------------------------
pid           name          status
1853          clearroom       [OK] 
1854          backup          [OK] 
1855          clearmeesage    [OK] 
-----------------------------------------------------------

```
##目录结构
```
待完善
```
##配置文件规范
```
例:
<?php 
/**
 * 任务进程中的配置文件
 * time 单位秒
 * @var array  */
return [
    //任务 id
    "TASK"=>[
        "clearmeesage"=>[
            "time"=>60,
            "number"=>0,
            "name"=>"clearmeesage"
        ],//清除短信中不要的垃圾数据
        "clearroom"=>[
            "time"=>3600,
            "number"=>1,
            "name"=>"clearroom"
        ],//清除房间中不要的垃圾数据
        "backup"=>[
            "time"=>86400,//多久备份一次
            "number"=>2,
            "name"=>"backup",
            "target_dir"=>"/home/bak/",//备份的路径
            "dbArray"=>[//要备份的数据库
                "tourism_game",
            ],
            "past_time"=>9//过期时间/天
        ],//数据库定时备份
    ],
    "EXECUTE"=>["clearroom","backup","clearmeesage"],//需要启动的任务 "backup",
    //数据库信息
    "DB"=>array(
        'DB_TYPE' => 'mysql',
        'DB_HOST' => 'localhost',
        'DB_NAME' => 'demo',
        'DB_USER' => 'root',
        'DB_PWD' => 'root',
        'DB_PORT' => '3306',
        'DB_CODE'=>'utf8'
    ),
];
?>
```

