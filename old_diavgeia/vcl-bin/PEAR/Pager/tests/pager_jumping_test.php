<?php
// $Id: pager_jumping_test.php,v 1.4 2004/05/11 09:14:22 quipo Exp $

require_once 'simple_include.php';
require_once 'pager_include.php';

class TestOfPagerJumping extends UnitTestCase {
    var $pager;
    function TestOfPagerJumping($name='Test of Pager_Jumping') {
        $this->UnitTestCase($name);
    }
    function setUp() {
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
            'perPage'  => 5,
            'mode'     => 'Jumping',
            'delta'    => 2
        );
        $this->pager = Pager::factory($options);
    }
    function tearDown() {
        unset($this->pager);
    }
    function testPageIdByOffset1() {
        $this->assertEqual(1, $this->pager->getPageIdByOffset(1));
    }
    function testPageIdByOffset5() {
        $this->assertEqual(1, $this->pager->getPageIdByOffset(5));
    }
    function testPageIdByOffset6() {
        $this->assertEqual(2, $this->pager->getPageIdByOffset(6));
    }
    function testPageRangeByPageId1() {
        $this->assertEqual(array(1, 2), $this->pager->getPageRangeByPageId(1));
    }
    function testPageRangeByPageId2() {
        $this->assertEqual(array(1, 2), $this->pager->getPageRangeByPageId(2));
    }
    function testPageRangeByPageId3() {
        $this->assertEqual(array(3, 3), $this->pager->getPageRangeByPageId(3));
    }
    function testPageRangeByPageId_outOfRange() {
        $this->assertEqual(array(0, 0), $this->pager->getPageRangeByPageId(20));
    }
    function testGetPageData() {
        $this->assertEqual(array(0=>1, 1=>2, 2=>3, 3=>4, 4=>5), $this->pager->getPageData());
    }
    function testGetPageData2() {
        $this->assertEqual(array(5=>6, 6=>7, 7=>8, 8=>9, 9=>10), $this->pager->getPageData(2));
    }
    function testGetPageData_OutOfRange() {
        $this->assertEqual(false, $this->pager->getPageData(4));
    }
    /**
     * Returns offsets for given pageID. Eg, if you pass pageID=5 and your
     * delta is 2, it will return 3 and 7. A pageID of 6 would give you 4 and 8
     * If the method is called without parameter, pageID is set to currentPage#.
     *
     * Given a PageId, it returns the limits of the range of pages displayed.
     * While getOffsetByPageId() returns the offset of the data within the current
     * page, this method returns the offsets of the page numbers interval.
     * E.g., if you have perPage=10 and pageId=3, it will return you 1 and 10.
     * PageID of 8 would give you 1 and 10 as well, because 1 <= 8 <= 10.
     * PageID of 11 would give you 11 and 20.
     *
     * @param pageID PageID to get offsets for
     * @return array  First and last offsets
     * @access public
     */
    /**
     * Given a PageId, it returns the limits of the range of pages displayed.
     * While getOffsetByPageId() returns the offset of the data within the
     * current page, this method returns the offsets of the page numbers interval.
     * E.g., if you have perPage=10 and pageId=3, it will return you 1 and 10.
     * PageID of 8 would give you 1 and 10 as well, because 1 <= 8 <= 10.
     * PageID of 11 would give you 11 and 20.
     *
     * @param pageID PageID to get offsets for
     * @return array  First and last offsets
     * @access public
     */
}
?>