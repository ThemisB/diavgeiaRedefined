<?php
// $Id: pager_post_test.php,v 1.1 2006/02/20 22:44:47 quipo Exp $

require_once 'simple_include.php';
require_once 'pager_include.php';

class TestOfPagerPOST extends WebTestCase {
    var $pager;
    var $baseurl;
    var $options = array();

    function TestOfPagerPOST($name='Test of Pager with httpMethod="POST"') {
        $this->WebTestCase($name);
    }
    function setUp() {
        $this->options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 1,
            'clearIfVoid' => false,
            'httpMethod' => 'POST',
        );
        //$this->pager = Pager::factory($this->options);
        $this->baseurl = 'http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
    }
    function tearDown() {
        unset($this->pager);
    }

    function testMultibyteEncoded() {
        $test_strings_encoded = array(
            'encoded1' => '&#27979;&#35797;',
            'encoded2' => '&#50504;&#45397;',
        );
		$loaded = $this->get($this->baseurl.'/multibyte_post.php');
        $this->assertTrue($loaded);
        $this->assertResponse(200);
        $this->assertTitle('Pager Test: page 1');
        $this->assertNoLink('1');
        $this->assertLink('2');
        $this->assertLink('Next >>');
        //$this->showSource();
        foreach ($test_strings_encoded as $name => $value) {
            $this->assertWantedPattern('/'.$name.'.*'.preg_quote(str_replace('&', '&amp;', $value)).'/Uims');
        }
    }

    function testMultibytePlain() {
        $test_strings_plain = array(
            'plain1' => '안녕',
            'plain2' => '더보기',
//            'plain3' => '이젠 전화도
//로 걸면 무료',
        );
		$loaded = $this->get($this->baseurl.'/multibyte_post.php');
        $this->assertTrue($loaded);
        $this->assertResponse(200);
        $this->assertTitle('Pager Test: page 1');
        $this->assertNoLink('1');
        $this->assertLink('2');
        $this->assertLink('Next >>');
        //$this->showSource();
        foreach ($test_strings_plain as $name => $value) {
            $this->assertWantedPattern('/'.$name.'.*'.preg_quote(urlencode($value)).'/Uims');
        }
    }
}
?>