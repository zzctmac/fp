<?php
/**
 * User: 周智超
 * Date: 2016/10/18
 * Time: 16:57
 */

namespace fp\build;


class BasicValidTip implements IBase{

    public function to($data) {
        $tip = $data['vaildTip'];
        $vt = null;
        switch ($tip['type']) {
            case 'alert':
                $vt =  static::alert();
                break;
            default:
                break;
        }
        return array(
            'data'=>compact('vt'),
            'other'=>array()
        );
    }

    public static function alert() {
        return "alert(msg);";
    }
}