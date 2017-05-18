<?php 
namespace app\backup;
use lib\Task;
use lib\common\SystemFun;
/**
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 */
class backupTask extends Task{
    public function run(){
        /**
         * 数据库操作
         *  
        SystemFun::Config($this->getConfig());
        $model=SystemFun::model("gameActivity");
        $res=$model->where(array('id'=>1))->find();
        var_dump($res);
        
         */
    }
    
}