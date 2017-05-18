<?php
/** 
 * 系统函数
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 *   */
namespace lib\common;
class SystemFun{
    /**
     * 特殊字符串替换
     * @param unknown $str
     * @return string|unknown  */
    static public function replace_keyword($str){
        $repArr=["@",".","!","&","$"];
        $repStr="";
        foreach (str_split($str) as $v){
            $repStr.=in_array($v, $repArr)?"\\".$v:$v;
        }
        return $repStr;
    }
    /**
     * 导入所需的类库 
     *  * @param unknown $str
     */
    static public function import($path) {
        require APP_PATH.DS.str_replace("@","/",$path).EXT;
    }
    /**
     * 获取时间是星期几
     * @param unknown $date 2017-12-23
     * @param string $dateType  false 数字  true 中文
     * @return 星期几
     *   */
    static public function getWeek($date,$dateType=false){
        //强制转换日期格式
        $date_str=date('Y-m-d',strtotime($date));
    
        //封装成数组
        $arr=explode("-", $date_str);
         
        //参数赋值
        //年
        $year=$arr[0];
         
        //月，输出2位整型，不够2位右对齐
        $month=sprintf('%02d',$arr[1]);
         
        //日，输出2位整型，不够2位右对齐
        $day=sprintf('%02d',$arr[2]);
         
        //时分秒默认赋值为0；
        $hour = $minute = $second = 0;
         
        //转换成时间戳
        $strap = mktime($hour,$minute,$second,$month,$day,$year);
         
        //获取数字型星期几
        $number_wk=date("w",$strap);
        $weekArr=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
        if ($dateType==false){
            $weekArr=array(0,1,2,3,4,5,6);
        }
        //获取数字对应的星期
        return $weekArr[$number_wk];
    }
    /**
     * 系统配置文件
     * @param unknown $name
     * @param unknown $value
     * @param unknown $default
     * @return array|string|mixed|NULL|string  */
    static public function Config($name=null, $value=null,$default=null) {
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
     * 数据库实例化
     * @param string $name
     * @param string $tablePrefix
     * @param string $connection
     * @return unknown  */
    static public function model($name='', $tablePrefix='',$connection='') {
        static $_model  = array();
        if(strpos($name,':')) {
            list($class,$name)    =  explode(':',$name);
        }else{
            $class      =   'lib\\Model';
        }
        $guid           =   (is_array($connection)?implode('',$connection):$connection).$tablePrefix . $name . '_' . $class;
        if (!isset($_model[$guid]))
            $_model[$guid] = new $class($name,$tablePrefix,$connection);
        return $_model[$guid];
    }
    /**
     * 字符串命名风格转换parse_name
     * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
     * @param string $name 字符串
     * @param integer $type 转换类型
     * @return string
     */
    static public function parseName($name, $type=0) {
        if ($type) {
            return ucfirst(preg_replace_callback('/_([a-zA-Z])/', function($match){return strtoupper($match[1]);}, $name));
        } else {
            return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
        }
    }
}



