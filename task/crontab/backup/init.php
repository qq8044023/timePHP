<?php
/** 
 * 数据库备份  
 * @author 码农<8044023@qq.com>
 *   */
namespace Crontab;
class init{
    public static function _init(){
        /* $date = date("Ymd");
        foreach(C("TASK.backup")['dbArray'] as $db_name){
            $command ="mysqldump -u ".C("DB.DB_USER")." -p".replace_keyword(C("DB.DB_PWD"))." ".$db_name." >".C("TASK.backup")['target_dir'].$db_name."_".$date.".sql";
            shell_exec($command);
        }
        //删除 过期的数据库备份数据
        $past_time=C("TASK.backup")['target_dir'];
        for($i=$past_time;$i>=1;$i--){
            foreach(C("TASK.backup")['db_array'] as $db_name){
                $command="rm -rf ".C("TASK.backup")['target_dir'].$db_name."_".date("Ymd",time()-(($i+$past_time)*86400)).".sql";
                 shell_exec($command);//是否删除 过期的数据库
            }
        } */
        echo 1;
    }
}