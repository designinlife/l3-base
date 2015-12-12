<?php
namespace L3\Entity;

/**
 * 路由参数解析结果对象。
 *
 * --------------------------------------------------------
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2005-2016, Lei Lee
 * @package       L3\Entity
 * --------------------------------------------------------
 */
class RouteParameter {
    /**
     * 控制器。
     *
     * @var string
     */
    private $_controller = '';

    /**
     * 接口方法。
     *
     * @var string
     */
    private $_method = '';

    /**
     * 附加参数列表。
     *
     * @var array|null
     */
    private $_data = NULL;

    /**
     * 构造函数。
     *
     * @param string     $_controller 控制器名称。
     * @param string     $_method     接口方法。
     * @param array|null $_data       可选参数列表。
     */
    function __construct($_controller, $_method, $_data = NULL) {
        $this->_controller = $_controller;
        $this->_method     = $_method;
        $this->_data       = $_data;
    }

    /**
     * 获取控制器。
     *
     * @return string
     */
    function getController() {
        return $this->_controller;
    }

    /**
     * 设置控制器。
     *
     * @param string $controller
     * @return RouteParameter
     */
    function setController($controller) {
        $this->_controller = $controller;

        return $this;
    }

    /**
     * 获取接口方法。
     *
     * @return string
     */
    function getMethod() {
        return $this->_method;
    }

    /**
     * 设置接口方法。
     *
     * @param string $method
     * @return RouteParameter
     */
    function setMethod($method) {
        $this->_method = $method;

        return $this;
    }

    /**
     * 获取附加参数列表。
     *
     * @return array|null
     */
    function getData() {
        return $this->_data;
    }

    /**
     * 设置附加参数列表。
     *
     * @param array|null $data
     * @return RouteParameter
     */
    function setData($data) {
        $this->_data = $data;

        return $this;
    }
}