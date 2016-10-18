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
        
        return $native->fetch('basic.js', $data);
    }
}