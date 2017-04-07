<?php 
namespace app\clearmeesage;
use lib\Task;
use lib\common\SystemFun;
/**
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 */
class clearmeesageTask extends Task{
    public function run(){
        SystemFun::import("extend@PHPMailer@PHPMailerAutoload");
        error_log ( "测试每1小时执行一次:".date("YmdHis")."----" ,  3 ,  "/home/h.log" );
        //测试调用 该任务下的demo
        $demo=new Demo();
        $demo->demo1();
    }
}