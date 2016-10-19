<?php
/**
 * User: 周智超
 * Date: 2016/7/22
 * Time: 17:55
 */

namespace common;


class Encoding {

    /**
     * GBK 字符串截取
     * @param $string
     * @param $length
     * @param int $is_htmlspecialchars
     * @param string $end_with
     * @return string
     */
    public static function gbk_substr_ifneed($string, $length, $is_htmlspecialchars=0, $end_with='<span class="dot">...</span>')
    {
        if(is_array($string)) {
            return $string;
        }
        $new_str = $string;
        if( strlen($string) > $length ){
            $re_gbk = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            preg_match_all($re_gbk, $string, $match);
            $new_str = "";
            $now_length = 0;
            $max_length = $length - strlen(strip_tags($end_with));
            //$max_length = $length - 3;
            foreach($match[0] as $char){
                $now_length += strlen($char);//英文字符长度，汉字算两个
                if( $now_length>$max_length ){
                    break;
                }
                $new_str .= $char;
            }
        }
        if( $is_htmlspecialchars ) {
            $new_str = htmlspecialchars($new_str);
        }
        if( strlen($string) > $length ){
            $new_str .= $end_with;
        }
        return $new_str;
    }
    
    /**
     * 判断字符串是否是utf8编码
     *
     * 主要使用mb_detect_encoding 和  iconv 结合，判断不一定百分百准确。
     *
     * @param string $word 要判断的字符串
     *
     * @return bool
     */
    public static function is_utf8($word){
        if(mb_detect_encoding($word) === 'UTF-8') return true;
        else if ($word === iconv('UTF-8', 'UTF-8//IGNORE', $word)) return true;
        else return false;
    }

    /**
     * 编码转换，支持数组，数组会递归转换
     *
     * Encoding::siconv('GBK','UTF-8',"测试")
     *
     * @param string $in_charset 转换前的编码
     * @param string $out_charset 转换后的编码
     * @param string $var 要转换的字符串
     *
     * @return array|string
     */
    private static function siconv($in_charset, $out_charset, $var) {
        if (is_array($var)) {
            foreach ($var as $key => $val) {
                $var[self::siconv($in_charset, $out_charset, $key)] = self::siconv($in_charset, $out_charset, $val);
            }
        } else {
            if (is_string($var)) {
                $var = iconv($in_charset, $out_charset, $var);
            }
        }
        return $var;
    }

    /**
     * gbk转换成utf8
     *
     * 内部使用Encoding::siconv 支持数组，递归去转换。
     *
     * @param array|string $s 数组会递归去转换
     *
     * @return array|string
     */
    public static function gbk2utf8($s){
        return self::siconv("GBK", "UTF-8//IGNORE", $s);
    }

    /**
     * utf8转换成gbk
     *
     * 内部使用Encoding::siconv 支持数组，递归去转换。
     *
     * @param array|string $s 数组会递归去转换
     *
     * @return array|string
     */
    public static function utf82gbk($s){
        return self::siconv("UTF-8", "GBK//IGNORE", $s);
    }

    /**
     * unicode转换成utf8
     *
     * 通常用于弥补PHP5.3 json_encode 没有 unescape_unicode的问题
     *
     * @param string $encoded 要转换的字符，通常是json_encode后的结果
     **/
    public static function unicode2utf8($encoded){
        return preg_replace_callback(
            '/\\\\u([0-9a-f]{4})/i',
            function ($matches) {
                $sym = mb_convert_encoding(
                    pack('H*', $matches[1]),
                    'UTF-8',
                    'UTF-16'
                );
                return $sym;
            },
            $encoded
        );
    }

    /**
     * 得到首字母
     * @param $input
     * @param bool $isUtf8
     * @return int|string
     */
    public static function getLetter($input, $isUtf8 = true) {
        if($isUtf8) {
            $input = Encoding::utf82gbk($input);
        }
        static $specialWords = array(
            '橄'=>'g',
            '沐'=>'m',
            '炖'=>'d',
            '踝'=>'h',
            '霉'=>'m',
            '沱'=>'t',
            '泸'=>'l',
            '魅'=>'m'
        );
        $str_ch = mb_substr($input, 0, 1, 'GBK');
        if(array_key_exists($str_ch, $specialWords)) {
            return $specialWords[$str_ch];
        }
        static $dict=array(
            'a'=>0xB0C4,
            'b'=>0xB2C0,
            'c'=>0xB4ED,
            'd'=>0xB6E9,
            'e'=>0xB7A1,
            'f'=>0xB8C0,
            'g'=>0xB9FD,
            'h'=>0xBBF6,
            'j'=>0xBFA5,
            'k'=>0xC0AB,
            'l'=>0xC2E7,
            'm'=>0xC4C2,
            'n'=>0xC5B5,
            'o'=>0xC5BD,
            'p'=>0xC6D9,
            'q'=>0xC8BA,
            'r'=>0xC8F5,
            's'=>0xCBF9,
            't'=>0xCDD9,
            'w'=>0xCEF3,
            'x'=>0xD188,
            'y'=>0xD4D0,
            'z'=>0xD7F9,
        );
        $str_1 = substr($input, 0, 1);
        if ($str_1 >= chr(0x81) && $str_1 <= chr(0xfe)) {
            $num = hexdec(bin2hex(substr($input, 0, 2)));
            foreach ($dict as $k=>$v){
                if($v>=$num)
                    break;
            }
            return $k;
        }
        else{
            return $str_1;
        }
    }
}