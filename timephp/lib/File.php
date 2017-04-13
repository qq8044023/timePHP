<?php 
/**
 * 文件操作
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 *   */
namespace lib;
class File{   
   /**
    * 写入json文件
    * 
    * @void 
    *   */
   public static function writeJson($pidList){
       file_put_contents(TASKPHP_PATH.DS.'pid.json',$pidList==null?"":json_encode($pidList));
   } 
   /**
    * 读取 json文件
    * @return json
    *   */
   public static function getJson(){
       return json_decode(@file_get_contents(TASKPHP_PATH.DS.'pid.json'),true);
   }
   /**
    * 验证 pid文件是否存在
    * @return bool
    *   */
   public static function isFile(){
       if (
           !file_exists(TASKPHP_PATH.DS.'pid.json') || 
           json_decode(file_get_contents(TASKPHP_PATH.DS.'pid.json'),true)==""
       ){
           return true;
       }
       return false;
   }
}
?>