<?php
/**
 * 基本验证 
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 *   */
namespace lib;
class Verify{
    /**
     * 入口
     *   */
    public static function init(){
        self::checkSapiEnv();   
    }
    /**
     * 验证环境
     *   */
    protected static function checkSapiEnv(){
        // Only for cli.
        if (php_sapi_name() != "cli") {
            exit("only run in command line mode \n");
        }
    }
    /**
     * 验证命令行
     *   */
    public static function parseCommand(){
        global $argv;
        // Check argv;
        $start_file = $argv[0];
        if (!isset($argv[1])) {
            exit("Usage: php yourfile.php {start|stop|restart|reload|status|kill}\n");
        }
        // Get command.
        $command  = trim($argv[1]);
        $command2 = isset($argv[2]) ? $argv[2] : '';
        
        // Start command.
        $mode = '';
        if ($command !== 'start' && $command !== 'restart' && $command !== 'kill') {
            self::log("Workerman[$start_file] not run");
            exit;
        }
    }
    /**
     * 验证是否重复启动
     *   */
    public static function regRestart(){
        if (File::getJson()!="")
            Ui::displayUI("请关闭后再启动");
    }
}



