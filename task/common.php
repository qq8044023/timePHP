<?php
/**
 * 函数
 * @author 码农<8044023@qq.com>
 *   */
/////////////////////////////////////////////////////////////////////////////////
/**
 * 邮件发送
 * @param   string   $to     发送的邮箱地址
 * @param   string   $name   名字
 * @param   string   $subject  描述
 * @param   string   $body      内容
 * @param   array    $attachment    发送的文件附件
 *   */
function timePHP_send_mail($to, $name, $subject = '', $body = '', $attachment = null){
    //初始化
    $mail             = new \PHPMailer(); //PHPMailer对象
    $mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP();  // 设定使用SMTP服务
    $mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能
    $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
    $mail->SMTPSecure = 'tls';                 // 使用安全协议
    $mail->Host       = C("EMAIL")['SMTP_HOST'];  // SMTP 服务器
    $mail->Port       = C("EMAIL")['SMTP_PORT'];  // SMTP服务器的端口号
    $mail->Username   = C("EMAIL")['SMTP_USER'];  // SMTP服务器用户名
    $mail->Password   = C("EMAIL")['SMTP_PASS'];  // SMTP服务器密码
    $mail->SetFrom(C("EMAIL")['FROM_EMAIL'], C("EMAIL")['FROM_NAME']);
    $replyEmail       = C("EMAIL")['REPLY_EMAIL']?C("EMAIL")['REPLY_EMAIL']:C("EMAIL")['FROM_EMAIL'];
    $replyName        = C("EMAIL")['REPLY_NAME']?C("EMAIL")['REPLY_NAME']:C("EMAIL")['FROM_NAME'];
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