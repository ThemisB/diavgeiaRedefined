<?php
// $Id: pager_sliding_test.php,v 1.5 2005/04/01 13:05:23 quipo Exp $

require_once 'simple_include.php';
require_once 'pager_include.php';

class TestOfPagerSliding extends UnitTestCase {
    var $pager;
    function TestOfPagerSliding($name='Test of Pager_Sliding') {
        $this->UnitTestCase($name);
    }
    function setUp() {
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
            'perPage'  => 2,
            'mode'     => 'Sliding',
        );
        $this->pager = Pager::factory($options);
    }
    function tearDown() {
        unset($this->pager);
    }
    function testPageRangeByPageId1() {
        $this->assertEqual(array(1, 5), $this->pager->getPageRangeByPageId(1));
    }
    function testPageRangeByPageId4() {
        $this->assertEqual(array(2, 6), $this->pager->getPageRangeByPageId(4));
    }
    function testPageRangeByPageId_outOfRange() {
        $this->assertEqual(array(0, 0), $this->pager->getPageRangeByPageId(20));
    }
    function testPageRangeByPageId2() {
        $this->assertEqual(array(2, 6), $this->pager->getPageRangeByPageId(4));
    }
    function testGetPageData() {
        $this->assertEqual(array(0=>1, 1=>2), $this->pager->getPageData());
    }
    function testGetPageData2() {
        $this->assertEqual(array(2=>3, 3=>4), $this->pager->getPageData(2));
    }
    function testGetPageData_OutOfRange() {
        $this->assertEqual(false, $this->pager->getPageData(20));
    }
    function testClearIfVoid() {
        $this->assertTrue(strlen($this->pager->links) > 0);
        
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
            'perPage'  => 20,
            'mode'     => 'Sliding',
        );
        $this->pager = Pager::factory($options);
        $this->assertEqual('', $this->pager->links);
    }
}
?>