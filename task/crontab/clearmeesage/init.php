<?php
/**
 * 清除短信验证码中 垃圾数据
 * @author Administrator
 *  */
class init{
    //入口
    static public function _init($config){
        $Db=new MysqlDb($config);
        $date=date("Y-m-d H:i:s",time()-300);
        $sql="UPDATE tourism_game_message SET status=-1 WHERE status=1 AND create_date<'".$date."'";
        $Db->query($sql);
    }
}