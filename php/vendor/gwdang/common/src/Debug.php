<?php

/**
 * User: 周智超
 * Date: 2016/7/13
 * Time: 10:54
 */
namespace common;

class Debug {
    public static $callback = null;

    /**
     * @param callable|null $callback
     */
    public static function register($callback) {
        if(!is_null($callback) && !is_callable($callback)) {
            return ;
        }
        static::$callback = $callback;
    }
    
    public static function show() {
        if(is_callable(static::$callback)) {
            call_user_func_array(static::$callback, func_get_args());
        }
    }
}