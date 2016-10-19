<?php
/**
 * User: 周智超
 * Date: 2016/7/9
 * Time: 11:07
 */

namespace config\ini;



class Exception extends \common\exception\Base{
    protected $name = 'INI';
    protected $flag = 11;
    const PARSE_ERROR = 1;
    const FILE_NOE_EXIST = 2;
    
    protected function getMessageByCode($code) {
        $message = null;
        switch ($code) {
            case self::PARSE_ERROR:
                $message = 'file has error';
                break;
            default:
                break;
        }
        return $message;
    }


}