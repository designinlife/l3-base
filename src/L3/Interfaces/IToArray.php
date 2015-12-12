<?php
namespace L3\Interfaces;

/**
 * PHP 类对象转换 Array 输出接口。
 *
 * --------------------------------------------------------
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2005-2016, Lei Lee
 * @package       L3\Interfaces
 * --------------------------------------------------------
 */
interface IToArray {
    /**
     * 对象属性转换为 PHP 数组输出。
     *
     * @param array $options 参数选项。
     * @return array
     */
    function toArray(array $options = array());

    /**
     * 对象属性转换为 JSON 字符串输出。
     *
     * @param array $options 参数选项。
     * @return string
     */
    function toJSONString(array $options = array());
}