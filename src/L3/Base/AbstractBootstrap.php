<?php
namespace L3\Base;

use L3\Entity\CacheParameter;
use L3\Entity\DbParameter;
use L3\Entity\RouteParameter;
use L3\Exceptions\ArgumentException;
use L3\Interfaces\IDb;
use L3\Interfaces\ILogger;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class `l3-base` Abstract Bootstrap.
 *
 * @package       L3\Base
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2005-2015, Lei Lee
 */
abstract class AbstractBootstrap {
    /**
     * 系统时区。
     *
     * @var string
     */
    protected $_timezone = 'Asia/Shanghai';

    /**
     * 错误报告级别。
     *
     * @var int
     */
    protected $_error_level = 32759;

    /**
     * 框架版本。
     *
     * @var string
     */
    protected $_version = '0.0.1';

    /**
     * 时间戳偏移值。
     *
     * @var int
     */
    protected $_time_offset = 0;

    /**
     * 指示是否 CLI 命令行运行模式？
     *
     * @var bool
     */
    protected $_cli_running = false;

    /**
     * 调试开关。
     *
     * @var bool
     */
    protected $_debug = false;

    /**
     * 日志级别。
     *
     * @var int
     */
    protected $_log_level = 0;

    /**
     * 日志目录。
     *
     * @var string
     */
    protected $_log_directory = '';

    /**
     * 日志模块。
     *
     * @var string
     */
    protected $_log_module = 'sys';

    /**
     * 控制器名称空间。
     *
     * @var string
     */
    protected $_controller_ns = '';

    /**
     * HTTP/CLI 路由解析参数对象。
     *
     * @var RouteParameter
     */
    protected $routeParameter = NULL;

    /**
     * DB 连接参数对象。
     *
     * @var DbParameter
     */
    protected $dbParameter = NULL;

    /**
     * Cache 连接参数对象。
     *
     * @var CacheParameter
     */
    protected $cacheParameter = NULL;

    /**
     * 事件订阅者列表。
     *
     * @var array
     */
    protected $event_subscribers = NULL;

    /**
     * 平台编号。
     *
     * @var int
     */
    public $pf = 0;

    /**
     * 区服编号。
     *
     * @var int
     */
    public $dist_id = 0;

    /**
     * 区服序号。
     *
     * @var int
     */
    public $sid = 0;

    /**
     * 游戏库名称。
     *
     * @var string
     */
    public $db_name = '';

    /**
     * 游戏配置库名称。
     *
     * @var string
     */
    public $db_base_name = '';

    /**
     * 游戏日志库名称。
     *
     * @var string
     */
    public $db_log_name = '';

    /**
     * PDO 数据库操作对象。
     *
     * @var IDb
     */
    public $dbo = NULL;

    /**
     * ILogger 日志操作对象。
     *
     * @var ILogger
     */
    public $log = NULL;

    /**
     * Redis 缓存对象。
     *
     * @var \Redis
     */
    public $cache = NULL;

    /**
     * Symfony 事件管理器对象。
     *
     * @var EventDispatcher
     */
    public $dispatcher = NULL;

    /**
     * 系统配置参数列表。
     *
     * @var array
     */
    public $cfgs = [];

    /**
     * 命令行参数列表。
     *
     * @var array
     */
    public $argv = [];

    /**
     * 已定义的接口命令列表。
     *
     * @var array
     */
    public $cmds = [];

