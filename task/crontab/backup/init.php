<?php
/**
 * 备份数据库
 * @author Administrator
 *  */
namespace Crontab;
class init{
    public static function _init(){
        
        $db=M();
        $db->where("id=1")->find();
        
       // $db->where()->fild();
    }
}