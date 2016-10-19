<?php
/**
 * User: 周智超
 * Date: 2016/7/30
 * Time: 16:25
 */

namespace common;


class ClassId {
    public static function category_fill_full_path($class_id, $length = Constant::CATEGORY_LENGTH) {
        $class_id = trim($class_id).'';//trim
        if(strlen($class_id) == 0){
            return $class_id;
        }
        //补齐足够位
        if( strlen($class_id) < $length ) {
            $class_id = str_repeat('0', $length-strlen($class_id)).$class_id;
        }

        return $class_id;
    }
}