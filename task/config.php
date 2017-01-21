<?php 
/**
 * 任务进程中的配置文件
 * @author 码农<8044023@qq.com>
 *   */
return [
    //任务 id
    "TASK"=>[
        "clearmeesage"=>[
            "time"=>2,//时间周期 /秒
            "number"=>0,//序列号
            "name"=>"clearmeesage"//进程名 （和任务名一样）
        ],//清除短信中不要的垃圾数据
        "clearroom"=>[
            "time"=>2,//时间周期 /秒
            "number"=>1,//序列号
            "name"=>"clearroom"//进程名 （和任务名一样）
        ],//清除房间中不要的垃圾数据
        "backup"=>[
            "time"=>2,//时间周期 /秒
            "number"=>2,//序列号
            "name"=>"backup",//进程名 （和任务名一样）
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