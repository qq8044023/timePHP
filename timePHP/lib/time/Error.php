<?php
/**
 * 异常抛出  
 * @author 码农<8044023@qq.com>
 *   */
namespace timePHP;
class Error{
    const ERROR_DEADLY_LEVEL = 1;//致命
    const ERROR_WARNING_LEVEL= 2;//警告
    const ERROR_DEFAULT      = 3;//默认异常
    public static function run($avalue=self::ERROR_WARNING_LEVEL,$code=1,$msg=null){
        switch ($avalue) {
            case self::ERROR_DEADLY_LEVEL://致命错误
                // 抛出自定义异常
                throw new CustomException($msg, $code);
                exit;
                break;
            case self::ERROR_WARNING_LEVEL://警告
                //警告
                throw new CustomException($msg, $code);
                break;
            case self::ERROR_DEFAULT:
                // 抛出默认的异常
                throw new \Exception($msg, $code);
                break;
            default:
                // 没有异常的情况下，创建一个对象
                $this->var = $avalue;
                break;
        } 
    }
}
