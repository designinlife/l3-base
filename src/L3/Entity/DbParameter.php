<?php
namespace L3\Entity;

/**
 * 数据库连接参数对象。
 *
 * --------------------------------------------------------
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2005-2016, Lei Lee
 * @package       L3\Entity
 * --------------------------------------------------------
 */
class DbParameter {
    /**
     * 主机地址。
     *
     * @var string
     */
    private $_host = '127.0.0.1';

    /**
     * 端口。
     *
     * @var int
     */
    private $_port = 3306;

    /**
     * 登录帐号。
     *
     * @var string
     */
    private $_user = 'root';

    /**
     * 密码。
     *
     * @var string
     */
    private $_pass = '';

    /**
     * 缺省连接的数据库。
     *
     * @var string
     */
    private $_db = 'test';

    /**
     * 字符集。
     *
     * @var string
     */
    private $_charset = 'utf8';

    /**
     * UNIX 套接字。
     *
     * @var string
     */
    private $_unix_socket = false;

    /**
     * 构造函数。
     *
     * @param string      $_host        DB 主机地址。
     * @param int         $_port        端口。
     * @param string      $_user        登录帐号。
     * @param string      $_pass        密码。
     * @param string      $_db          缺省数据库。
     * @param string      $_charset     客户端使用的字符集。
     * @param string|bool $_unix_socket 设置 UNIX 套接字。
     */
    function __construct($_host, $_port, $_user, $_pass, $_db, $_charset = 'utf8', $_unix_socket = false) {
        $this->_host        = $_host;
        $this->_port        = $_port;
        $this->_user        = $_user;
        $this->_pass        = $_pass;
        $this->_db          = $_db;
        $this->_charset     = $_charset;
        $this->_unix_socket = $_unix_socket;
    }

    /**
     * 获取 DB 主机地址。
     *
     * @return string
     */
    function getHost() {
        return $this->_host;
    }

    /**
     * 设置 DB 主机地址。
     *
     * @param string $host
     * @return DbParameter
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
     * @return DbParameter
     */
    function setPort($port) {
        $this->_port = $port;

        return $this;
    }

    /**
     * 获取登录帐号。
     *
     * @return string
     */
    function getUser() {
        return $this->_user;
    }

    /**
     * 设置登录帐号。
     *
     * @param string $user
     * @return DbParameter
     */
    function setUser($user) {
        $this->_user = $user;

        return $this;
    }

    /**
     * 获取密码。
     *
     * @return string
     */
    function getPass() {
        return $this->_pass;
    }

    /**
     * 设置密码。
     *
     * @param string $pass
     * @return DbParameter
     */
    function setPass($pass) {
        $this->_pass = $pass;

        return $this;
    }

    /**
     * 获取缺省连接的数据库。
     *
     * @return string
     */
    function getDb() {
        return $this->_db;
    }

    /**
     * 设置缺省连接的数据库。
     *
     * @param string $db
     * @return DbParameter
     */
    function setDb($db) {
        $this->_db = $db;

        return $this;
    }

    /**
     * 获取客户端使用的字符集。
     *
     * @return string
     */
    function getCharset() {
        return $this->_charset;
    }

    /**
     * 设置客户端使用的字符集。
     *
     * @param string $charset
     * @return DbParameter
     */
    function setCharset($charset) {
        $this->_charset = $charset;

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
     * @return DbParameter
     */
    function setUnixSocket($unix_socket) {
        $this->_unix_socket = $unix_socket;

        return $this;
    }
}