    /**
     * 启动程序。
     *
     * @param array $argv
     * @param array $cfgs
     */
    final function dispatch(&$argv, &$cfgs) {
        if ('cli' == PHP_SAPI) {
            $this->_cli_running = true;
            $this->argv         = &$argv;
        }

        $this->cfgs = &$cfgs;

        // 设定全局引用变量 ...
        // ----------------------------------------------------------------
        if (isset($cfgs['db']['db_name']))
            $this->db_name = $cfgs['db']['db_name'];
        if (isset($cfgs['db']['db_base']))
            $this->db_base_name = $cfgs['db']['db_base'];
        if (isset($cfgs['db']['db_log']))
            $this->db_log_name = $cfgs['db']['db_log'];
        if (isset($cfgs['debug']['enable']))
            $this->_debug = $cfgs['debug']['enable'];

        $this->pf      = $cfgs['app']['pf'];
        $this->dist_id = $cfgs['app']['dist_id'];
        $this->sid     = $cfgs['app']['sid'];

        // 安装并初始化系统环境 ...
        // ----------------------------------------------------------------
        date_default_timezone_set($this->_timezone);

        set_error_handler([$this, 'defErrorHandler'], $this->_error_level);
        set_exception_handler([$this, 'defExceptionHandler']);

        register_shutdown_function([$this, 'defShutdownHandler']);

        $this->log = new GenericLogger($this);

        // 事件订阅模式设定 ...
        if (!empty($this->event_subscribers)) {
            $this->dispatcher = new EventDispatcher();

            foreach ($this->event_subscribers as $v) {
                $cls_n = Util::ns('Application\Event\Subscriber', $v);
                $cls_o = new $cls_n($this);

                $this->dispatcher->addSubscriber($cls_o);
            }
            // $this->log->info('已载入 ' . count($this->event_subscribers) . ' 个事件订阅者 <' . implode(', ', $this->event_subscribers) . '>');
        }

        // 依次调用事件流 ...
        // ----------------------------------------------------------------
        $this->initialize();
        $this->initializeComplete();
        $this->parse();
        $this->validate();
        $this->before();
        $this->execute();
        $this->after();
    }

    /**
     * 缺省错误处理函数。
     *
     * @param int    $errno
     * @param string $errstr
     * @param string $errfile
     * @param int    $errline
     * @throws \ErrorException
     */
    function defErrorHandler($errno, $errstr, $errfile, $errline) {
        throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
    }

    /**
     * 缺省异常处理函数。
     *
     * @param \Exception $ex
     */
    function defExceptionHandler(\Exception $ex) {
        if ($this->log) {
            $this->log->error($ex->getMessage(), [], $ex);
        }

        echo $ex->getMessage(), PHP_EOL;
        echo $ex->getTraceAsString(), PHP_EOL;
        exit(2);
    }

