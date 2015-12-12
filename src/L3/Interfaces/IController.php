<?php
namespace L3\Interfaces;

/**
 * 通用控制器接口。
 *
 * --------------------------------------------------------
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2005-2016, Lei Lee
 * @package       L3\Interfaces
 * --------------------------------------------------------
 */
interface IController {
    /**
     * 初始化事件。
     *
     * @return void
     */
    function initialize();

    /**
     * 在目标方法调用之前触发此事件。
     *
     * @return void
     */
    function before();

    /**
     * 在目标方法调用之后触发此事件。
     *
     * @return void
     */
    function after();
}