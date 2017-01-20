<?php
/**
 * 数据库入口
 * @author 码农<8044023@qq.com>
 *   */
namespace timePHP;
use timePHP\Db;
class Db{
    //数据库类型
    protected $dbType=["Mysql"];
    public function run($table=""){
       if(in_array(ucfirst(C("DB.DB_TYPE")),$this->dbType)){
           Loader::loadfle("db.".ucfirst(C("DB.DB_TYPE")));
           return new Db\Mysql($table);
       }
       try {
           Error::run(Error::ERROR_WARNING_LEVEL, 503,"数据库扩展类不存在.");
       }catch (\Exception $e){
           echo $e;
       }
    }
}
