<?php
/**
 * 执行
 *   */
namespace timePHP;
class App{
    public static function run(){
        self::loadTask();  
        new Course();
    }
    //加载 项目中的 function 和config
    public static function loadTask(){
        static $configFile=[
            TASKCOMMON_PATH.DS.'common.php',
            TASKCOMMON_PATH.DS.'config.php'
        ];
        is_file_array($configFile);//验证文件是否存在
        //验证 任务是否设置 
        C(array_merge(C(),require_once $configFile[1]));
        if(empty(C("Execute"))){
            try {
                Error::run(Error::ERROR_WARNING_LEVEL,701,"任务不能空。");
            }catch (\Exception $e){
                echo $e;
            }
        }
        require_once $configFile[0];
    }
}
