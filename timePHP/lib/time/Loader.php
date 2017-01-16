<?php
/**
 * 自动加载  
 * @author 码农<8044023@qq.com>
 *   */
namespace timePHP;
class Loader{
    //自动加载
    public static function autoload(){
        //加载 
        self::loadCommon();
        self::loadKernelFile();
    }
    //加载核心文件
    public static function loadKernelFile(){
        spl_autoload_register (function ( $class ) {
            require_once explode("\\", $class)[1] . '.php' ;
        });
    }
    //加载配置文件 和公用方法
    public static function loadCommon(){
        require_once COMMON_PATH.DS.'common.php';    
        C(require_once COMMON_PATH.DS.'config.php');
    }
}



