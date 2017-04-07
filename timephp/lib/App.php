<?php
/**
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 *   */
namespace lib;
class App{
    public  function run(){
        //获取命令行参数
        $argv = $_SERVER['argv'];
        $start_file = $argv[0];
        if (!isset($argv[1])) {
            exit("Usage: php yourfile.php {start|status|kill}\n");
        }
        $command  = trim($argv[1]);
        $command2 = isset($argv[2]) ? $argv[2] : '';
        //验证 是否重复启动进程
        Verify::init();
        switch ($command){
            case "start";//启动
                Verify::regRestart();
                Course::startAll();
                break;
            case "status":
                Ui::statusUI();
                break;
            case "kill":
                Course::killAll();
                break;
            default:
                Ui::displayUI("命令不存在");
                break;    
        }
    }
    
}
