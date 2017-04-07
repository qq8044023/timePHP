<?php 
/**
 * 文件操作
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 *   */
namespace lib;
class File{
   //缓存json文件路径
   protected static $_jsonPath=TASKPHP_PATH.DS.'pid.json';    
   /**
    * 写入json文件
    * 
    * @void 
    *   */
   public static function writeJson($pidList){
       file_put_contents(self::$_jsonPath,$pidList==null?"":json_encode($pidList));
   } 
   /**
    * 读取 json文件
    * @return json
    *   */
   public static function getJson(){
       return json_decode(@file_get_contents(self::$_jsonPath),true);
   }
   /**
    * 验证 pid文件是否存在
    * @return bool
    *   */
   public static function isFile(){
       if (
           !file_exists(self::$_jsonPath) || 
           json_decode(file_get_contents(self::$_jsonPath),true)==""
       ){
           return true;
       }
       return false;
   }
}
?>