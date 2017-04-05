<?php 
namespace app\backup;
use lib\Task;
use lib\Db;
use lib\common\SystemFun;
/**
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 */
class backupTask extends Task{
    public function run(){
        $config=$this->getConfig();
        $date = date("Ymd");
        $sql_arr=array();
        $dir=$config["BAKDB"]["DBDIR"];//备份数据库存放路径
        foreach ($config["BAKDB"]["DBNAME"] as $dbName){
            $sqlName=$dir.$dbName."_".$date."sql.sql";
            $command ="mysqldump -u ".$config["DB"]["DB_USER"]." -p".SystemFun::replace_keyword($config["DB"]["DB_PWD"])." ".$dbName." >".$sqlName;
            shell_exec($command);
            $sql_arr[]=$sqlName;
        }
        //邮件发送C("EMAIL.GET_EMAIL")
        $this->timePHP_send_mail($config["EMAIL"]["GET_EMAIL"],'测试备份-'.date("Y-m-d H:i:s"),'备份测试环境-'.date("Y-m-d H:i:s",time()),'<p>邮件来了测试</p>',$sql_arr);
        //删除 过期的数据库备份数据
        $past_time=$config["BAKDB"]['PAST_TIME'];
        for($i=$past_time;$i>=1;$i--){
            foreach($config["BAKDB"]["DBNAME"] as $db_name){
                $command="rm -rf ".$dir.$db_name."_".date("Ymd",time()-(($i+$past_time)*86400)).".sql";
                //shell_exec($command);//是否删除 过期的数据库
            }
        }
    }
    /**
     * 邮件发送
     * @param unknown $to
     * @param unknown $name
     * @param string $subject
     * @param string $body
     * @param unknown $attachment  */
    public function timePHP_send_mail($to, $name, $subject = '', $body = '', $attachment = null){
        //引用插件
        SystemFun::import("extend@PHPMailer@PHPMailerAutoload");
        //获取 配置文件的邮件信息
        $config=$this->getConfig()["EMAIL"];
        $mail             = new \PHPMailer(); //PHPMailer对象
        $mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->IsSMTP();  // 设定使用SMTP服务
        $mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能
        $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
        $mail->SMTPSecure = 'tls';                 // 使用安全协议
        $mail->Host       = $config['SMTP_HOST'];  // SMTP 服务器
        $mail->Port       = $config['SMTP_PORT'];  // SMTP服务器的端口号
        $mail->Username   = $config['SMTP_USER'];  // SMTP服务器用户名
        $mail->Password   = $config['SMTP_PASS'];  // SMTP服务器密码
        $mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
        $replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
        $replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
        $mail->AddReplyTo($replyEmail, $replyName);
        $mail->Subject    = $subject;
        $mail->MsgHTML($body);
        $mail->AddAddress($to, $name);
        if(is_array($attachment)){ // 添加附件
            foreach ($attachment as $file){
                is_file($file) && $mail->AddAttachment($file);
            }
        }
        return $mail->Send() ? true : $mail->ErrorInfo;
    }
}