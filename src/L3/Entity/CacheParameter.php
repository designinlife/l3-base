<?php
namespace L3\Entity;

/**
 * 缓存服务器连接参数。
 *
 * --------------------------------------------------------
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2005-2016, Lei Lee
 * @package       L3\Entity
 * --------------------------------------------------------
 */
class CacheParameter {
    /**
     * 缓存主机地址。
     *
     * @var string
     */
    private $_host = '127.0.0.1';

    /**
     * 端口。
     *
     * @var int
     */
    private $_port = 0;

    /**
     * UNIX 套接字。
     *
     * @var string
     */
    private $_unix_socket = NULL;

    /**
     * 连接密码。
     *
     * @var string
     */
    private $_password = '';

    /**
     * 构造函数。
     *
     * @param string $_host        缓存主机地址。
     * @param int    $_port        端口。
     * @param string $_password    连接密码。
     * @param string $_unix_socket 设置 UNIX 套接字地址。
     */
    function __construct($_host, $_port, $_password = '', $_unix_socket = NULL) {
        $this->_host        = $_host;
        $this->_port        = $_port;
        $this->_password    = $_password;
        $this->_unix_socket = $_unix_socket;
    }

    /**
     * 获取缓存主机地址。
     *
     * @return string
     */
    function getHost() {
        return $this->_host;
    }

    /**
     * 设置缓存主机地址。
     *
     * @param string $host
     * @return CacheParameter
     */
    function setHost($host) {
        $this->_host = $host;

        return $this;
    }

    /**
     * 获取端口。
     *
     * @return int
     */
    function getPort() {
        return $this->_port;
    }

    /**
     * 设置端口。
     *
     * @param int $port
     * @return CacheParameter
     */
    function setPort($port) {
        $this->_port = $port;

        return $this;
    }

    /**
     * 获取 UNIX 套接字。
     *
     * @return string
     */
    function getUnixSocket() {
        return $this->_unix_socket;
    }

    /**
     * 设置 UNIX 套接字。
     *
     * @param string $unix_socket
     * @return CacheParameter
     */
    function setUnixSocket($unix_socket) {
        $this->_unix_socket = $unix_socket;

        return $this;
    }

    /**
     * 获取连接密码。
     *
     * @return string
     */
    function getPassword() {
        return $this->_password;
    }

    /**
     * 设置连接密码。
     *
     * @param string $password
     * @return CacheParameter
     */
    function setPassword($password) {
        $this->_password = $password;

        return $this;
    }
}