<?php
/**
 * 自定义异常抛出
 * @author 码农<8044023@qq.com>
 *   */
namespace timePHP;
class CustomException extends \Exception{
    // 重定义构造器使 message 变为必须被指定的属性
    public function __construct($message, $code = 0) {
        // 确保所有变量都被正确赋值
        parent::__construct($message, $code);
    }
    // 自定义字符串输出的样式
    public function __toString() {
        $this->logWrite();
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    private function logWrite(){
        //日志写入
        static $levelArr=[
            1=>"致命",2=>"警告",3=>"待扩展"
        ];
        $arr=array();
        foreach ((array)$this as $k=>$v){
            $arr[]=$v;
        }
        $data=$arr[5][0];
        $log='['.$levelArr[$data["args"][0]].']['.date("Y-m-d H:i:s").']'.'\n';
        $log.='FILE:'.$data['file']."\n";
        $log.='LINE:'.$data['line'].'行'."\n";
        $log.='FUNCTION:'.$data['function']."\n";
        $log.='LEVEL:'.$data["args"][0]."\n";
        $log.='CODE:'.$data["args"][1]."\n";
        $log.='MSG:'.$data["args"][2]."\n";
        $log.='-------------------------------------------------------------------------------------------------'."\n";
        Log::write($log);
    }
    
}
