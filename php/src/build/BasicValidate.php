<?php
/**
 * User: 周智超
 * Date: 2016/10/18
 * Time: 16:46
 */

namespace fp\build;


class BasicValidate implements IBase{

    public function to($data) {
        $d = array();
        $o = array();
        $v = array();
        foreach($data['validate'] as $k=>$vl) {
            switch ($k){
                case 'tel':
                    $v[] = static::tel($vl);
                    break;
                default:
                    break;
            }
        }
        $d['validate'] = $v;
        return array(
            'data'=>$d,
            'other'=>$o
        );
    }

    private static function tel($v) {
        return static::easy($v, '手机号不合法', 'isTel', 0);
    }

    private static function easy($v, $defaultTip, $func, $isTrue = 1) {
        $v = explode(',', $v);
        if(count($v) == 1) {
            $v[1] = $defaultTip;
        }
        if(!$isTrue) {
            $func = '!' . $func;
        }

        return "if(${func}(${v[0]})) {res = '${v[1]}'; break;}";
    }
}