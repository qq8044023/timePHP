<?php
/**
 * 数据库扩展
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 */
namespace lib;
use lib\db\Mysql;
class Db{
    //配置文件
    private static $_config;
    public  $_query=null;
    //选中的表
    public function table($table=null){    
        switch (strtoupper(self::$_config["db_type"])){
            case "MYSQL":
                $this->_query=new Mysql($table, self::$_config);
                break;
            default:
                die("数据库扩展不存在..");
        }
        return $this->_query;
    }
    /**
     * 设置配置信息
     * @param unknown $config  */
    public static function setConfig($config){
        self::$_config=array(
            "db_type"=>$config["DB_TYPE"],
            "db_host"=>$config["DB_HOST"],
            "db_username"=>$config["DB_USER"],
            "db_password"=>$config["DB_PWD"],
            "db_prot"=>$config["DB_PORT"],
            "db_name"=>$config["DB_NAME"]
        );
        return new static();
    }
}