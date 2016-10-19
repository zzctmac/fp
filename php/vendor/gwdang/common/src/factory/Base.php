<?php
/**
 * User: 周智超
 * Date: 2016/7/8
 * Time: 14:15
 */

namespace common\factory;


abstract class Base implements IBase{
    protected static $ins;
    public static function provide() {
        return self::$ins;
    }

    public static function getInstance() {
        return static::provide();
    }


}