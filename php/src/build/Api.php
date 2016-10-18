<?php
/**
 * User: 周智超
 * Date: 2016/10/18
 * Time: 16:26
 */

namespace fp\build;


class Api implements IBase{

    public function to($data) {
        return array(
            'data'=>array(
                'api'=>$data['api']
            ),
            'other'=>array()
        );
    }
}