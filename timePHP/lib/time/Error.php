<?php
/**
 * 错误提示
 *   */
namespace timePHP;
class Error{
    public static function run($code,$msg){
        $data=["code"=>$code,"msg"=>$msg];
        dump($data);
        exit;
    }
}
