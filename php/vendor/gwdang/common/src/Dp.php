<?php
/**
 * User: 周智超
 * Date: 2016/7/15
 * Time: 10:49
 */

namespace common;


class Dp {
    const DP_DELIMIT = '-';
    const TAOBAO_SITE_ID = 83;

    /**
     * 解析一个dp
     * @param $dp_id
     * @return array
     */
    public static function parse($dp_id) {
        $dp_id_arr = explode(static::DP_DELIMIT, $dp_id);
        if(count($dp_id_arr) == 1) {
            $res =  array($dp_id, static::TAOBAO_SITE_ID);
        } else {
            $site_id = array_pop($dp_id_arr);
            $url_crc = implode(static::DP_DELIMIT, $dp_id_arr);
            $res = array($url_crc, $site_id + 0);
        }
        return $res;
    }

    /**
     * 判断是否为淘宝或天猫
     * @param $dp_id
     * @return bool
     */
    public static function isTb($dp_id) {
        $res = static::parse($dp_id);
        if(in_array($res[1], array(83, 123))) {
            return true;
        }
        return false;
    }
    
    public static function formatTb($dp_id) {
        if(is_array($dp_id)) {
            foreach ($dp_id as &$dp) {
                $dp = static::formatTb($dp);
            }
            unset($dp);
            return $dp_id;
        }
        $res = static::parse($dp_id);
        if(in_array($res[1], array(83, 123))) {
            return $res[0] . '-83';
        }
        return $dp_id;
    }
    
    public static function equal($dp1, $dp2) {
        list($crc1, $site_id1) = Dp::parse($dp1);
        list($crc2, $site_id2) = Dp::parse($dp2);
        if($crc1 != $crc2) {
            return false;
        }
        if($site_id1 == $site_id2) {
            return true;
        }
        if($site_id1 > $site_id2) {
            return $site_id1 % 1000 == $site_id2;
        }
        if($site_id1 < $site_id2) {
            return $site_id2 % 1000 == $site_id1;
        }
    }
}