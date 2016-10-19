<?php
/**
 * User: 周智超
 * Date: 2016/7/9
 * Time: 11:17
 */

namespace config;


class Exception extends \common\exception\Base{
    protected $name = 'CONF';
    protected $flag = 10;
    const NO_DIR = 1;
    protected function getMessageByCode($code) {
        $message = null;
        switch ($code) {
            case self::NO_DIR:
                $message = 'dir not exist';
                break;
            default:
                break;
        }
        return $message;
    }
}