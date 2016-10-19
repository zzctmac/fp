<?php
/**
 * User: 周智超
 * Date: 2016/8/31
 * Time: 18:41
 */

namespace common;


use config\Factory;

class Url {
    public static function isSelf($url, $domain = 'gwdang.com') {
        if(preg_match("/^http:\/\/(?:[a-z0-9]+.|)${domain}/", $url) > 0) {
            return true;
        }
        return false;
    }

    /**
     * 通过url得到site_id
     * @param string $url
     * @return int
     */
    public static function getSiteId($url) {
        $marks = Factory::get('site_mark');
        foreach ($marks as $k=>$v) {
            $son = explode(',', $v);
            foreach ($son as $s) {
                if(stripos($url, $s) !== false) {
                    return $k + 0;
                }
            }
        }
        return 0;
    }

    /**
     * 通过url列表得到site_id
     * @param array $urlList
     * @return array
     */
    public static function getSiteIdByGroup($urlList) {
        $res = array();
        foreach ($urlList as $url) {
            $res[$url] = static::getSiteId($url);
        }
        return $res;
    }
}