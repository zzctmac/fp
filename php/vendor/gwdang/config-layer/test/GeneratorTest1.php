<?php

/**
 * User: 周智超
 * Date: 2016/7/8
 * Time: 16:15
 */
class GeneratorTest1 extends PHPUnit_Framework_TestCase {
    public function testEnvAndExtend() {
        $this->assertEquals(\config\Factory::get('env.dev'), 0);
        $this->assertEquals(\config\Factory::get('tt.dp_64.host'), '192.168.1.179');
        \config\Factory::set('env.dev',1);
        $this->assertEquals(\config\Factory::get('env.dev'), 1);
        $this->assertEquals(\config\Factory::get('tt.dp_64.host'), 'kgwx');
    }

    public function testRead() {
        $this->assertEquals(\config\Factory::get('tt.price_trend.port'), 11904);
    }

    public function testWrite() {
        $this->assertEquals(\config\Factory::get('tt.price_trend.port'), 11904);
        \config\Factory::set('tt.price_trend.port', 11903);
        $this->assertEquals(\config\Factory::get('tt.price_trend.port'), 11903);
    }
    public function testArr() {
        $count = count(\config\Factory::get('tt', 'taobao_api'));
        $this->assertEquals($count, 2);
        $this->assertEquals(\config\Factory::get('tt', 'taobao_api', 0), '23298914,862648c9bb8584ad0539fe41619d8369');
    }
}
