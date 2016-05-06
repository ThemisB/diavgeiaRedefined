<?php
// $Id: pager_wrapper_test.php,v 1.2 2006/03/15 12:29:57 quipo Exp $

require_once 'simple_include.php';
require_once 'pager_wrapper_include.php';

class TestOfPagerWrapper extends UnitTestCase
{
    function TestOfPagerWrapper($name='Test of Pager_Wrapper') {
        $this->UnitTestCase($name);
    }
    
    function setUp() { }
    function tearDown() { }

    /**
     * Basic tests for rewriteCountQuery()
     */
    function testRewriteCountQuery() {
        //test LIMIT
        $query = 'SELECT a, b, c, d FROM mytable WHERE a=1 AND c="g" LIMIT 2';
        $expected = 'SELECT COUNT(*) FROM mytable WHERE a=1 AND c="g"';
        $this->assertEqual($expected, rewriteCountQuery($query));

        //test ORDER BY and quotes
        $query = 'SELECT a, b, c, d FROM mytable WHERE a=1 AND c="g" ORDER BY (a, b)';
        $expected = 'SELECT COUNT(*) FROM mytable WHERE a=1 AND c="g"';
        $this->assertEqual($expected, rewriteCountQuery($query));

        //test CR/LF
        $query = 'SELECT a, b, c, d FROM mytable
                   WHERE a=1
                     AND c="g"
                ORDER BY (a, b)';
        $expected = 'SELECT COUNT(*) FROM mytable
                   WHERE a=1
                     AND c="g"';
        $this->assertEqual($expected, rewriteCountQuery($query));

        //test GROUP BY
        $query = 'SELECT a, b, c, d FROM mytable WHERE a=1 GROUP  BY c';
        $this->assertFalse(rewriteCountQuery($query));

        //test DISTINCT
        $query = 'SELECT DISTINCT a, b, c, d FROM  mytable WHERE a=1 GROUP BY c';
        $this->assertFalse(rewriteCountQuery($query));

        //test MiXeD Keyword CaSe
        $query = 'SELECT a, b, c, d from mytable WHERE a=1 AND c="g"';
        $expected = 'SELECT COUNT(*) FROM mytable WHERE a=1 AND c="g"';
        $this->assertEqual($expected, rewriteCountQuery($query));

        //test function speed... this query used to be very slow to parse
        $query = "SELECT  i.item_id,
                ia.addition,
                u.username,
                i.date_created,
                i.start_date,
                i.expiry_date
        FROM    item i, item_addition ia, item_type it, item_type_mapping itm, usr u, category c
        WHERE   ia.item_type_mapping_id = itm.item_type_mapping_id
        AND     i.updated_by_id = u.usr_id
        AND     it.item_type_id  = itm.item_type_id
        AND     i.item_id = ia.item_id
        AND     i.item_type_id = it.item_type_id
        AND     itm.field_name = 'title' AND it.item_type_id = 2 AND i.category_id = 1 AND i.status  = 4
        AND     i.category_id = c.category_id
        AND     0 NOT IN (COALESCE(c.perms, '-1'))
        ORDER BY i.last_updated DESC";
        $expected = "SELECT COUNT(*) FROM    item i, item_addition ia, item_type it, item_type_mapping itm, usr u, category c
        WHERE   ia.item_type_mapping_id = itm.item_type_mapping_id
        AND     i.updated_by_id = u.usr_id
        AND     it.item_type_id  = itm.item_type_id
        AND     i.item_id = ia.item_id
        AND     i.item_type_id = it.item_type_id
        AND     itm.field_name = 'title' AND it.item_type_id = 2 AND i.category_id = 1 AND i.status  = 4
        AND     i.category_id = c.category_id
        AND     0 NOT IN (COALESCE(c.perms, '-1'))";
        $this->assertEqual($expected, rewriteCountQuery($query));
    }
    
