<?php
/** 
 * Mysql操作封装 
 * @author 码农<8044023@qq.com>
 *   */
namespace timePHP\Db;
use timePHP;
class Mysql{
    protected  $where="WHERE ";//条件
    protected  $field="*";//筛选字段
    protected  $talbe;//数据库名
    protected  $connect;
    protected  $sql;
    public function __construct($table=""){
        $this->talbe=$table;
    }
    //数据库连接
    public function connectDb(){
        $this->connect = mysqli_connect(C("DB.DB_HOST"),C("DB.DB_USER"),C("DB.DB_PWD"),C("DB.DB_NAME")) or die('Unale to connect');
    }
    //数据库操作初始化
    public  function run($table=""){
        $table !="" && $this->talbe=$table;
        return $this;
    }
    //条件
    public function where($where=""){
        $where!="" && $this->where=$this->where.$where;
        return $this;
    }
    //筛选的字段
    public function field($field){
        $field!="" && $this->field=$field;
        return $this;
    }
    //查询一条数据
    public function find(){
        $this->sql="SELECT ".$this->field." FROM ".$this->talbe." ".($this->where=="WHERE "?"":$this->where);
        return mysqli_fetch_assoc($this->_query());
    }
    //修改
    public function save($data){
        if(empty($data))
            timePHP\Error::run(505, "修改的参数不能为空！");
        $where=($this->where=="WHERE "?"":$this->where);
        if($where=="")
            timePHP\Error::run(504, "条件不能为空!");
        $val="";
        foreach ($data as $k=>$v){
            $val.="`".$k."`='".$v."'";
        }
        $this->sql="UPDATE `".$this->talbe."` SET ".$val." ".$this->where;
        return $this->_query();
        
    }
    //删除
    public function delete(){
        $where=($this->where=="WHERE "?"":$this->where);
        if($where=="")
           timePHP\Error::run(504, "条件不能为空!");
        $this->sql="DELETE FROM `".$this->talbe."` ".($this->where=="WHERE "?"":$this->where);
        return $this->_query();
    }
    //查询多条结果
    public function select(){
        $this->sql="SELECT ".$this->field." FROM ".$this->talbe." ".($this->where=="WHERE "?"":$this->where);
        return $this->get_result_array();
    }
    //获取 查询条数
    public function count(){
        $this->sql="SELECT COUNT(*) FROM ".$this->talbe." ".($this->where=="WHERE "?"":$this->where);
        return mysqli_num_rows($this->_query());
    }
    //添加
    public function add($data){
        if(empty($data))
            timePHP\Error::run(505, "修改的参数不能为空！");
        $key="";$val="";
        foreach ($data as $k=>$v){
            $key.=" `".$k."`";
            $val.=" '".$v."'";
        }
        $this->sql="INSERT INTO `".$this->talbe."`(".$key.") VALUES (".$val.")";
        $this->_query();
        return mysqli_insert_id($this->connect);
    }
    //执行复杂查询语句
    public function execute($sql){
        return $this->get_result_array($sql);
    }
    //执行sql语句
    protected  function _query(){
        $this->connectDb();
        return mysqli_query($this->connect,$this->sql);
    }
    //获取 结果数组
    protected function get_result_array(){
        $result = $this->_query($this->sql);
        $arr=array();
        while($row=$result->fetch_assoc()){
            $arr[]=$row;
        }
        return $arr;
    }
    //打印sql语句
    public function getLastSql($sql){
        echo $this->sql;
    }
}