<?php
/**
 * User: 周智超
 * Date: 2016/7/22
 * Time: 15:12
 */

namespace common;


class Xml {
    /**
     * 获取XML文档,返回simplexml object
     *
     * @param string $xml_str
     * @param string $encode 字符编码
     * @param boolean $halt 错误是否停止程序
     *
     * @return \SimpleXMLElement
     */
    public static function simplexml_load_string_to_xmlobj($xml_str, $encode = 'GBK', $halt = true)
    {
        preg_match("/(^<\?xml[^\?]+\?>)/", $xml_str, $matches);
        $xml_head = $matches[1];
        $xml_head = preg_replace("/(?:GB2312|utf-8)/", "GBK", $xml_head);
        $xml_str = preg_replace("/(^<\?xml[^\?]+\?>)/", $xml_head, $xml_str);

        //过滤掉错误字符,防止xml解析错误
        if (!in_array($encode, array('gbk', 'GBK'))) {
            $xml_str = iconv($encode, $encode . '//IGNORE', $xml_str);
        }

        //过滤W3C XML规范外的字符
        $xml_str = str_replace(
            array("\x00", "\x01", "\x02", "\x03", "\x04", "\x05", "\x06", "\x07", "\x08",
                "\x0b", "\x0c",
                "\x0e", "\x0f", "\x10", "\x11", "\x12", "\x13", "\x14", "\x15", "\x16", "\x17", "\x18", "\x19", "\x1a", "\x1b", "\x1c", "\x1d", "\x1e", "\x1f",
            ), "", $xml_str);
        if (($xmlobj = simplexml_load_string($xml_str, 'SimpleXMLElement', LIBXML_NOCDATA)) === FALSE) {
            if ($halt) {
                $e = libxml_get_last_error();
                return false;
                //echo 'xml load error: '.$e->message;
                //exit;
            } else {
                return false;
            }
        }
        return $xmlobj;
    }

    /**
     * xml字符串转换为数组
     *
     *
     * @param string $xml xml字符串
     *
     * @return \SimpleXMLElement
     */

    public static function xml2array($xml)
    {
        $r = self::simplexml_load_string_to_xmlobj($xml);
        $r = json_encode($r);
        $r = json_decode($r, true);
        return $r;
    }


    /**
     * 解析TT Server中单品信息
     * @param string $xml_str
     * @return array|bool
     */
    public static function dp_parse_tt_xml($xml_str)
    {
        $pattern = "/<([^>\/]*?)>[\s\S]*?<\/\\1>/";
        $matches = array();

        //preg match
        preg_match_all($pattern, $xml_str, $matches);

        $dp_arr = array();
        foreach ($matches[0] as $key => $val) {
            $val = trim($val);
            $need_decode = true;

            //<v_key>
            $v_key = $matches[1][$key];
            $val = substr($val, strlen($v_key) + 2, strlen($val) - strlen($v_key) * 2 - 5);//去掉<v_key> & </v_key>

            //<![CDATA[
            if ($val && substr($val, 0, 9) == '<![CDATA[') {
                $val = substr($val, 9);
                //]]>
                if ($val && substr($val, -3) == ']]>') {
                    $val = substr($val, 0, strlen($val) - 3);
                }
                $need_decode = false;
            }
            $need_decode && $val = html_entity_decode($val);
            $dp_arr[$matches[1][$key]] = trim($val);
        }
        if (empty($dp_arr)) {
            return false;
        }

        return $dp_arr;
    }
    /**
     * convert simplexml object to array sets
     * $array_tags 表示需要转为数组的 xml 标签。例：array('item', '')
     * 出错返回False
     *
     * @param object $simplexml_obj
     * @param array $array_tags
     * @param int $strip_white 是否清除左右空格
     * @return mixed
     */
    public static function simplexml_to_array($simplexml_obj, $array_tags=array(), $strip_white=1)
    {
        if( $simplexml_obj !== null)
        {
            if( count($simplexml_obj)==0 ) {
                if( $strip_white) {
                    return trim((string)$simplexml_obj);
                }  else {
                    return (string)$simplexml_obj;
                }

            }

            $attr = array();
            foreach ($simplexml_obj as $k=>$val) {
                if( !empty($array_tags) && in_array($k, $array_tags) ) {
                    $attr[$k][] = self::simplexml_to_array($val, $array_tags, $strip_white);
                }else{
                    $attr[$k] = self::simplexml_to_array($val, $array_tags, $strip_white);
                }
            }
            return $attr;
        }

        return FALSE;
    }
}