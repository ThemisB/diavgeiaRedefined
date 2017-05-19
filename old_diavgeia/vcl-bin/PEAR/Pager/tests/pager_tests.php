<?php
// $Id: pager_tests.php,v 1.1 2003/11/30 17:30:01 quipo Exp $

require_once 'simple_include.php';
require_once 'pager_include.php';

class PagerTests extends GroupTest {
    function PagerTests() {
        $this->GroupTest('Pager Tests');
        $this->addTestFile('pager_test.php');
        $this->addTestFile('pager_noData_test.php');
    }
}

if (!defined('TEST_RUNNING')) {
    define('TEST_RUNNING', true);
    $test = &new PagerTests();
    $test->run(new HtmlReporter());
}
?>