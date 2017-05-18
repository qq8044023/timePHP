<?php 
// +----------------------------------------------------------------------
// | 向向
// +----------------------------------------------------------------------
// | Copyright (c) www.beeways.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 码农 <8044023@qq.com> <http://www.beeways.cn>
// +----------------------------------------------------------------------
/** ***********Mysql数据库配置*********************/
//数据库类型
!defined("DB_TYPE") && define("DB_TYPE","mysql");
//地址
!defined("DB_HOST") && define("DB_HOST","118.178.190.138");
//选择的数据库
!defined("DB_NAME") && define("DB_NAME","exploit_tourism_game");
//账号
!defined("DB_USER") && define("DB_USER","exploit_game");
//密码
!defined("DB_PWD") && define("DB_PWD","TbP0rHH92SxXZrdt");
//端口
!defined("DB_PORT") && define("DB_PORT","3306");
//表前缀
!defined("DB_PREFIX") && define("DB_PREFIX","tourism_");
/** *************Redis配置***************************  */
//连接地址
!defined("REDIS_HOST") && define("REDIS_HOST","r-bp16688868e85424.redis.rds.aliyuncs.com");
//连接的数据库 select
!defined("REDIS_SELECT") && define("REDIS_SELECT",0);
//端口
!defined("REDIS_PROT") && define("REDIS_PROT","6379");
//密码
!defined("REDIS_PASSWORD") && define("REDIS_PASSWORD","dHh2IgI5G8");

/***************公共配置文件***********************************  */
$configs=array(
    //redis 模拟数据库表
    "redis_talbe"=>array(
        "game_activity_team_building_room"=>array(
            "table"=>"tourism_game_activity_team_building_room",//表名
            "field"=>array(
                "id","name"
            ),//字段
            "key"  =>"id",//主键
            "cachetime"=>30,//秒缓存时间     如果为0表示永久
            "act_type"=>"hash,string"//类型备注
        ),
    ),
    //Mysql数据库配置信息
    'DB_TYPE'   => DB_TYPE, // 数据库类型
    'DB_HOST'   => DB_HOST, // 服务器地址
    'DB_NAME'   => DB_NAME, // 数据库名
    'DB_USER'   => DB_USER, // 用户名
    'DB_PWD'    => DB_PWD,  // 密码
    'DB_PORT'   => DB_PORT, // 端口
    'DB_PREFIX' => DB_PREFIX, // 数据库表前缀
    'DB_PARAMS'=>array('persist'=>true),//是否支持长连接
);

?>