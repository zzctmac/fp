<?php
/**
 * User: 周智超
 * Date: 2016/7/8
 * Time: 15:09
 */

namespace config;


abstract class Base implements IBase{
    protected static $configDir;
    protected static $config;
    public static $delimit = '.';
    protected static $suffix = '';
    public static $PARSE_DOT = true;

    /**
     * @param string $configDir
     * @param bool $parse_dot
     * @throws Exception
     */
    public static function init($configDir, $parse_dot = true) {
        if(!is_dir($configDir)) {
            throw new Exception("dir not exist \"" . $configDir . "\" ", Exception::NO_DIR);
        }
        self::$configDir = $configDir ;
        static::$PARSE_DOT = $parse_dot;
        static::loadConfig();
    }

    public static function getByStep($key, $config) {
        $keyArr = explode(self::$delimit, $key);
        $key = array_shift($keyArr);
        if(array_key_exists($key, $config)) {
            $tryValue = $config[$key];
            //没有下级了，还是找下一级
            if(!is_array($tryValue) && count($keyArr) > 0) {
                return null;
            }
            if(count($keyArr) == 0) {
                return $tryValue;
            }
            return self::getByStep(implode(self::$delimit, $keyArr), $tryValue);
        } else {
            return null;
        }
    }

    public static function get($key) {
        if('*' === $key) {
            return self::$config;
        }
        return self::getByStep($key, self::$config);
    }

    public static function has($key) {
        $value = static::get($key);
        return $value !== null;
    }

    public static function set($key, $value) {
        $keyArr = explode(self::$delimit, $key);
        $maxIndex = count($keyArr) - 1;
        $node = new \stdClass();
        $nextNode = $node;
        foreach ($keyArr as $index=>$key) {
            if($index == $maxIndex) {
                $nextNode->$key = $value;
            } else {
                $nextNode->$key = new \stdClass();
                $nextNode = $nextNode->$key;
            }
        }
        $tmp = self::object2Array($node);
        self::$config = self::array_overlay(self::$config, $tmp);
    }


    private static function object2Array($object){
        if($object instanceof \stdClass) {
            $object = (array)$object;
        }
        if(!is_array($object)) {
            return $object;
        }
        foreach ($object as &$v) {
            if($v instanceof \stdClass) {
                $v = self::object2Array($v);
            }
        }
        return $object;
    }

    protected static function getFile($name) {
        $template = "%s/%s".static::$suffix;
        return sprintf($template, self::$configDir, $name);
    }

    /**
     * 合并两个数组
     * @param $a1
     * @param $a2
     * @param bool $end
     * @return mixed
     */
    protected static function array_overlay($a1,$a2, $end=true) {
        foreach ($a1 as $k => $v) {
            if (!array_key_exists($k, $a2)) continue;
            if (is_array($v) && is_array($a2[$k])) {
                $a1[$k] = self::array_overlay($v, $a2[$k], true);
            } else {
                $a1[$k] = $a2[$k];
            }
            unset($a2[$k]);
        }
        //把多的加上
        if($end) {
            $a1 = array_merge($a1, $a2);
        }
        return $a1;
    }

}