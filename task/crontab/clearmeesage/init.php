<?php
/**
 * 清除短信验证码中 垃圾数据
 * @author Administrator
 *  */
namespace Crontab;
class init{
    //入口
    static public function _init(){
        $date=date("Y-m-d H:i:s",time()-300);
        $where="status=1 AND create_date<'".$date."'";
        M("tourism_game_message")->where($where)->save(["status"=>-1]);
    }
}