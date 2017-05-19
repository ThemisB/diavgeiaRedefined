<?php
// $Id: pager_test.php,v 1.24 2006/11/24 13:53:36 quipo Exp $

require_once 'simple_include.php';
require_once 'pager_include.php';

class TestOfPager extends UnitTestCase {
    var $pager;
    var $baseurl;
    function TestOfPager($name='Test of Pager') {
        $this->UnitTestCase($name);
    }
    function setUp() {
        $options = array(
            'itemData' => range(1, 10),
            'perPage'  => 5,
        );
        $this->pager = Pager::factory($options);
        $this->baseurl = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
    }
    function tearDown() {
        unset($this->pager);
    }
    function testCurrentPageID () {
        $this->assertEqual(1, $this->pager->getCurrentPageID());
    }
    function testNextPageID () {
        $this->assertEqual(2, $this->pager->getNextPageID());
    }
    function testPrevPageID () {
        $this->assertEqual(false, $this->pager->getPreviousPageID());
    }
    function testNumItems () {
        $this->assertEqual(10, $this->pager->numItems());
    }
    function testNumPages () {
        $this->assertEqual(2, $this->pager->numPages());
    }
    function testFirstPage () {
        $this->assertEqual(true, $this->pager->isFirstPage());
    }
    function testLastPage () {
        $this->assertEqual(false, $this->pager->isLastPage());
    }
    function testLastPageComplete () {
        $this->assertEqual(true, $this->pager->isLastPageComplete());
    }
    function testOffsetByPageId() {
        $this->assertEqual(array(1, 5), $this->pager->getOffsetByPageId(1));
        $this->assertEqual(array(6, 10), $this->pager->getOffsetByPageId(2));
    }
    function testOffsetByPageId_outOfRange() {
        $this->assertEqual(array(0, 0), $this->pager->getOffsetByPageId(20));
    }
    function testGetPageData() {
        $this->assertEqual(array(0=>1, 1=>2, 2=>3, 3=>4, 4=>5), $this->pager->getPageData());
        $this->assertEqual(array(5=>6, 6=>7, 7=>8, 8=>9, 9=>10), $this->pager->getPageData(2));
    }
    function testGetPageData_OutOfRange() {
        $this->assertEqual(array(), $this->pager->getPageData(3));
    }
    function testSelectBox() {
        $selectBox  = '<select name="'.$this->pager->_sessionVar.'">';
        $selectBox .= '<option value="5" selected="selected">5</option>';
        $selectBox .= '<option value="10">10</option>';
        $selectBox .= '<option value="15">15</option>';
        $selectBox .= '</select>';
        $this->assertEqual($selectBox, $this->pager->getPerPageSelectBox(5, 15, 5));
    }
    function testSelectBoxWithString() {
        $selectBox  = '<select name="'.$this->pager->_sessionVar.'">';
        $selectBox .= '<option value="5" selected="selected">5 bugs</option>';
        $selectBox .= '<option value="10">10 bugs</option>';
        $selectBox .= '<option value="15">15 bugs</option>';
        $selectBox .= '</select>';
        $this->assertEqual($selectBox, $this->pager->getPerPageSelectBox(5, 15, 5, false, '%d bugs'));
    }
    function testSelectBoxWithShowAll() {
        $selectBox  = '<select name="'.$this->pager->_sessionVar.'">';
        $selectBox .= '<option value="3">3</option>';
        $selectBox .= '<option value="4">4</option>';
        $selectBox .= '<option value="5" selected="selected">5</option>';
        $selectBox .= '<option value="6">6</option>';
        $selectBox .= '<option value="10">10</option>';
        $selectBox .= '</select>';
        $this->assertEqual($selectBox, $this->pager->getPerPageSelectBox(3, 6, 1, true));
    }
    function testSelectBoxWithShowAllAndText() {
        $this->pager->_showAllText = 'Show All';
        $selectBox  = '<select name="'.$this->pager->_sessionVar.'">';
        $selectBox .= '<option value="3">3 bugs</option>';
        $selectBox .= '<option value="4">4 bugs</option>';
        $selectBox .= '<option value="5" selected="selected">5 bugs</option>';
        $selectBox .= '<option value="6">6 bugs</option>';
        $selectBox .= '<option value="'.max($this->pager->_itemData).'">Show All</option>';
        $selectBox .= '</select>';
        $this->assertEqual($selectBox, $this->pager->getPerPageSelectBox(3, 6, 1, true, '%d bugs'));
    }
    function testSelectBoxWithShowAllWithExtraAttribs() {
        $options = array(
            'itemData' => range(1, 14),
            'perPage'  => 5,
        );
        $this->pager = Pager::factory($options);
        $this->pager->_showAllText = 'Show All';
        $selectBox  = '<select name="'.$this->pager->_sessionVar.'" onmouseover="doSth">';
        $selectBox .= '<option value="5" selected="selected">5 bugs</option>';
        $selectBox .= '<option value="10">10 bugs</option>';
        $selectBox .= '<option value="'.max($this->pager->_itemData).'">Show All</option>';
        $selectBox .= '</select>';
        $params = array(
            'optionText'    => '%d bugs',
            'attributes'    => 'onmouseover="doSth"',
            'checkMaxLimit' => true,
        );
        $this->assertEqual($selectBox, $this->pager->getPerPageSelectBox(5, 15, 5, true, $params));
    }
    function testSelectBoxInvalid() {
        $err = $this->pager->getPerPageSelectBox(5, 15, 5, false, '%s bugs');
        $this->assertEqual(ERROR_PAGER_INVALID_PLACEHOLDER, $err->getCode());
    }
    function testAppendInvalid() {
        $options = array(
            'totalItems' => 10,
            'append'     => false,
            'fileName'   => 'invalidFileName'
        );
        $err =& Pager::factory($options);  //ERROR_PAGER_INVALID_USAGE
        $this->assertError();
    }
    function testAppendValid() {
        $options = array(
            'totalItems' => 10,
            'append'     => false,
            'fileName'   => 'valid_%d_FileName'
        );
        $err =& Pager::factory($options);
        $this->assertNoErrors();
    }
    function testEscapeEntities() {
        //encode special chars
        $options = array(
            'extraVars' => array(
                'request' => array('aRequest'),
                'escape'    => 'äö%<>+',
            ),
            'perPage' => 5,
        );
        $this->pager =& Pager::factory($options);
        //$expected = '?request[]=aRequest&amp;escape=&auml;&ouml;%&lt;&gt;+&amp;pageID=';
        //$this->assertEqual($expected, $this->pager->_getLinksUrl());

        $expected = 'request%5B0%5D=aRequest&amp;escape=%E4%F6%25%3C%3E%2B';
        $rendered = $this->pager->_renderLink('', '');
        preg_match('/href="(.*)"/U', $rendered, $matches);
        $actual = str_replace($_SERVER['PHP_SELF'].'?', '', $matches[1]);
        $this->assertEqual($expected, $actual);

        //don't encode slashes
        $options = array(
            'extraVars' => array(
                'request' => 'cat/subcat',
            ),
            'perPage' => 5,
        );
        $this->pager =& Pager::factory($options);
        //$expected = '?request=cat/subcat&amp;pageID=';
        //$this->assertEqual($expected, $this->pager->_getLinksUrl());
        $expected = '<a href="'.$_SERVER['PHP_SELF'].'?request=cat/subcat" title=""></a>';
        $actual = $this->pager->_renderLink('', '');
        $this->assertEqual($expected, $actual);
    }
    function testMultibyteStrings() {
        $options = array(
            'extraVars' => array(
                'test' => '&#27979;&#35797;',
            ),
            'perPage' => 5,
        );
        $this->pager =& Pager::factory($options);
        //$expected = '<a href="'.$_SERVER['PHP_SELF'].'?test=&#27979;&#35797;" title=""></a>';
        $rendered = $this->pager->_renderLink('', '');
        preg_match('/href="(.*)"/U', $rendered, $matches);
        $actual = str_replace($_SERVER['PHP_SELF'].'?test=', '', $matches[1]);
        $this->assertEqual(urlencode($options['extraVars']['test']), $actual);
    }
    function testCurrentPage() {
        $options = array(
            'itemData'    => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'     => 2,
            'currentPage' => 2,
        );
        $this->pager =& Pager::factory($options);
        $this->assertEqual(3, $this->pager->getNextPageID());
        $this->assertEqual(1, $this->pager->getPreviousPageID());
        $this->assertEqual(2, $this->pager->_currentPage);
    }
    function testArrayExtraVars() {
        $arr = array(
            'apple',
            'orange',
        );
        $options = array(
            'itemData'    => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'     => 5,
            'extraVars'   => array('arr' => $arr, 'no' => 'test'),
        );
        $this->pager =& Pager::factory($options);
        /*
        //old
        $expected = '?arr[0]=apple&amp;arr[1]=orange&amp;pageID=';
        $this->assertEqual($expected, $this->pager->_getLinksUrl());
        */
        $expected = $options['extraVars'];
        $this->assertEqual($expected, $this->pager->_getLinksData());
        $separator = ini_get('arg_separator.output');
        if ($separator == '&') {
            $separator = '&amp;';
        }

        $expected = '<a href="'.$_SERVER['PHP_SELF'].'?arr%5B0%5D=apple'.$separator.'arr%5B1%5D=orange'.$separator.'no=test'.$separator.'pageID=2" title=""></a>';
        $actual = $this->pager->_renderLink('', '');
        $this->assertEqual($expected, $actual);
    }
    function testExcludeVars() {
        $arr = array(
            'apple',
            'orange',
        );
        $options = array(
            'itemData'    => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'     => 5,
            'extraVars'   => array('arr' => $arr, 'no' => 'test'),
            'excludeVars' => array('no'),
        );
        $this->pager =& Pager::factory($options);
        $expected = array(
            'arr' => array(
                0 => 'apple',
                1 => 'orange'
            ),
            'no' => 'test',
        );
        $actual = $this->pager->_getLinksData();
        $this->assertEqual($expected, $this->pager->_getLinksData());
        $separator = ini_get('arg_separator.output');
        if ($separator == '&') {
            $separator = '&amp;';
        }
        $expected = '<a href="'.$_SERVER['PHP_SELF'].'?arr%5B0%5D=apple'.$separator.'arr%5B1%5D=orange'.$separator.'no=test'.$separator.'pageID=2" title=""></a>';
        $actual = $this->pager->_renderLink('', '');
        $this->assertEqual($expected, $actual);
    }
    function testArgSeparator() {
        $bkp_arg_separator = ini_get('arg_separator.output');
        ini_set('arg_separator.output', '&amp;');

        $options = array(
            'itemData'    => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'     => 5,
            'extraVars'   => array('apple'  => 1),
        );
        $this->pager =& Pager::factory($options);

        $expected = '<a href="'.$_SERVER['PHP_SELF'].'?apple=1&amp;pageID=2" title=""></a>';
        $actual = $this->pager->_renderLink('', '');
        $this->assertEqual($expected, $actual);

        ini_set('arg_separator.output', $bkp_arg_separator);
    }
    function testAttributes() {
        $options = array(
            'itemData'    => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'     => 5,
            'linkClass'   => 'testclass',
            'attributes'  => 'target="_blank"',
        );
        $this->pager =& Pager::factory($options);

        $expected = '<a href="'.$_SERVER['PHP_SELF'].'?pageID=2" class="testclass" target="_blank" title=""></a>';
        $actual = $this->pager->_renderLink('', '');
        $this->assertEqual($expected, $actual);
    }
    function testImportQuery() {
        //add some fake url vars
        $_GET['arr'] = array(
            'apple',
            'orange',
        );
        $options = array(
            'itemData'    => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'     => 5,
            'importQuery' => false,
        );
        $this->pager =& Pager::factory($options);
        $expected = array();
        $actual = $this->pager->_getLinksData();
        $this->assertEqual($expected, $this->pager->_getLinksData());

        $expected = '<a href="'.$_SERVER['PHP_SELF'].'?pageID=2" title=""></a>';
        $actual = $this->pager->_renderLink('', '');
        $this->assertEqual($expected, $actual);
        //remove fake url vars
        unset($_GET['arr']);
    }
    function testGetNextLinkTag() {
        //append = true
        $expected = '<link rel="next" href="'.$_SERVER['PHP_SELF'].'?pageID=2" title="next page" />'."\n";
        $this->assertEqual($expected, $this->pager->_getNextLinkTag());
        
        //append = false
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'currentPage' => 1,
            'append'   => false,
            'fileName' => 'myfile.%d.php',
        );
        $this->pager = Pager::factory($options);
        $expected = '<link rel="next" href="'.$this->baseurl.'/myfile.2.php" title="next page" />'."\n";
        $this->assertEqual($expected, $this->pager->_getNextLinkTag());
        
