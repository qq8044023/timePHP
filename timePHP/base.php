<?php
/**
 * 全局引用
 * @author 码农<8044023@qq.com>
 * */
//版本号
set_time_limit(0);
define('ML_VERSION', '1.0');
define("DS", DIRECTORY_SEPARATOR);
define("APP_ROOT", __DIR__.DS);
//pid 存放路径
define('COURSE_PID', APP_ROOT.DS."pid.log");
define("LIB_PATH", APP_ROOT.DS."lib");
define("TASKCOMMON_PATH", APP_PATH.DS."task");
//框架核心目录
define("CORE_PATH", LIB_PATH.DS."time");
define("COMMON_PATH", CORE_PATH.DS."common");
// 载入Loader类
require_once CORE_PATH.DS."Loader.php";//
timePHP\Loader::autoload();
