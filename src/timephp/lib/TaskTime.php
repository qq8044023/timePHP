<?php
/**
 * Liunx    定时器       
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 *   */
namespace lib;
use lib\common\SystemFun;
class TaskTime{
    //类型处理
    protected static $_taskType=[
        "m"=>"executeM",
        "w"=>"executeW",//周
        "d"=>"executeD",//天
        "h"=>"executeHIS",//小时
        "i"=>"executeHIS",//分钟
        "s"=>"executeHIS"//秒
    ];
    /**
     * 入口
     *   */
    public static function init($taskOne){
        $task=$taskOne["taskObj"]->config["TASK"];
        if (!is_null(self::$_taskType[$task["timeType"]])){
            $taskType=self::$_taskType;
            self::$taskType[$task["timeType"]]($taskOne,$task["timeType"]);
        }else{
            throw new \Exception('不存在 \n');
        }
    }
    //一个月的几号几点执行
    public static function executeM($taskOne,$type=null){
        $wArray=explode(" ", $taskOne["taskObj"]->config["TASK"]["timePeriod"]);
        if (in_array((int)date("d"),explode(",",trim($wArray[0])))){
            $time=strtotime(date("Y-m-d ".$wArray[1]))-strtotime(date("Y-m-d H:i:s"));
            if ($time>70 || $time<-1){//设置时间 大于70秒的时候执行
                sleep(50);
            }else{
                if ($time<=2){
                    $taskOne["taskObj"]->run();
                    sleep(3600);
                }else{
                    sleep(1);
                }
            }
        }
    }
    //周
    public static function executeW($taskOne,$type=null){
        $wArray=explode(" ", $taskOne["taskObj"]->config["TASK"]["timePeriod"]);
        if (in_array(SystemFun::getWeek(date("Y-m-d")),explode(",", trim($wArray[0])))){
            $time=strtotime(date("Y-m-d ".$wArray[1]))-strtotime(date("Y-m-d H:i:s"));
            if ($time>70 || $time<-1){//设置时间 大于70秒的时候执行
                sleep(50);
            }else{
                if ($time<=2){
                    $taskOne["taskObj"]->run();
                    sleep(3600);
                }else{
                    sleep(1);
                }
            }
        }
    }
    //天
    public static function executeD($taskOne,$type=null){
        //1 时间对比
        $sTime=strtotime(date("Y-m-d ").$taskOne["taskObj"]->config["TASK"]["timePeriod"]);//设置的时间
        $dTime=strtotime(date("Y-m-d H:i:s"));//当前的时间
        $diffTime=$sTime-$dTime;//取到的时间差
        if ($diffTime>70 || $diffTime<-1){//设置时间 大于70秒的时候执行
            sleep(50);
        }else{
            if ($diffTime<=2){
                $taskOne["taskObj"]->run();
                sleep(3600);
            }else{
                sleep(1);
            }
        }
    }
    //时分秒
    public static function executeHIS($taskOne,$type=null){
        static $timeType=array(
            "h"=>3600,"i"=>60,"s"=>1
        );
        sleep($taskOne["taskObj"]->config["TASK"]["timePeriod"]*$timeType[$type]);
        if ($taskOne["taskObj"]->config["TASK"]["processType"]==false){
            $taskOne["taskObj"]->run();
        }
    }
}
