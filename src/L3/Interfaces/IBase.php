<?php
namespace L3\Interfaces;

use L3\Base\AbstractBootstrap;

/**
 * 系统接口基类。
 *
 * --------------------------------------------------------
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2005-2016, Lei Lee
 * @package       L3\Interfaces
 * --------------------------------------------------------
 */
interface IBase {
    /**
     * 构造函数。
     *
     * @param AbstractBootstrap $bootstrap 引用系统启动器实例。
     */
    function __construct(AbstractBootstrap $bootstrap);
}