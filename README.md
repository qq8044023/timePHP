# timePHP

## timePHP用途？
timePHP是一个基于php cli开发的定时脚本框架,可以实现简单的配置,自己的逻辑代码纯php无需写shell脚本
易管理,易开发。简单的配置一下就可以根据需求开发自己的逻辑代码【此框架暂支持liunx系统】。

##timePHP操作命令

## 全部启动命令

```
[root@FX-DEBUG taskphp]# php ./start.php start

----------------------- timePHP -----------------------------
timePHP version:1.0          PHP version:5.6.9
------------------------ timePHP -------------------------------
pid           name          status
14524         backup          [OK] 
14525         clearmeesage    [OK] 
14526         clearrom        [OK] 
-----------------------------------------------------------

```

## 查看任务列表

```
[root@FX-DEBUG taskphp]# php ./start.php status

----------------------- timePHP -----------------------------
timePHP version:1.0          PHP version:5.6.9
------------------------ timePHP -------------------------------
pid           name          status
14524         backup          [OK] 
14525         clearmeesage    [OK] 
14526         clearrom        [OK] 
-----------------------------------------------------------

```
## 退出程序

```
[root@FX-DEBUG taskphp]# php ./start.php kill  

 [退出成功] 
 
``` 

## 目录结构

```
./start.php						入口启动文件
./app							任务主目录
./app/任务名						独立任务目录			
./app/任务名/config.php			该任务的配置文件	 
./app/任务名/function.php			该任务的函数
./app/任务名/任务名Task.class.php	任务入口文件
./app/任务名/Demo.php				自定义封装类可以不要	
./extend						第三方插件目录
./timephp						框架核心文件

```



