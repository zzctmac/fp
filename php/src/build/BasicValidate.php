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
        $vaild_param = array();
        foreach($data['validate'] as $k=>$vl) {
            $temp = explode(',', $vl);
            $vaild_param[] = $temp[0];
            switch ($k){
                case 'tel':
                    $v[] = static::tel($vl);
                    break;
                default:
                    break;
            }
        }
        $d['validate'] = $v;
        $o['v_p'] = $vaild_param;
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