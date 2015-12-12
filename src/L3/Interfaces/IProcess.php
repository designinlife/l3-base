<?php
namespace L3\Interfaces;

/**
 * 进程接口。
 *
 * --------------------------------------------------------
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2005-2016, Lei Lee
 * @package       L3\Interfaces
 * --------------------------------------------------------
 */
interface IProcess {
    /**
     * 初始化事件。
     */
    function initialize();

    /**
     * 启动进程。
     */
    function run();

    /**
     * 检测到 shutdown 事件时调用此方法。
     */
    function shutdown();
}