    /**
     * 载入系统核心组件。
     *
     * @throws ArgumentException
     */
    final function loadComponents() {
        if (!$this->dbParameter)
            throw new ArgumentException('检测到未设置 DB 连接参数。');
        if (!$this->cacheParameter)
            throw new ArgumentException('检测到未设置 Redis 连接参数。');

        $this->dbo = new DbPdo($this);
        $this->dbo->setDbParameter($this->dbParameter)
                  ->setAutoReconnect(false);

        $this->cache = new \Redis();

        if ($this->cacheParameter->getUnixSocket())
            $this->cache->connect($this->cacheParameter->getUnixSocket());
        else
            $this->cache->connect($this->cacheParameter->getHost(), $this->cacheParameter->getPort());

        $this->cache->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP);
    }

    /**
     * 初始化事件。
     *
     * @return void
     */
    protected function initialize() {
        $this->loadComponents();
    }

    /**
     * 初始化完成事件。
     *
     * @return void
     */
    abstract protected function initializeComplete();

    /**
     * 解析 HTTP/CLI 执行器路由对象。
     *
     * @return void
     */
    abstract protected function parse();

    /**
     * 验证请求合法性。
     *
     * @return void
     */
    abstract protected function validate();

    /**
     * 执行主进程。
     *
     * @return void
     */
    abstract protected function execute();

    /**
     * 进程结束时调用此方法。
     *
     * @return void
     */
    abstract function defShutdownHandler();

    /**
     * 在 AbstractBootstrap::execute() 执行之前触发此事件。
     *
     * @return void
     */
    protected function before() {
    }

    /**
     * 在 AbstractBootstrap::execute() 执行之后触发此事件。
     *
     * @return void
     */
    protected function after() {
    }

    /**
     * 获取当前系统时间戳。(注: 此方法返回的时间戳受 timeOffset 设置影响.)
     *
     * @return int
     */
    function cts() {
        return time() + $this->_time_offset;
    }

    /**
     * 读取并解析 .cfg 配置文件。
     *
     * @param string $filename
     * @return array
     */
    function getCfg($filename) {
        $c = file_get_contents(SYS_ROOT . $filename);
        $c = preg_replace(['/#[ ]*.[^\r\n]*/i', '/[\r\n]+/'], ['', "\n"], $c);

        $d = parse_ini_string($c);

        return $d;
    }

    /**
     * 获取系统时区。
     *
     * @return string
     */
    function getTimezone() {
        return $this->_timezone;
    }

    /**
     * 设置系统时区。
     *
     * @param string $timezone
     * @return AbstractBootstrap
     */
    function setTimezone($timezone) {
        $this->_timezone = $timezone;

        return $this;
    }

    /**
     * 获取错误报告级别。
     *
     * @return int
     */
    function getErrorLevel() {
        return $this->_error_level;
    }

    /**
     * 设置错误报告级别。
     *
     * @param int $error_level
     * @return AbstractBootstrap
     */
    function setErrorLevel($error_level) {
        $this->_error_level = $error_level;

        return $this;
    }

    /**
     * 获取框架版本。
     *
     * @return string
     */
    function getVersion() {
        return $this->_version;
    }

    /**
     * 获取系统时间偏移值。
     *
     * @return int
     */
    function getTimeOffset() {
        return $this->_time_offset;
    }

    /**
     * 设置系统时间偏移值。
     *
     * @param int $time_offset
     * @return AbstractBootstrap
     */
    function setTimeOffset($time_offset) {
        $this->_time_offset = $time_offset;

        return $this;
    }

    /**
     * 指示是否 CLI 命令行运行模式？
     *
     * @return boolean
     */
    function isCliRunning() {
        return $this->_cli_running;
    }

    /**
     * 指示是否调试模式运行中？
     *
     * @return boolean
     */
    function isDebug() {
        return $this->_debug;
    }

    /**
     * 设置调试模式开关。
     *
     * @param boolean $debug
     * @return AbstractBootstrap
     */
    function setDebug($debug) {
        $this->_debug = $debug;

        return $this;
    }

    /**
     * 获取日志写入级别。
     *
     * @return int
     */
    function getLogLevel() {
        return $this->_log_level;
    }

    /**
     * 设置日志写入级别。
     *
     * @param int $log_level
     * @return AbstractBootstrap
     */
    function setLogLevel($log_level) {
        $this->_log_level = $log_level;

        return $this;
    }

    /**
     * 获取日志存储目录。
     *
     * @return string
     */
    function getLogDirectory() {
        return $this->_log_directory;
    }

    /**
     * 设置日志存储目录。
     *
     * @param string $log_directory
     * @return AbstractBootstrap
     */
    function setLogDirectory($log_directory) {
        $this->_log_directory = $log_directory;

        return $this;
    }

    /**
     * 获取日志模块名称。
     *
     * @return string
     */
    function getLogModule() {
        return $this->_log_module;
    }

    /**
     * 设置日志模块名称。
     *
     * @param string $log_module
     * @return AbstractBootstrap
     */
    function setLogModule($log_module) {
        $this->_log_module = $log_module;

        return $this;
    }

    /**
     * 获取控制器名称空间。
     *
     * @return string
     */
    function getControllerNs() {
        return $this->_controller_ns;
    }

    /**
     * 设置控制器名称空间。
     *
     * @param string $controller_ns
     * @return AbstractBootstrap
     */
    function setControllerNs($controller_ns) {
        $this->_controller_ns = $controller_ns;

        return $this;
    }

    /**
     * 获取路由解析参数。
     *
     * @return RouteParameter
     */
    function getRouteParameter() {
        return $this->routeParameter;
    }

    /**
     * 获取 DB 连接参数。
     *
     * @return DbParameter
     */
    function getDbParameter() {
        return $this->dbParameter;
    }

    /**
     * 设置 DB 连接参数。
     *
     * @param DbParameter $dbParameter
     * @return AbstractBootstrap
     */
    function setDbParameter(DbParameter $dbParameter) {
        $this->dbParameter = $dbParameter;

        return $this;
    }

    /**
     * 获取 Cache 连接参数。
     *
     * @return CacheParameter
     */
    function getCacheParameter() {
        return $this->cacheParameter;
    }

    /**
     * 设置 Cache 连接参数。
     *
     * @param CacheParameter $cacheParameter
     * @return AbstractBootstrap
     */
    function setCacheParameter(CacheParameter $cacheParameter) {
        $this->cacheParameter = $cacheParameter;

        return $this;
    }

    /**
     * 设置 Symfony 事件订阅者。
     *
     * @param array $event_subscribers
     * @return AbstractBootstrap
     */
    function setEventSubscribers($event_subscribers) {
        $this->event_subscribers = $event_subscribers;

        return $this;
    }
}