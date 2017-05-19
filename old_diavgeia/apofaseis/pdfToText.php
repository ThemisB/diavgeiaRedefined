<?php
require_once("apAuth.php");
require_once("fileStorage.php");
global $apAuth;
$apAuth->initUserData();

class pdfToText
{
  public $commandLine='';
  public $pathSeparator='';
  public $systemType='';
  function pdfToText()
  {
    global $apAuth;
    $apAuth->DB_General->DoConnect();
    $apAuth->DB_General->execute("SET NAMES utf8");

    $systemSTR=$_SERVER['SERVER_SOFTWARE'];
    if (strpos($systemSTR,'Win32'))
    {
      $this->commandLine='C:\\Temp\\pdftotext.exe -enc UTF-8 ';
      $this->pathSeparator='\\';
      $this->systemType='Win32';
    }
    else
    {
      $this->commandLine='pdftotext -enc UTF-8 ';
      $this->pathSeparator='/';
      $this->systemType='Linux';
    }

  }

  function getTextFromPDF($infilename)
  {
    $output='';
    if ($this->systemType=='Win32')
    {
      $cmdline=$this->commandLine.$infilename.' '.$infilename.'.txt';
    }
    else
    {
      $cmdline=$this->commandLine.$infilename.' '.$infilename.'.txt';
    }
    exec ($cmdline,$output);
    file_put_contents($infilename.'.txt',' ',FILE_APPEND );
    if ($this->systemType=='Win32')
    {
      $filename = $infilename.'.txt';
      $handle = fopen($filename, "r");
      $output = fread($handle, filesize($filename));
      fclose($handle);
    }
    else
    {
      $filename = $infilename.'.txt';
      $handle = fopen($filename, "r");
      $output = fread($handle, filesize($filename));
      fclose($handle);
    }
    return $output;
  }
}
/*


*/
?>