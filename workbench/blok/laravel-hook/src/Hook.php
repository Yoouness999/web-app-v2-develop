<?php

namespace Blok\LaravelHook;

use Blok\Utils\Arr;
use JsonException;

class Hook extends \ArrayObject
{
    public static $pref = "";

    public static $logs = array();

    public static $callback = array();

    public static $debug = true;

    protected static $_hooks = [];

    public function __construct(){
        parent::__construct();
    }

    public function __get($name)
    {
        return self::$_hooks[$name];
    }

    public function __set($name, $value)
    {
        return self::put($name, $value);
    }

    public function __isset($name){
        return isset(self::$_hooks[$name]);
    }

    /**
     * Check if Hook has key
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return (bool)self::get($key);
    }

    public static function register($name, $callback = null){
       self::$_hooks[$name] = array();
        self::$callback[$name] = array($callback);
    }

    public static function log($action, $name, $params = array()){

        if(!isset($logs[$action])){
            self::$logs[$action] = array();
        }

        self::$logs[$action][$name][] = array(
            'params' => $params,
            'debug' => debug_backtrace(),
        );
    }

    public static function logs(){
        return self::$logs;
    }

    /**
     * @param $name
     * @param $mValue
     * @param null $merge
     * @return mixed
     * @throws \Exception
     * @internal param $value
     *
     * @deprecated please use put instead
     */
    public static function add($name, $mValue, $merge = null)
    {
        return self::put($name, $mValue);
    }

    /**
     * Force to set hook value
     *
     * @param $name
     * @param array $mValue
     * @return mixed
     */
    public static function set($name, $mValue = array()){
        return self::$_hooks[$name] = $mValue;
    }

    /**
     * Put data
     *
     * @param $name
     * @param array|string|boolean $mValue
     * @param null $merge
     * @return mixed
     * @throws \Exception
     */
    public static function put($name, $mValue = array(), $merge = null){

        if ($pos = strpos($name, '.')) {
            $dots = substr($name, $pos + 1);
            $name = substr($name, 0, $pos);
        }

        if (!isset(self::$_hooks[$name])) {
           self::$_hooks[$name] = array();
            self::log('add', $name, func_get_args());
        }

        if(!is_string($mValue) && $merge === null && !is_bool($mValue) && !Arr::is_sequential($mValue)){
            $merge = true;
        }

        if(isset($dots)){
            Arr::set(self::$_hooks[$name], $dots, $mValue);
        } elseif ($merge) {
            if (is_string($mValue)) {
                $mValue = array($mValue);
            }
           self::$_hooks[$name] =  Arr::merge(self::$_hooks[$name], $mValue);
        } elseif (is_array($mValue)) {
            foreach ($mValue as $v) {
                if(!in_array($v, self::$_hooks[$name], true)){
                   self::$_hooks[$name][] = $v;
                }
            }
        } else {
            if(!in_array($mValue, self::$_hooks[$name], true)){
               self::$_hooks[$name][] = $mValue;
            }
        }

        return self::$_hooks[$name];
    }

    /**
     * @throws \Exception
     */
    public static function putJsVars($mValue = array(), $name = 'gVars'){
        return self::put('gVars', $mValue);
    }

    /**
     * Load JS
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @comments :
     */
    public static function js($name = 'js')
    {
        return Asset::js(self::get($name));
    }

    /**
     * Load CSS file
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @comments :
     */
    public static function css($name = 'css')
    {
        return Asset::css(self::get($name));
    }

    /**
     * Load JS
     * @throws \Exception
     */
    public static function getJs($name = 'js')
    {
        return Load::JS($GLOBALS[self::$pref.$name]);
    }

    /**
     * Load CSS
     * @throws \Exception
     */
    public static function getCss($name = 'css')
    {
        return Load::css($GLOBALS[self::$pref.$name]);
    }

    /**
     * Return all hooks
     */
    public static function getAll()
    {
        return self::$_hooks;
    }

    /**
     * Output hook
     *
     * @return bool|string|mixed
     * @throws \Exception
     */
    public static function output($name)
    {
        $key = self::$pref.$name;

        if(isset(self::$_hooks[$key])){
            switch (true) {
                case ($name === 'css'):
                    $output = Load::css(self::$_hooks[$key]);
                    break;
                case ($name === 'js'):
                    $output = Load::js(self::$_hooks[$key]);
                    break;
                default:
                    $output = self::$_hooks[$key];
                    break;
            }
        } else {
            $output = null;
        }

        return $output;
    }

    /**
     * Get registered hook
     *
     * @param $name
     * @param null $default
     * @return array|mixed
     */
    public static function get($name, $default = null){

        $dots = null;

        if ($pos = strpos($name, '.')) {
            $dots = substr($name, $pos + 1);
            $name = substr($name, 0, $pos);
        }

        if(isset(self::$_hooks[$name])){

            if ($dots) {
                return Arr::get(self::$_hooks[$name], $dots, $default);
            }

            return self::$_hooks[$name];
        }

        if ($default) {
            return $default;
        }

        return [];
    }

    /**
     * Output json type
     *
     * @param $name
     * @param $default
     * @return string
     * @throws JsonException
     */
    public static function getJson($name, $default = array())
    {
        return json_encode(self::get($name, $default), JSON_THROW_ON_ERROR);
    }

    public static function eput($c){
        echo self::output($c);
    }

    /**
     * Start method put your output in memory cache until you end
     *
     * @param $name
     * @param null $key
     *
     */
    public static  function start($name, $key = null){
        if ($key) {
           self::$_hooks[$name][$key] = '';
        } else {
           self::$_hooks[$name] = '';
        }
        ob_start();
    }

    /**
     * End your cached data and save it in a globals
     * @param $name
     * @param null $key
     */
    public static function end($name, $key = null){

        if ($key) {
           self::$_hooks[$name][$key] = ob_get_contents();
        } else {
           self::$_hooks[$name] = ob_get_contents();
        }

        ob_end_clean();
    }
}
