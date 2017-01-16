<?php
/**
 * 
 * Mysql操作方法  
 *   */
namespace timePHP\Db;
class Mysql{
    public $where;
    public $field;
    //数据库连接
    public function connect(){
        
    }
    //数据库操作初始化
    public  function run(){
        return $this;
    }
    //条件
    public function where($where=""){
        $where!="" && $this->where=$where;
        return $this;
    }
    //筛选的字段
    public function field($field){
        $field!="" && $this->field=$field;
        return $this;
    }
    //查询一条数据
    public function find(){
        dump($this->where);
        dump($this->field);
    }
    //修改
    public function update(){
        
    }
    //删除
    public function delete(){
        
    }
    //查询多条结果
    public function select(){
        
    }
    //执行sql语句
    public function query($sql){
        
    }
    //执行查询语句
    public function execute(){
        
    }
}