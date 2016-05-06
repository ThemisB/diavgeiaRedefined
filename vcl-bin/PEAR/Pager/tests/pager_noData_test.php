<?php
// $Id: pager_noData_test.php,v 1.2 2004/04/29 20:18:10 quipo Exp $

require_once 'simple_include.php';
require_once 'pager_include.php';

class TestOfPagerNoData extends UnitTestCase {
    var $pager;
    function TestOfPagerNoData($name='Test of Pager - no data') {
        $this->UnitTestCase($name);
    }
    function setUp() {
        $options = array(
            'totalItems' => 0,
            'perPage'    => 5,
            'mode'       => 'Sliding',
        );
        $this->pager = Pager::factory($options);
    }
    function tearDown() {
        unset($this->pager);
    }
    function testCurrentPageID () {
        $this->assertEqual(0, $this->pager->getCurrentPageID());
    }
    function testNextPageID () {
        $this->assertEqual(false, $this->pager->getNextPageID());
    }
    function testPrevPageID () {
        $this->assertEqual(false, $this->pager->getPreviousPageID());
    }
    function testNumItems () {
        $this->assertEqual(0, $this->pager->numItems());
    }
    function testNumPages () {
        $this->assertEqual(0, $this->pager->numPages());
    }
    function testFirstPage () {
        $this->assertEqual(true, $this->pager->isFirstPage());
    }
    function testLastPage () {
        $this->assertEqual(true, $this->pager->isLastPage());
    }
    function testLastPageComplete () {
        $this->assertEqual(true, $this->pager->isLastPageComplete());
    }
}
?>