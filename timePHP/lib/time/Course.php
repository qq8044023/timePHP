<?php
/**
 * 执行进程操作
 *   */
namespace timePHP;
use Crontab;
class Course{
    protected $task;
    protected $putInfo;
    public function __construct(){
        $this->task=C();
        
        global $argv;
        $argv[1]="start";
        $argv[2]="backup";
        $this->putInfo=$argv;
        $this->run();
    }
    public function run(){
        $int=$this->putInfo[1];
        if(in_array($int, get_class_methods($this))){
            $this->$int();
        }else{
            Error::run(703, "你的操作命令错误");
        }
    }
    //执行
    public function start(){
        if($this->putInfo[2]=="all"){//批量开启 进程
            //多进程
            Error::run(705, "批量开启进程待完善.");
        }else{//开启单一进程
            $this->init($this->putInfo[2]);
        }
    }
    //执行程序
    public function init($courseName){
        require_once TASKCOMMON_PATH.'/crontab/'.$courseName.'/init.php';
        \Crontab\init::_init();
        die;
        //开发测试
        if(!in_array($courseName, $this->task["EXECUTE"])){
            Error::run(704, "任务配置错误,请检查配置文件.");
        }
        declare( ticks = 1 );
        $pid  =  pcntl_fork ();
        if ( $pid  == - 1 ) {
            die( "could not fork" );  //pcntl_fork返回-1标明创建子进程失败
        } else if ( $pid ) {
            exit();  //父进程中pcntl_fork返回创建的子进程进程号
        } else {
            // 子进程pcntl_fork返回的时0
        }
        // 从当前终端分离
        if ( posix_setsid () == - 1 ){
            die( "could not detach from terminal" );
        }  
        pcntl_signal ( SIGTERM ,  "sig_handler" );
        pcntl_signal ( SIGHUP ,  "sig_handler" );
        Pstart(C(),$courseName);
        require_once TASKCOMMON_PATH.'/crontab/'.$courseName.'/init.php';
        $time=C("Task");
        while ( 1 ) {
            \Crontab\init::_init();
            sleep($time[$courseName]["time"]);
        }
    }
    //停止程序
    public function kill(){
        Pkill(C(),$this->putInfo[2]);
        die("\r\n"."退出成功"."\r\n");
    }
    //查看进程
    public function select(){
        select(C());
    }
}