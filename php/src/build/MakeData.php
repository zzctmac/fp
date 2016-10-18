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
        $ks = array();
        foreach ($info as $k=>$v) {
            $va = explode(',', $v);
            $v = $va[0];
            $vt[] = $k. ':' . $v;
            if(!isset($va[1]) || $va[1] != 0)
                $ks[] = $k;
        }
        return array(
            'data'=>array('md'=>implode(",\n        ", $vt)),
            'other'=>array('m_p'=>$ks)
        );
    }
}