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
        'DB_NAME' => '',//数据库
        'DB_USER' => '',//账号
        'DB_PWD' => '',//密码
        'DB_PORT' => '3306',
        'DB_CODE'=>'utf8'
    ),
    //邮件发送配置
    "EMAIL"=>[
        'SMTP_HOST'   => 'smtp.qq.com', //SMTP服务器
        'SMTP_PORT'   => '587', //SMTP服务器端口
        'SMTP_USER'   => '469989837@qq.com', //SMTP服务器用户名
        'SMTP_PASS'   => '', //SMTP服务器密码
        'FROM_EMAIL'  => '469989837@qq.com', //发件人EMAIL
        'FROM_NAME'   => '测试附件服务器端', //发件人名称
        'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
        'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
        "GET_EMAIL"   => 'cqkxm@qq.com',//接收邮箱地址
    ],
];
?>