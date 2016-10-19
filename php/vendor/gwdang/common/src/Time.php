<?php
/**
 * User: 周智超
 * Date: 2016/7/27
 * Time: 15:35
 */

namespace common;


class Time {

    /**
     * 用PHP时间戳得到JS时间戳
     * @param int $time
     * @return int
     */
    public static function getJSTimeStamp($time) {
        return ($time + 8 * 3600) * 1000;
    }

    /**
     * @param null $time
     * @return string
     */
    public static function getDateTime($time = null) {
        if($time == null) {
            $time = time();
        }
        return date('Y-m-d H:i:s', $time);
    }
}