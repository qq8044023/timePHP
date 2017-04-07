<?php
/**
 * Liunx    系统进程操作       
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 *   */
namespace lib;
class Course{
    /** 起始值  */
    public static  $_pidStartCount = 0;
    /** 结束值  */
    public static  $_pidEndCount   = 1;
    /** pid列表  */
    private static $_pidList       = array();
    /**
     * 杀死一个进程
     * @param unknown $taskName 进程名
     * @throws \Exception  */
    public static function kill($taskName){
        $pidJson=File::getJson();
        if (array_key_exists($taskName, $pidJson)){
            posix_kill($pidJson[$taskName]["pid"], SIGTERM);//关闭当前进程
            unset($pidJson[$taskName]);
            File::writeJson($pidJson);
            //TODO 调用ui
        }else{
            throw new \Exception('不存在 \n');
        }
    }
    /**
     * 启动全部进程
     *   */
    public static function startAll(){
        self::initCourse(0,count(Locator::$_taskList));
        foreach (Locator::$_taskList as $taskName=>$v) self::start($taskName); 
        Ui::statusUI();
    }
    /**
     * 杀死全部进程
     *   */
    public static function killAll(){
        foreach (File::getJson() as $k=>$v) self::kill($k);
        Ui::displayUI("退出成功");
    }
    /**
     * 启动一个进程
     *   */
    public static function start($taskName){
        $taskOne=Locator::$_taskList[$taskName];
        $task=$taskOne["taskObj"]->config["TASK"];
        if ($task["status"]==1){
            for ($i=0;$i<$task["count"];$i++){
                $pid = pcntl_fork();//开启进程
                switch ($pid) {
                    case -1:
                        ui::displayUI("进程启动失败");
                    case 0://子进程
                        posix_setsid () == - 1 && die( "分离失败" );//TODO  待写异常抛出
                        if ($task["processType"]==true){
                            $c=$task["name"];
                            self::$c($taskOne);
                        }else{
                            self::ordinaryManage($taskOne);
                        }
                        die;
                        break;
                    default:
                        self::$_pidStartCount++;
                        $task["pid"]=$pid;
                        self::$_pidList[$task["name"]]=$task;
                        if (self::$_pidStartCount==self::$_pidEndCount){
                            $arr=self::$_pidList;
                            if (File::isFile()==false){
                                foreach (File::getJson() as $k=>$v){
                                    $arr[$k]=$v;
                                }
                            }
                            File::writeJson($arr);
                        }
                        break;
                }
            }
        }
    }
    /**
     * 初始化
     * @param number $startCount   初始化起始值
     * @param number $endCount     结束值 
     * @param array $pidList       pid列表
     *   */
    protected static function initCourse($startCount=0,$endCount=1,$pidList=array()){
        self::$_pidStartCount   =   $startCount;
        self::$_pidEndCount     =   $endCount;
        self::$_pidList         =   $pidList;
    }
    /**
     * 普通进程
     *   */
    protected static function ordinaryManage($taskOne){
        for (;;) TaskTime::init($taskOne);
    }
    /**
     * socket 进程
     * @param unknown $taskOne  */
    protected static function socketManage($taskOne){
        /* $socketConfig=$taskOne["configAll"]["SOCKET"];
        (new socketServer())->run(); */
    }
    /**
     * 进程监控
     * @return void
     *   */
    protected static function monitorManage($taskOne){
        TaskTime::init($taskOne);
        echo "我是进程监控";
    }
}
