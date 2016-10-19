<?php
/**
 * User: 周智超
 * Date: 2016/10/18
 * Time: 16:09
 */

include './vendor/autoload.php';

\config\Factory::init('./conf');


$name = $argv[1];

$data = \config\Factory::get($name);


switch ($data['type']) {
    case 'basic':
        $content = \fp\BasicGen::generate($data);
        break;
    case 'vl':
        break;
    default:
        exit;
        break;
}

file_put_contents("./output/$name.js", $content);