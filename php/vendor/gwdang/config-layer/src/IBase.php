<?php
/**
 * User: 周智超
 * Date: 2016/7/8
 * Time: 15:02
 */

namespace config;


interface IBase {
    public static function get($key);
    public static function has($key);
    public static function set($key, $value);
    public static function loadConfig();
}