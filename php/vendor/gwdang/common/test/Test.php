<?php

/**
 * User: 周智超
 * Date: 2016/7/15
 * Time: 10:52
 */
class Test extends PHPUnit_Framework_TestCase {
    public function testTbDp() {
        $dp_id = '12121221';
        $this->assertEquals(array($dp_id, 83), \common\Dp::parse($dp_id));
    }

    public function testAmDp() {
        $dp_id = '-121212121-1';
        $this->assertEquals(array('-121212121', 1), \common\Dp::parse($dp_id));
    }

    public function testNomalDp() {
        $dp_id = '121212-3';
        $this->assertEquals(array('121212', 3), \common\Dp::parse($dp_id));
    }

    public function testTb1() {
        $dp_id = '1212121';
        $this->assertEquals(\common\Dp::isTb($dp_id), true);
        $dp_id = '1212121-83';
        $this->assertEquals(\common\Dp::isTb($dp_id), true);
        $dp_id = '1212121-123';
        $this->assertEquals(\common\Dp::isTb($dp_id), true);
        $dp_id = '1212121-3';
        $this->assertEquals(\common\Dp::isTb($dp_id), false);
    }

    public function testTb2() {
        $arr = array(
            '1212-31',
            '1212121',
            '121212121-3',
            '1212121-123'
        );
        $o = array(
            '1212-31',
            '1212121-83',
            '121212121-3',
            '1212121-83'
        );
        $this->assertEquals(\common\Dp::formatTb($arr), $o);
    }

    public function testTb3() {
        $this->assertEquals(\common\Dp::formatTb('12121'), '12121-83');
    }

    public  function testEqual() {
        $this->assertEquals(true, \common\Dp::equal('121-1003', '121-3'));
    }

    public function testUrl() {
        $this->assertEquals(true, \common\Url::isSelf('http://www.gwdang.com'));
    }
}
