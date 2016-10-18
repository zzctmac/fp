<?php
/**
 * User: 周智超
 * Date: 2016/10/18
 * Time: 16:35
 */

namespace fp\build;


class Owner implements IBase{

    public function to($data) {
        return array(
            'data'=>array('owner'=>'ZZC', 'date'=>date("Y/m/d"), 'name'=>$data['name']),
            'other'=>array()
        );
    }
}