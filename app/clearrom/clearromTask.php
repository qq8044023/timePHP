<?php 
namespace app\clearrom;
use lib\Task;
use lib\Db;
/**
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 */
class clearromTask extends Task{
    public function run(){
        $db=Db::setConfig($this->getConfig()["DB"]);
        $db->table("表名")->where(array("room_id"=>1))->save(array("status"=>1));
    }
}