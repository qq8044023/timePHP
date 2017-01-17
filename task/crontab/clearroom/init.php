<?php
/**
 * 清除垃圾房间数据
 *   */
namespace Crontab;
class init{
    //入口
    static public function _init(){
        error_log(time(),3,"clearroom.log");
    }
}