        //test empty tag
        $options['currentPage'] = 2;
        $this->pager = Pager::factory($options);
        $this->assertEqual('', $this->pager->_getNextLinkTag());
    }
    function testGetLastLinkTag() {
        //append = true
        $expected = '<link rel="last" href="'.$_SERVER['PHP_SELF'].'?pageID=2" title="last page" />'."\n";
        $this->assertEqual($expected, $this->pager->_getLastLinkTag());

        //append = false
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'currentPage' => 1,
            'append'   => false,
            'fileName' => 'myfile.%d.php',
        );
        $this->pager = Pager::factory($options);
        $expected = '<link rel="last" href="'.$this->baseurl.'/myfile.2.php" title="last page" />'."\n";
        $this->assertEqual($expected, $this->pager->_getLastLinkTag());

        //test empty tag
        $options['currentPage'] = 2;
        $this->pager = Pager::factory($options);
        $this->assertEqual('', $this->pager->_getLastLinkTag());
    }
    function testGetFirstLinkTag() {
        //append = true
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'currentPage' => 2,
        );
        $this->pager = Pager::factory($options);
        $expected = '<link rel="first" href="'.$_SERVER['PHP_SELF'].'?pageID=1" title="first page" />'."\n";
        $this->assertEqual($expected, $this->pager->_getFirstLinkTag());

        //append = false
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'currentPage' => 2,
            'append'   => false,
            'fileName' => 'myfile.%d.php',
        );
        $this->pager = Pager::factory($options);
        $expected = '<link rel="first" href="'.$this->baseurl.'/myfile.1.php" title="first page" />'."\n";
        $this->assertEqual($expected, $this->pager->_getFirstLinkTag());

        //test empty tag
        $options['currentPage'] = 1;
        $this->pager = Pager::factory($options);
        $this->assertEqual('', $this->pager->_getFirstLinkTag());
    }
    function testGetPrevLinkTag() {
        //append = true
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'currentPage' => 2,
        );
        $this->pager = Pager::factory($options);
        $expected = '<link rel="previous" href="'.$_SERVER['PHP_SELF'].'?pageID=1" title="previous page" />'."\n";
        $this->assertEqual($expected, $this->pager->_getPrevLinkTag());

        //append = false
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'currentPage' => 2,
            'append'   => false,
            'fileName' => 'myfile.%d.php',
        );
        $this->pager = Pager::factory($options);
        $expected = '<link rel="previous" href="'.$this->baseurl.'/myfile.1.php" title="previous page" />'."\n";
        $this->assertEqual($expected, $this->pager->_getPrevLinkTag());

        //test empty tag
        $options['currentPage'] = 1;
        $this->pager = Pager::factory($options);
        $this->assertEqual('', $this->pager->_getPrevLinkTag());
    }
    function testPrintFirstPage() {
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'currentPage' => 2,
        );
        $this->pager = Pager::factory($options);
        $expected = '<a href="' . $_SERVER['PHP_SELF'] . '?pageID=1" title="first page">[1]</a>&nbsp;';
        $this->assertEqual($expected, $this->pager->_printFirstPage());

        $this->pager->_firstPageText = 'FIRST';
        $expected = '<a href="' . $_SERVER['PHP_SELF'] . '?pageID=1" title="first page">[FIRST]</a>&nbsp;';
        $this->assertEqual($expected, $this->pager->_printFirstPage());

        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'currentPage' => 2,
            'altFirst' => 'page %d',
        );
        $this->pager = Pager::factory($options);
        $expected = '<a href="' . $_SERVER['PHP_SELF'] . '?pageID=1" title="page 1">[1]</a>&nbsp;';
        $this->assertEqual($expected, $this->pager->_printFirstPage());
    }
    function testPrintLastPage() {
        $expected = '<a href="' . $_SERVER['PHP_SELF'] . '?pageID=2" title="last page">[2]</a>';
        $this->assertEqual($expected, $this->pager->_printLastPage());

        $this->pager->_lastPageText = 'LAST';
        $expected = '<a href="' . $_SERVER['PHP_SELF'] . '?pageID=2" title="last page">[LAST]</a>';
        $this->assertEqual($expected, $this->pager->_printLastPage());

        $this->pager->_altLast = 'page %d';
        $expected = '<a href="' . $_SERVER['PHP_SELF'] . '?pageID=2" title="page 2">[LAST]</a>';
        $this->assertEqual($expected, $this->pager->_printLastPage());
    }
    function testGetBackLink() {
        $img = '&laquo;';
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'currentPage' => 2,
            'prevImg' => $img,
        );
        $this->pager = Pager::factory($options);
        $expected = '<a href="' . $_SERVER['PHP_SELF'] . '?pageID=1" title="previous page">'.$img.'</a>&nbsp;';
        $this->assertEqual($expected, $this->pager->_getBackLink());
    }
    function testGetNexLink() {
        $img = '&raquo;';
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'currentPage' => 1,
            'nextImg' => $img,
        );
        $this->pager = Pager::factory($options);
        $expected = '&nbsp;<a href="' . $_SERVER['PHP_SELF'] . '?pageID=2" title="next page">'.$img.'</a>&nbsp;';
        $this->assertEqual($expected, $this->pager->_getNextLink());
    }
    function testHttpMethodAutoDetect() {
        $_POST['pageID'] = 3;
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
        );
        $this->pager = Pager::factory($options);
        $this->assertEqual('POST', $this->pager->_httpMethod);

        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'httpMethod' => 'GET',
        );
        $this->pager = Pager::factory($options);
        $this->assertEqual('GET', $this->pager->_httpMethod);

        unset($_POST['pageID']);

        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'httpMethod' => 'POST',
        );
        $this->pager = Pager::factory($options);
        $this->assertEqual('POST', $this->pager->_httpMethod);

        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
        );
        $this->pager = Pager::factory($options);
        $this->assertEqual('GET', $this->pager->_httpMethod);
    }
    function testAccesskey() {
        $options = array(
            'itemData' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'perPage'  => 5,
            'accesskey' => true,
        );
        $this->pager = Pager::factory($options);
        $this->assertWantedPattern('/accesskey="\d"/i', $this->pager->links);
        //var_dump($this->pager->links);
    }
    function testIsEncoded() {
    //var_dump(urlencode('&#50504;&#45397;'));
        $test_strings_encoded = array(
            'encoded0' => '&#35797;',
            'encoded1' => '&#27979;&#35797;',
            'encoded2' => '&#50504;&#45397;',
            'encoded3' => '&#50504; &#45397;',
            'encoded4' => '&#50504;
&#45397;',
        );
        $test_strings_plain = array(
            'plain1' => '안녕',
            'plain2' => '더보기',
//          'plain3' => '이젠 전화도
//로 걸면 무료',
            'plain4' => 'abcde',    //not multibyte
            'plain5' => '&#abcfg;', //invalid hex-encoded char
            'plain5' => '&#50504; nasty &#45397;', //mixed plain/encoded text
        );
        foreach ($test_strings_encoded as $string) {
            //echo '<hr />'.str_replace('&', '&amp;', $string);
            $this->assertTrue($this->pager->_isEncoded($string));
        }
        foreach ($test_strings_plain as $string) {
            $this->assertFalse($this->pager->_isEncoded($string));
        }
    }
    function testGetOption() {
        $this->assertEqual(5, $this->pager->getOption('perPage'));
        $err = $this->pager->getOption('non_existent_option');
        $this->assertEqual(ERROR_PAGER_INVALID, $err->getCode());
    }
    function testGetOptions() {
        $options = $this->pager->getOptions();
        $this->assertTrue(is_array($options));
        $this->assertEqual(5, $options['perPage']);
    }
    function testSetOptionsAndBuild() {
        $options = array(
            'perPage'  => 2,
        );
        $this->pager->setOptions($options);
        $this->pager->build();
        $this->assertEqual(2, $this->pager->getOption('perPage'));
        $this->assertEqual(array(0=>1, 1=>2), $this->pager->getPageData());
        $this->assertEqual(array(2=>3, 3=>4), $this->pager->getPageData(2));

        $options = array(
            'currentPage' => 2,
            'append'   => false,
            'fileName' => 'myfile.%d.php',
        );
        $this->pager->setOptions($options);
        $this->pager->build();
        $expected = '<link rel="previous" href="'.$this->baseurl.'/myfile.1.php" title="previous page" />'."\n";
        $this->assertEqual($expected, $this->pager->_getPrevLinkTag());
    }
}
?>