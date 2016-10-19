<?php
/**
 * User: 周智超
 * Date: 2016/7/8
 * Time: 16:12
 */

namespace config\ini;


use config\Base;

class Generator extends Base{
    
    public static $suffix = '.ini';
    
    public static function loadConfig() {
        self::$config = array();
        $tmp = array(
            'dev'=>0
        );
        static::set('env', $tmp);
    }

    const DELIMIT = '.';

    /**
     * 根据.操作符转换
     * @param $data
     * @return mixed
     */
    protected static function delimitToArr($data) {
        foreach ($data as $key=>$value) {
            if(is_array($value)) {
                $data[$key] = self::delimitToArr($value);
            }
            $tryKey = explode(self::DELIMIT, $key);
            if(count($tryKey) > 1) {
                $fKey = array_shift($tryKey);
                if(!array_key_exists($fKey, $data)) {
                    $data[$fKey] = array();
                }
                $nextKey = implode(self::DELIMIT, $tryKey);
                $tmpArr = array($nextKey=>$value);
                $tmpRes = self::delimitToArr($tmpArr);
                $data[$fKey] = array_replace_recursive($data[$fKey], $tmpRes);
                unset($data[$key]);
            }

        }
        return $data;
    }
    
    /**
     * 完成继承功能
     * @param $data
     * @return mixed
     */
    protected static function extendArr($data) {
        $extendDelimit = ':';
        foreach ($data as $key=>$value) {
            $tryKey = explode($extendDelimit, $key);
            if(count($tryKey) != 2) {
                continue;
            }
            list($son,$parent) =  $tryKey;
            if(!array_key_exists($parent, $data)) {
                continue;
            }
            $value = self::array_overlay($data[$parent], $value);
            $data[$son] = $value;
            unset($data[$key]);
        }
        return $data;
    }

    /**
     * 处理ini数据：.表达式解析 继承功能
     * @param $data
     * @return mixed
     */
    public static function handleIni($data) {
        if(static::$PARSE_DOT == true) {
            $data = self::delimitToArr($data);
        }
        $data = self::extendArr($data);
        return $data;
    }
    
    public static function loadIni($name) {
        static $loadIni = array();
        if(!in_array($name, $loadIni)) {
            $fileName = self::getFile($name);
            if(!is_file($fileName)) {
                throw new Exception("file not exist \"" . $fileName . "\" ", Exception::FILE_NOE_EXIST);
            }
            $iniData = parse_ini_file($fileName, true);
            $iniData = self::handleIni($iniData);
            parent::set($name, $iniData);
            $loadIni[] = $name;
        }
    }
    
    protected static function getEnvKey($key) {
        $defaultDev = 0;
        $dev = parent::get('env.dev');
        if(null === $dev) {
            $dev = $defaultDev;
        }
        $section = $dev == 1 ? 'dev':'product';
        $tryKey = explode(self::$delimit, $key);
        $k1 = array_shift($tryKey);
        array_unshift($tryKey, $section);
        array_unshift($tryKey, $k1);
        return implode(self::$delimit, $tryKey);
    }
    
    /**
     * 约定:key第一个为文件名
     * @param $key
     * @return null|array|...
     */
    public static function get($key) {
        do {
            if('*' === $key) {
                break;
            }
            if(func_num_args() > 1) {
                $key = implode(static::$delimit, func_get_args());
            }
            $tryKey = explode(self::$delimit, $key);
            if($tryKey[0] === 'env') {
                break;
            }
            self::loadIni($tryKey[0]);
            $envKey = self::getEnvKey($key);
            $envValue = parent::get($envKey);
            if (null !== $envValue) {
                return $envValue;
            }
        }while(false);
        return parent::get($key); 
    }

    public static function set($key, $value) {
        do {
            $tryKey = explode(self::$delimit, $key);
            if ($tryKey[0] === 'env') {
                parent::set($key, $value);
                return;
            }
            self::loadIni($tryKey[0]);
        }while(false);
        $envKey = self::getEnvKey($key);
        if(parent::has($envKey)) {
            parent::set($envKey, $value);
        }
        parent::set($key, $value); 
    }


}