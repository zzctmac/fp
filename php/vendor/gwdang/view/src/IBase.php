<?php
/**
 * User: 周智超
 * Date: 2016/8/2
 * Time: 16:46
 */

namespace view;


interface IBase {
    public function display($template, $data = null);
    public function fetch($template, $data = null);
}