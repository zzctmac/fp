<?php
/**
 * User: 周智超
 * Date: 2016/7/15
 * Time: 14:21
 */

namespace common;


class Identity {
    public static function getHash($str) {
        return hash("sha256", $str);
    }
}