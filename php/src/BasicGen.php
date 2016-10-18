<?php
/**
 * User: 周智超
 * Date: 2016/10/18
 * Time: 16:15
 */

namespace fp;


use fp\build\Api;
use fp\build\BasicValidate;
use fp\build\BasicValidTip;
use fp\build\MakeData;
use fp\build\Owner;

class BasicGen implements IGen{

    public static function generate($input) {
        $native = Common::getNative();
        $data = array();
        $other = array();
        $builders = array(
            new Api(),new Owner(),new BasicValidate(), new BasicValidTip(), new MakeData()
        );
        foreach ($builders as $builder) {
            $info = $builder->to($input);
            $data = array_merge($data, $info['data']);
            $other = array_replace_recursive($other, $info['other']);
        }
        $v_p = $other['v_p'];
        $m_p = $other['m_p'];
        $p = array_values(array_unique(array_merge($v_p, $m_p)));
        $v_p_str = implode(',', $v_p);
        $m_p_str = implode(',', $m_p);
        $p_str = implode(',', $p);
        $temp = compact('v_p_str', 'm_p_str', 'p_str');
        $data = array_merge($data, $temp);
        
        return $native->fetch('basic.js', $data);
    }
}