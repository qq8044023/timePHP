<?php
/**
 * 日志操作
 * @author 码农<8044023@qq.com>
 *   */
namespace timePHP;
class Log{
    /**
     * 日志写入接口
     * @access public
     * @param string $logFile 文件名
     * @param string $destination  写入目标
     * @return void
     */
    public static function write($destination='',$logFile='error.log') {
        error_log($destination,3,C('LOG.log_path').$logFile);
    }
}
