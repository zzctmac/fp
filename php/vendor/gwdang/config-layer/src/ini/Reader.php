<?php
/**
 * User: 周智超
 * Date: 2016/9/7
 * Time: 14:13
 */

namespace config\ini;


class Reader {
    protected static $delimit = '.';
    protected $path;
    protected $data;

    /**
     * Reader constructor.
     * @param $path
     */
    public function __construct($path) {
        $this->path = $path;
        $this->loadIni();
    }

    /**
     * @param mixed $path
     */
    public function setPath($path) {
        $this->path = $path;
    }

    public  function loadIni() {
            if(!is_file($this->path)) {
                throw new Exception("file not exist \"" . $this->path . "\" ", Exception::FILE_NOE_EXIST);
            }
            $iniData = parse_ini_file($this->path, true);
            $iniData = Generator::handleIni($iniData);
            $this->data = $iniData;
    }

    public function get($key) {
        if('*' === $key) {
            return $this->data;
        }
        if(func_num_args() > 1) {
            $key = implode(static::$delimit, func_get_args());
        }
        return Generator::getByStep($key, $this->data);
    }
}