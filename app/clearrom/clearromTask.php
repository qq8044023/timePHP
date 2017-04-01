<?php 
namespace app\clearrom;
use lib\Task;
use lib\Db;
use lib\common\SystemFun;
/**
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 */
class clearromTask extends Task{
    public function run(){
      //  echo "我是清除房间id测试分钟";
        error_log ( "测试分钟2分钟执行一次:".date("YmdHis")."----" ,  3 ,  "/home/i.log" );
    }
}