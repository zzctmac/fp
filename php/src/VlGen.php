<?php
/**
 * User: 周智超
 * Date: 2016/10/19
 * Time: 14:39
 */

namespace fp;


use fp\build\Api;
use fp\build\Owner;
use fp\build\Vl;

class VlGen implements IGen{

    public static function generate($input) {
        $native = Common::getNative();
        $data = array();
        $other = array();
        $builders = array(
            new Api(),new Owner(), new Vl()
        );
        foreach ($builders as $builder) {
            $info = $builder->to($input);
            $data = array_merge($data, $info['data']);
            $other = array_replace_recursive($other, $info['other']);
        }
        return $native->fetch('va.tpl', $data);
    }
}