<?php
/**
 * 备份数据库
 * @author Administrator
 *  */
namespace Crontab;
import("PHPMailer.PHPMailerAutoload");//邮件发送插件
class init{
    public static function _init(){
        $date = date("Ymd");
        $sql_arr=array();
        foreach(C("TASK.backup")['dbArray'] as $db_name){
            $sql_name=C("TASK.backup")['target_dir'].$db_name."_".$date.".sql";
            $command ="mysqldump -u ".C("DB.DB_USER")." -p".replace_keyword(C("DB.DB_PWD"))." ".$db_name." >".$sql_name;
            shell_exec($command);
            $sql_arr[]=$sql_name;
        }
        //邮件发送C("EMAIL.GET_EMAIL")
        timePHP_send_mail(C("EMAIL.GET_EMAIL"),'测试备份-'.date("Y-m-d H:i:s"),'备份测试环境-'.date("Y-m-d H:i:s",time()),'<p>邮件来了测试</p>',$sql_arr);
        //删除 过期的数据库备份数据
        $past_time=C("TASK.backup")['target_dir'];
        for($i=$past_time;$i>=1;$i--){
            foreach(C("TASK.backup")['db_array'] as $db_name){
                $command="rm -rf ".C("TASK.backup")['target_dir'].$db_name."_".date("Ymd",time()-(($i+$past_time)*86400)).".sql";
                shell_exec($command);//是否删除 过期的数据库
            }
        }
    }
}