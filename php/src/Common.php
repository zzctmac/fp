<?php
/**
 * User: 周智超
 * Date: 2016/10/18
 * Time: 16:19
 */

namespace fp;


use view\Native;

class Common {
    public static function getNative() {
        return new Native('./tpl', '.js');
    }
}