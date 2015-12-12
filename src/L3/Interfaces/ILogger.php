<?php
namespace L3\Interfaces;

use Exception;

/**
 * 遵循 PSR-3 规范的日志接口声明。
 *
 * --------------------------------------------------------
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2005-2016, Lei Lee
 * @package       L3\Interfaces
 * --------------------------------------------------------
 */
interface ILogger extends IBase {
    /**
     * Set the module name.
     *
     * @param string $module
     */
    function setLogger($module);

    /**
     * Fatal message.
     *
     * @param string $message
     * @param array  $context
     */
    function fatal($message, $context = []);

    /**
     * Trace message.
     *
     * @param string $message
     * @param array  $context
     */
    function trace($message, $context = []);

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string    $message
     * @param array     $context
     * @param Exception $throwable
     * @return null
     */
    function error($message, $context = [], $throwable = NULL);

    /**
     * Exceptional occurrences that are not errors.
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array  $context
     * @return null
     */
    function warn($message, $context = []);

    /**
     * Interesting events.
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array  $context
     * @return null
     */
    function info($message, $context = []);

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array  $context
     * @return null
     */
    function debug($message, $context = []);

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     * @return null
     */
    function log($level, $message, $context = []);
}