    /**
     * Test rewriteCountQuery() with queries having a subquery in the SELECT clause
     */
    function testRewriteCountQuery_SubqueriesInSelectClause() {
        $query = 'SELECT a, (SELECT a FROM b) AS b, c, d FROM mytable WHERE a=1 AND c="g" LIMIT 2';
        $expected = 'SELECT COUNT(*) FROM mytable WHERE a=1 AND c="g"';
        $this->assertFalse(rewriteCountQuery($query));

        $query = 'SELECT a, (SELECT a FROM b) AS b, (SELECT c FROM c) AS c, d FROM mytable WHERE a=1 AND c="g" LIMIT 2';
        //$expected = 'SELECT COUNT(*) FROM mytable WHERE a=1 AND c="g"';
        $this->assertFalse(rewriteCountQuery($query));

        $query = 'SELECT `id`, `ip`, (
SELECT TIMEDIFF(MAX(P.`time`), MIN(P.`time`))
FROM `przejscia` as P
WHERE P.`id_wejscia`=W.`id`
) as `czas`
FROM `wejscia` as W
WHERE W.id_domeny=?
ORDER BY W.czas_wejscia DESC';
        $expected = 'SELECT COUNT(*)
FROM `wejscia` as W
WHERE W.id_domeny=?
ORDER BY W.czas_wejscia DESC';
        $this->assertFalse(rewriteCountQuery($query));
    }
        
    /**
     * Test rewriteCountQuery() with queries having a subquery in the FROM clause
     */
    function testRewriteCountQuery_SubqueriesInFromClause() {
        $query = 'SELECT a, b, c, d FROM (SELECT a, b, c, d FROM mytable WHERE a=1) AS tbl_alias WHERE a=1';
        $expected = 'SELECT COUNT(*) FROM (SELECT a, b, c, d FROM mytable WHERE a=1) AS tbl_alias WHERE a=1';
        $this->assertEqual($expected, rewriteCountQuery($query));
    }
    
    /**
     * Test rewriteCountQuery() with queries having a subquery in the WHERE clause
     */
    function testRewriteCountQuery_SubqueriesInWhereClause() {
        //this one is not rewritten: subqueries with ORDER BY clauses might get truncated
        $query = 'SELECT Version.VersionId, Version.Identifier,News.*
FROM VersionBroker
JOIN ObjectType ON ObjectType.ObjectTypeId = VersionBroker.ObjectTypeId
JOIN Version ON VersionBroker.Identifier = Version.Identifier
JOIN News ON Version.ObjectId = News.NewsId
WHERE Version.Status = \'Approved\'
AND ObjectType.Name = \'News\'
AND Version.ApprovedTS = (
    SELECT SubV.ApprovedTS
    FROM Version SubV
    WHERE SubV.Identifier = VersionBroker.Identifier
    ORDER BY ApprovedTS DESC
    LIMIT 1)
ORDER BY ApprovedTS DESC';

        $expected = 'SELECT COUNT(*)
FROM VersionBroker
JOIN ObjectType ON ObjectType.ObjectTypeId = VersionBroker.ObjectTypeId
JOIN Version ON VersionBroker.Identifier = Version.Identifier
JOIN News ON Version.ObjectId = News.NewsId
WHERE Version.Status = \'Approved\'
AND ObjectType.Name = \'News\'
AND Version.ApprovedTS = (
    SELECT SubV.ApprovedTS
    FROM Version SubV
    WHERE SubV.Identifier = VersionBroker.Identifier
    ORDER BY ApprovedTS DESC
    LIMIT 1)
ORDER BY ApprovedTS DESC';
        //$this->assertEqual($expected, rewriteCountQuery($query));
        $this->assertFalse(rewriteCountQuery($query));
        
        //this one should pass... subquery without ORDER BY or LIMIT clause
        $query = 'SELECT Version.VersionId, Version.Identifier,News.* FROM VersionBroker JOIN
ObjectType ON ObjectType.ObjectTypeId = VersionBroker.ObjectTypeId JOIN
Version ON VersionBroker.Identifier = Version.Identifier JOIN News ON
Version.ObjectId = News.NewsId WHERE Version.Status = \'Approved\' AND
ObjectType.Name = \'News\' AND Version.ApprovedTS = ( SELECT SubV.ApprovedTS
FROM Version SubV WHERE SubV.Identifier = VersionBroker.Identifier ) ORDER BY ApprovedTS DESC';

        $expected = 'SELECT COUNT(*) FROM VersionBroker JOIN
ObjectType ON ObjectType.ObjectTypeId = VersionBroker.ObjectTypeId JOIN
Version ON VersionBroker.Identifier = Version.Identifier JOIN News ON
Version.ObjectId = News.NewsId WHERE Version.Status = \'Approved\' AND
ObjectType.Name = \'News\' AND Version.ApprovedTS = ( SELECT SubV.ApprovedTS
FROM Version SubV WHERE SubV.Identifier = VersionBroker.Identifier )';
        $this->assertEqual($expected, rewriteCountQuery($query));
    }

    /**
     * Test rewriteCountQuery() with queries having keywords embedded in other words
     */
    function testRewriteCountQuery_EmbeddedKeywords() {
        $query = 'SELECT afieldFROM, b, c, d FROM mytable WHERE a=1 AND c="g"';
        $expected = 'SELECT COUNT(*) FROM mytable WHERE a=1 AND c="g"';
        $this->assertEqual($expected, rewriteCountQuery($query));

        $query = 'SELECT FROMafield, b, c, d FROM mytable WHERE a=1 AND c="g"';
        $expected = 'SELECT COUNT(*) FROM mytable WHERE a=1 AND c="g"';
        $this->assertEqual($expected, rewriteCountQuery($query));

        $query = 'SELECT afieldFROMaaa, b, c, d FROM mytable WHERE a=1 AND c="gLIMIT"';
        $expected = 'SELECT COUNT(*) FROM mytable WHERE a=1 AND c="gLIMIT"';
        $this->assertEqual($expected, rewriteCountQuery($query));

        $query = 'SELECT DISTINCTaaa, b, c, d FROM mytable WHERE a=1 AND c="g"';
        $expected = 'SELECT COUNT(*) FROM mytable WHERE a=1 AND c="g"';
        $this->assertEqual($expected, rewriteCountQuery($query));

        //this one fails... the regexp should NOT match keywords within quotes.
        //we need a full blown stack-based parser to catch this...
        $query = 'SELECT afieldFROMaaa, b, c, d FROM mytable WHERE a=1 AND c="g LIMIT a"';
        $expected = 'SELECT COUNT(*) FROM mytable WHERE a=1 AND c="g LIMIT a"';
        $this->assertEqual($expected, rewriteCountQuery($query));
    }
}

if (!defined('TEST_RUNNING')) {
    define('TEST_RUNNING', true);
    $test = &new TestOfPagerWrapper();
    $test->run(new HtmlReporter());
}
?>