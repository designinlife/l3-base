<?php
namespace L3\Interfaces;

/**
 * 输出流工具类接口。
 *
 * --------------------------------------------------------
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2005-2016, Lei Lee
 * @package       L3\Interfaces
 * --------------------------------------------------------
 */
interface IOutputStreamWriter {
    /**
     * 设置消息输出模板。
     *
     * @param string $pattern
     */
    function setPattern($pattern);

    /**
     * 输出消息。
     *
     * @param string $msg
     */
    function write($msg);

    /**
     * 输出消息并写入换行结束符。
     *
     * @param string $msg
     */
    function writeln($msg);
}