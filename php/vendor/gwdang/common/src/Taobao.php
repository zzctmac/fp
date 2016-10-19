<?php
/**
 * User: 周智超
 * Date: 2016/9/7
 * Time: 10:46
 */

namespace common;


use config\Factory;

class Taobao {
    /**
     * 获得淘宝客接口
     * @return array {key:'xxx', secret:'xxxx'}
     */
    public static function getTaobaoKey() {
        static $keys = null;
        if($keys == null) {
            $keys = Factory::get('taobao.key');
        }
        $key =  $keys[mt_rand(0, count($keys) - 1)];
        $key = explode(',', $key);
        $map = array('key', 'secret');
        return array_combine($map, $key);
    }
}