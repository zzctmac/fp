<?php
/**
 * User: 周智超
 * Date: 2016/10/18
 * Time: 17:16
 */

namespace fp\build;


class MakeData implements IBase{

    public function to($data) {
        $info = $data['makeData'];
        $vt = array();
        foreach ($info as $k=>$v) {
            $vt[] = $k. ':' . $v;
        }
        return array(
            'data'=>array('md'=>implode(",\n        ", $vt)),
            'other'=>array()
        );
    }
}