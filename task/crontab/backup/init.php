<?php
/**
 * 备份数据库
 * @author Administrator
 *  */
namespace Crontab;
class init{
    public static function _init(){
        error_log(time(),3,"bakcup.log");
    }
}