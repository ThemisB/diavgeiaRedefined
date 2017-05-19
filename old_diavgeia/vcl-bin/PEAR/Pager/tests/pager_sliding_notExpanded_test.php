<?php
// $Id: pager_sliding_notExpanded_test.php,v 1.2 2004/04/29 20:18:10 quipo Exp $

require_once 'simple_include.php';
require_once 'pager_include.php';

class TestOfPagerSlidingNotExpanded extends UnitTestCase {
    var $pager;
    function TestOfPagerSlidingNotExpanded($name='Test of Pager_Sliding - expanded=false') {
        $this->UnitTestCase($name);
    }
    function setUp() {
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21),
            'perPage'  => 2,
            'mode'     => 'Sliding',
            'expanded' => false
        );
        $this->pager = new Pager($options);
    }
    function tearDown() {
        unset($this->pager);
    }
    function testPageRangeByPageId1() {
        $this->assertEqual(array(1, 3), $this->pager->getPageRangeByPageId(1));
    }
    function testPageRangeByPageId2() {
        $this->assertEqual(array(1, 4), $this->pager->getPageRangeByPageId(2));
    }
    function testPageRangeByPageId3() {
        $this->assertEqual(array(1, 5), $this->pager->getPageRangeByPageId(3));
    }
    function testPageRangeByPageId4() {
        $this->assertEqual(array(2, 6), $this->pager->getPageRangeByPageId(4));
    }
    function testPageRangeByPageId9() {
        $this->assertEqual(array(7, 11), $this->pager->getPageRangeByPageId(9));
    }
    function testPageRangeByPageId10() {
        $this->assertEqual(array(8, 11), $this->pager->getPageRangeByPageId(10));
    }
    function testPageRangeByPageId11() {
        $this->assertEqual(array(9, 11), $this->pager->getPageRangeByPageId(11));
    }
    function testPageRangeByPageId_outOfRange() {
        $this->assertEqual(array(0, 0), $this->pager->getPageRangeByPageId(20));
    }
}
?>