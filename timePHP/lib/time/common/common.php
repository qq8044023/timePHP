<?php
/**
 * 系统函数
 *   */

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $echo=true, $label=null, $strict=true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}
/**
 * 获取和设置配置参数 支持批量定义
 * @param string|array $name 配置变量
 * @param mixed $value 配置值
 * @param mixed $default 默认值
 * @return mixed
 */
function C($name=null, $value=null,$default=null) {
    static $_config = array();
    // 无参数时获取所有
    if (empty($name)) {
        return $_config;
    }
    // 优先执行设置获取或赋值
    if (is_string($name)) {
        if (!strpos($name, '.')) {
            $name = strtoupper($name);
            if (is_null($value))
                return isset($_config[$name]) ? $_config[$name] : $default;
                $_config[$name] = $value;
                return null;
        }
        // 二维数组设置和获取支持
        $name = explode('.', $name);
        $name[0]   =  strtoupper($name[0]);
        if (is_null($value))
            return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : $default;
            $_config[$name[0]][$name[1]] = $value;
            return null;
    }
    // 批量设置
    if (is_array($name)){
        $_config = array_merge($_config, array_change_key_case($name,CASE_UPPER));
        return null;
    }
    return null; // 避免非法参数
}

/**
 * 验证文件是否存在
 * @param mixed $arr_file 配置值  
 *   */
function is_file_array($arr_file){
    foreach ($arr_file as $v){
        !file_exists($v) && timePHP\Error::run(700,"缺少配置文件和公共文件,请检查。");
    }
    return ;
}
/**
 * 启动进程
 * @param $config $arr_file 配置值  
 *   */
function Pstart($config,$key){
    $open=file_get_contents(COURSE_PID);
    $task_key=get_task_key($config, $key);
    
    if($open!=""){
        foreach (json_decode($open) as $k=>$v){
            if($task_key==$k){
                posix_kill($v, SIGTERM);//关闭当前进程
            }else{
                $arr[$k]=$v;
            }
        }
    }
    $arr[$task_key]=getmypid();
    file_put_contents(COURSE_PID,json_encode($arr));
}
function  sig_handler ( $signo ) {
    switch ( $signo ) {
        case  SIGTERM :
            // 处理中断信号
            exit;
            break;
        case  SIGHUP :
            // 处理重启信号
            break;
        default:
            // 处理所有其他信号
    }
}
function get_task_key($config,$key){
    if($key=="all"){
        return "all";
    }
    return $config["TASK"][$key]["number"];
}
//关闭进程中的所有的pid
function Pkill($config,$key){
    $open=file_get_contents("pid.log");
    if($open!=""){
        $task_key=get_task_key($config,$key);
        if($task_key=="all"){
            //关闭全部进程
            foreach (json_decode($open) as $v){
                //关闭进程
                posix_kill($v, SIGTERM);//关闭当前进程
            }
            file_put_contents(COURSE_PID,"");
        }else{//关闭单一进程
            $arr=json_decode($open);
            posix_kill($arr[$task_key], SIGTERM);//关闭当前进程
            unset($arr[$task_key]);
            file_put_contents(COURSE_PID,json_encode($arr));
        }
    }
}
//M方法
function M(){
    $a=new timePHP\Db();
    return $a->run();
}