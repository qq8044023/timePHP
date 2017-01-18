<?php 
/**
 * 任务进程中的配置文件
 * time 单位秒
 * @var array  */
return [
    //任务 id
    "TASK"=>[
        "clearmeesage"=>[
            "time"=>2,
            "number"=>0,
            "name"=>"clearmeesage"
        ],//清除短信中不要的垃圾数据
        "clearroom"=>[
            "time"=>2,
            "number"=>1,
            "name"=>"clearroom"
        ],//清除房间中不要的垃圾数据
        "backup"=>[
            "time"=>2,//多久备份一次
            "number"=>2,
            "name"=>"backup",
            "target_dir"=>"/home/bak/",//备份的路径
            "db_array"=>[//要备份的数据库
                "tourism_game",
                "tourism_game2"
            ],
            "past_time"=>9//过期时间/天
        ],//数据库定时备份
    ],
    "EXECUTE"=>["clearroom","backup","clearmeesage"],//需要启动的任务
    //数据库信息
    "DB"=>array(
        'DB_TYPE' => 'mysql',
        'DB_HOST' => 'localhost',
        'DB_NAME' => 'test',
        'DB_USER' => 'root',
        'DB_PWD' => 'root',
        'DB_PORT' => '3306',
        'DB_CODE'=>'utf8'
    ),
];
?>