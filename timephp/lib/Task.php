<?php
/**
 * 任务管理
 * @author     村长<8044023@qq.com>
 * @copyright  TimePHP
 * @license    https://github.com/qq8044023/timePHP
 *   */
namespace lib;
abstract class Task{
    /**
     * 子类自己实现任务入口方法
     */
    abstract public function run();
    /**
     * 设置配置
     * @param  $config
     */
    public function setConfig($config=array()){
        $default_config['class_name']=get_called_class();
        $default_config['class_path']=str_replace('\\','/',$default_config['class_name'].'Task.class'.EXT);
        $default_config['task_path'] = dirname($default_config['class_path']);
        $default_config['config_path']=$default_config['task_path'].'/config'.EXT;
        $default_config['function_path']=$default_config['task_path'].'/function'.EXT;
        if (!empty($config)){
            if ($config["TASK"]["processType"]==true){
                $default_config['function_path']=COMMON_PATH.'/function'.EXT;
                $default_config['config_path']=COMMON_PATH.'/config'.EXT;
            }
        }
        if(is_file($default_config['config_path'])){
            $default_config= array_merge($default_config,(array) include_once $default_config['config_path']);
            if(null==@$default_config['TASK']){
                $default_config['TASK']=array(
                    'name'=>''
                );
            }
        }
        $this->config=array_merge($default_config,$config);

        include_once $default_config['function_path'];
        
    }
    public function getConfig(){
        return $this->config;
    }
    
}
