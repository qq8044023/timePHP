<?php
/**
 * UI显示 
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 *   */
namespace lib;
class Ui{
    protected static $_maxPidLength = 12;
    /**
     * Maximum length of the socket names.
     *
     * @var int
     */
    protected static $_maxNameLength = 12;
    /**
     * 查看 启动状态UI
     *   */
    public static function statusUI(){
        print("\r\n".""."\r\n");
        echo "\033[1A\n\033[K-----------------------\033[47;30m timePHP \033[0m-----------------------------\n\033[0m";
        echo 'timePHP version:', ML_VERSION, "          PHP version:", PHP_VERSION, "\n";
        echo "------------------------\033[47;30m timePHP \033[0m-------------------------------\n";
        echo "\033[47;30mpid\033[0m", str_pad('',
        self::$_maxPidLength + 2 - strlen('pid')), "\033[47;30mname\033[0m", str_pad('',
        self::$_maxNameLength + 2 - strlen('name')), "\033[47;30mstatus\033[0m","\033[0m\n" ;//str_pad('',
        foreach (file::getJson() as $k=>$v) {
            echo str_pad($v['pid'], self::$_maxPidLength + 2), str_pad($k,
            self::$_maxNameLength + 2)," \033[32;40m [OK] \033[0m\n";
        }
        echo "-----------------------------------------------------------";
        die("\r\n".""."\r\n");
    }
    /**
     * 默认UI
     * @param unknown $text
     * @param string $isClose  */
    public static function displayUI($text,$isClose=true){
        print("\r\n");
        echo "\033[32;40m [".$text."] \033[0m";
        print("\r\n");
        $isClose==true && die;
    }
}



