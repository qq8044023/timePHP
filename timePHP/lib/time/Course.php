<?php
/**
 * 执行进程操作
 *   */
namespace timePHP;
use Crontab;
class Course{
    protected $task;
    protected $putInfo;
    protected static $_maxPidLength = 12;
    /**
     * Maximum length of the socket names.
     *
     * @var int
     */
    protected static $_maxNameLength = 12;
    
    /**
     * Maximum length of the process user names.
     *
     * @var int
     */
    public function __construct(){
        $this->task=C();
        global $argv;
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
            //多进程 批量执行 用另外的php 来启动配置文件里面的任务
            self::_regStart();
            print("\r\n");
            echo "\033[32;40m [启动成功] \033[0m";
            print("\r\n");
            $this->startAll();
        }else{//开启单一进程
            $this->init($this->putInfo[2]);
        }
    }
    //执行程序
    public function init($courseName){
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
        $this->_start($courseName);
        require_once TASKCOMMON_PATH.'/crontab/'.$courseName.'/init.php';
        $time=C("Task");
        while ( 1 ) {
            \Crontab\init::_init();
            sleep($time[$courseName]["time"]);
        }
    }
    //停止程序
    public function kill(){
        if (empty($this->putInfo[2]) || $this->putInfo[2]=="all"){
            $this->putInfo[2]="all";
        }
        $this->pKill($this->putInfo[2]);
        print("\r\n");
        echo "\033[32;40m [退出成功] \033[0m\n";
        die("\r\n");
    }
    //查看进程
    public function select(){
        self::_select();
    }
    /**
     * 启动进程
     * @param $config $arr_file 配置值
     *   */
    private  function _start($key){
        $open=file_get_contents(COURSE_PID);
        $task_key=$this->getTaskKey($key);
        if($open!="" || $open!=NULL){
            $pid_list=json_decode($open,true);
            if(!empty($pid_list["taskPid"])){
                foreach ($pid_list["taskPid"] as $k=>$v){
                    if($task_key==$k){
                        posix_kill($v, SIGTERM);//关闭当前进程
                    }else{
                        $taskPid[$k]=$v;
                    }
                }
            }
        }
        $taskPid[$task_key]=getmypid();
        $data=[
            "taskPid"=>$taskPid,
            "coursePid"=>!empty($pid_list["coursePid"])?$pid_list["coursePid"]:0
        ];
        file_put_contents(COURSE_PID,json_encode($data));
    }
    //验证是否是全部
    private function getTaskKey($key){
        if($key=="all"){
            return "all";
        }
        return C("TASK")[$key]["number"];
    }
    //关闭进程中的所有的pid
    private function pKill($key){
        $open=file_get_contents(COURSE_PID);
        if($open!="" || $open!=NULL){
            $task_key=$this->getTaskKey($key);
            $pid_list=json_decode($open,true);
            if($task_key=="all"){
                //关闭全部进程
                foreach ($pid_list["taskPid"] as $v){
                    //关闭进程
                    posix_kill($v, SIGTERM);//关闭当前进程
                }
                posix_kill($pid_list["coursePid"], SIGTERM);
                file_put_contents(COURSE_PID,"");
            }else{//关闭单一进程
                posix_kill($pid_list["taskPid"][$task_key], SIGTERM);//关闭当前进程
                unset($pid_list["taskPid"][$task_key]);
                file_put_contents(COURSE_PID,json_encode($pid_list));
            }
        }
    }
    //启动全部处理
    private function startAll(){
        $rootPath=shell_exec("pwd");
        $manCourse="";//获取到的主进程的pid
        //清除 原来存在的pid 重新启动
        self::_restart(getmypid());
        foreach (C("Execute") as $v){
            $manCourse.=" |php start.php start ".$v;
        }
        exec("cd ".str_replace(array(" ","　","\t","\n","\r"),"",$rootPath).$manCourse );
        exit;
    }
    //重启操作 关闭存在的进程
    private static function _restart($coursePid){
        $pid_list=json_decode(file_get_contents(COURSE_PID),true);
        if (!empty($pid_list["taskPid"])){
            foreach ($pid_list["taskPid"] as $v){
                posix_kill($v, SIGTERM);//关闭当前进程
            }
            posix_kill($pid_list["coursePid"], SIGTERM);//关闭主进程
        }
        file_put_contents(COURSE_PID,json_encode(["coursePid"=>$coursePid]));
    }
    //查看 运行中的进程
    private static function _select(){
        $open=file_get_contents(COURSE_PID);
        if($open==""){
            return "";
        }
        print("\r\n".""."\r\n");
        echo "\033[1A\n\033[K-----------------------\033[47;30m timePHP \033[0m-----------------------------\n\033[0m";
        echo 'timePHP version:', ML_VERSION, "          PHP version:", PHP_VERSION, "\n";
        echo "------------------------\033[47;30m timePHP \033[0m-------------------------------\n";
        echo "\033[47;30mpid\033[0m", str_pad('',
         self::$_maxPidLength + 2 - strlen('pid')), "\033[47;30mname\033[0m", str_pad('',
         self::$_maxNameLength + 2 - strlen('name')), "\033[47;30mstatus\033[0m","\033[0m\n" ;//str_pad('',
       //  self::$_maxSocketNameLength + 2 - strlen('status'))."\033[0m\n";//, "\033[47;30mprocesses\033[0m \033[47;30m", "status\033[0m\n";
        
         foreach (json_decode($open,true)["taskPid"] as $k=>$v) {
         echo str_pad($v, self::$_maxPidLength + 2), str_pad(C("Execute.".$k),
         self::$_maxNameLength + 2)," \033[32;40m [OK] \033[0m\n";;// str_pad(33,
        // self::$_maxSocketNameLength + 2), str_pad(' ' . 44, 9), " \033[32;40m [OK] \033[0m\n";;
         }
        echo "-----------------------------------------------------------";
        die("\r\n".""."\r\n");
        /* foreach (json_decode($open,true)["taskPid"] as $k=>$v){
            echo "    ".$v."                  ".C("Execute.".$k)."                    "."\r\n";
        } */
    }
    //验证 是否重复操作
    private static function _regStart(){
        $data=json_decode(file_get_contents(COURSE_PID),true);
        $data!=""?die("\r\n"."请关闭后再启动"."\r\n"):"";
    }
}