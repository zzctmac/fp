<?php

/**
 * User: 周智超
 * Date: 2016/7/15
 * Time: 14:23
 */
class A extends \common\Identity{

    public $a ;
    protected function getString() {
        return $this->a;
    }
}
class Id extends PHPUnit_Framework_TestCase {
    public function testId() {
        $a1 = new A();
        $a1->a = '1212';
        $a2 = new A();
        $a2->a = '12123';
        $this->assertEquals($a1->getHash(), $a2->getHash());
    }
}
