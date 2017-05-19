--TEST--
DB::Error 2
--SKIPIF--
<?php chdir(dirname(__FILE__)); require_once './skipif.inc'; ?>
--FILE--
<?php
require_once './include.inc';
require_once 'DB.php';

error_reporting(E_ALL);

function myfunc(&$obj) {
    print 'myfunc here, obj='
          . strtolower($obj->toString()) . "\n";
}
function myfunc2(&$obj) {
    print 'myfunc2 here, obj='
          . strtolower($obj->toString()) . "\n";
}
class myclass {
    function myfunc(&$obj) {
        print 'myclass::myfunc here, obj='
          . strtolower($obj->toString()) . "\n";
    }
}
function test_error_handler($errno, $errmsg, $file, $line, $vars) {
    if (defined('E_STRICT')) {
        if ($errno & E_STRICT
            && (error_reporting() & E_STRICT) != E_STRICT) {
            // Ignore E_STRICT notices unless they have been turned on
            return;
        }
    } else {
        define('E_STRICT', 2048);
    }
    $errortype = array (
        E_ERROR => 'Error',
        E_WARNING => 'Warning',
        E_PARSE => 'Parsing Error',
        E_NOTICE => 'Notice',
        E_CORE_ERROR => 'Core Error',
        E_CORE_WARNING => 'Core Warning',
        E_COMPILE_ERROR => 'Compile Error',
        E_COMPILE_WARNING => 'Compile Warning',
        E_USER_ERROR => 'User Error',
        E_USER_WARNING => 'User Warning',
        E_USER_NOTICE => 'User Notice',
        E_STRICT => 'Strict Notice',
    );
    $prefix = $errortype[$errno];
    print strtolower("$prefix: $errmsg in " . basename($file)
                     . " on line XXX\n");
}

$obj = new myclass;

$dbh = DB::factory("mysql");

print "default: ";
$e = $dbh->raiseError("return testing error");
print strtolower($e->toString()) . "\n";

print "global default: ";
PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, "myfunc2");
$e = $dbh->raiseError("global default test");

$dbh->setErrorHandling(PEAR_ERROR_PRINT);
print "mode=print: ";
$e = $dbh->raiseError("print testing error");
print "\n";

$dbh->setErrorHandling(PEAR_ERROR_CALLBACK, "myfunc");
print "mode=function callback: ";
$e = $dbh->raiseError("function callback testing error");

$dbh->setErrorHandling(PEAR_ERROR_CALLBACK, array($obj, "myfunc"));
print "mode=object callback: ";
$e = $dbh->raiseError("object callback testing error");

set_error_handler("test_error_handler");
$dbh->setErrorHandling(PEAR_ERROR_TRIGGER);
print "mode=trigger: ";
$e = $dbh->raiseError("trigger testing error");

?>
--EXPECT--
default: [db_error: message="db error: return testing error" code=-1 mode=return level=notice prefix="" info=" [db error: unknown error]"]
global default: myfunc2 here, obj=[db_error: message="db error: global default test" code=-1 mode=callback callback=myfunc2 prefix="" info=" [db error: unknown error]"]
mode=print: DB Error: print testing error
mode=function callback: myfunc here, obj=[db_error: message="db error: function callback testing error" code=-1 mode=callback callback=myfunc prefix="" info=" [db error: unknown error]"]
mode=object callback: myclass::myfunc here, obj=[db_error: message="db error: object callback testing error" code=-1 mode=callback callback=myclass::myfunc prefix="" info=" [db error: unknown error]"]
mode=trigger: user notice: db error: trigger testing error in pear.php on line xxx
