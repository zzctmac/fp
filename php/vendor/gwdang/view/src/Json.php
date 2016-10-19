<?php
/**
 * User: 周智超
 * Date: 2016/8/2
 * Time: 17:01
 */

namespace view;


class Json extends Base{

    protected function render($template, $data = null, $isAbsolute = false) {
        return json_encode($data);
    }
}