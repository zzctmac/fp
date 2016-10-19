<?php
/**
 * User: 周智超
 * Date: 2016/7/8
 * Time: 14:27
 */

namespace common\singleton;


abstract class Base implements IBase{
    public static function getInstance() {
        static $object ;
        if(null === $object) {
            $object = static::getObject();
        }
        return $object;
    }
}