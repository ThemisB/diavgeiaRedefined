<?php
// $Id: pager_test_xss.php,v 1.1 2005/07/04 08:08:46 quipo Exp $

//override url
$_SERVER['PHP_SELF'] = '">test';

require_once 'simple_include.php';
require_once 'pager_include.php';

class TestOfPagerXSS extends UnitTestCase {
    var $pager;
    var $baseurl;
    function TestOfPagerXSS($name='Test of Pager - XSS attacks') {
        $this->UnitTestCase($name);
    }
    function setUp() {
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
        );
        $this->pager = Pager::factory($options);
        $this->baseurl = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
    }
    function tearDown() {
        unset($this->pager);
    }
    function testXSS() {
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'nextImg'  => '&raquo;'
        );
        $this->pager = Pager::factory($options);
        $expected = '&nbsp;<a href="./&quot;&gt;test?pageID=2" title="next page">&raquo;</a>&nbsp;';
        $this->assertEqual($expected, $this->pager->_getNextLink());
    }
}
if (!defined('TEST_RUNNING')) {
    define('TEST_RUNNING', true);
    $test = &new TestOfPagerXSS();
    $test->run(new HtmlReporter());
}
?>