<?php
/**
 * User: 周智超
 * Date: 2016/10/19
 * Time: 15:03
 */

namespace fp\build;


use config\Factory;

class Vl implements IBase{

    public function to($data) {
        $base = Factory::get('vl');
        $rules = array();
        $messages = array();
        $vl = $data['vl'];
        foreach ($vl as $v) {
            if(!array_key_exists($v, $base)) {
                continue;
            }
            $info = $base[$v];
            if(array_key_exists($v, $rules)) {
                continue;
            }
            $rules[$v] = $info['rules'];
            $messages[$v] = $info['messages'];
        }
        $rules =  json_encode($rules);
        $rules = str_replace('"', '', $rules);
        $messages = str_replace(array('{"', "\":", ",\""), array('{', ':', ","), json_encode($messages,  JSON_UNESCAPED_UNICODE));
        return array(
            'data'=>compact('rules', 'messages'),
            'other'=>array()
        );
    }
}