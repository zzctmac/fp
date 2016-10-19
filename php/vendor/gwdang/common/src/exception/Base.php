<?php

/**
 * User: 周智超
 * Date: 2016/7/9
 * Time: 10:27
 */

namespace common\exception;

class Base extends \Exception{
    protected $flag = 0;
    protected $name = 'Base';
    protected $type;
    const NORMAL_TYPE = 1;
    const HALT_TYPE = 2;
    
    protected function getMessageByCode($code) {
        return null;
    } 
    
    /**
     * Base constructor.
     * @param string $message
     * @param int $code
     * @param null $previous
     */
    public function __construct($message = "" , $code = 0 , $previous = NULL ) {
        if(is_int($message)) {
            $code = $message;
            $message = $this->getMessageByCode($message);
        }
        $code = $this->setCode($code);
        parent::__construct($message, $code, $previous);
    }

    public function setCode($code) {
        return $this->flag * 1000 + $code;
    }
    public function __toString() {
        $template ="Exception[%s]:[%s_%s] in File %s Line %s";
        return sprintf($template, $this->name, $this->getCode(),$this->getMessage(), $this->getFile(), $this->getLine());
    }



}