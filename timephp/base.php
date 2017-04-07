<?php
/**
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 * */
//时间
date_default_timezone_set( 'Asia/Chongqing');
//版本
define('ML_VERSION', '1.0');
//斜杠
define("DS", DIRECTORY_SEPARATOR);
//当前根目录
define("APP_ROOT", __DIR__.DS);
//任务目录
define("TASK_PATH", APP_PATH.DS."app");
//pid 存放路径
define("TASKPHP_PATH", APP_PATH.DS."timephp");
//框架目录
define("LIB_PATH", APP_ROOT."lib");
//任务目录
define("TASKCOMMON_PATH", APP_PATH.DS."task");
//插件 存放目录
define("EXTEND_PATH", TASKCOMMON_PATH.DS."extend");
//框架核心目录
//define("CORE_PATH", LIB_PATH.DS."lib");
define("COMMON_PATH", LIB_PATH.DS."common");
define("EXT", ".php");
// 载入Loader类
require_once LIB_PATH.DS."Loader".EXT;//

$locator = \lib\Locator::getInstance();
//注册
$locator->register();
\lib\Locator::loadSysConfig();
\lib\Locator::loadTask();