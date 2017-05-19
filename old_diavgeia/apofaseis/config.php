<?php
    $systemSTR=$_SERVER['SERVER_SOFTWARE'];
    $systemSIG=$_SERVER['SERVER_NAME'];
    if (strpos($systemSTR,'Win32'))
    {
      $appPathSeparator='\\';
      $appSystemType='Win32';
      $appDBHost='localhost';
      $signingMode='PDFlib';
      $fileStoragePath='C:\\Temp\\fileStorage\\';
      $appIsDev='true';
    }
    else
    {

    if ($systemSIG=='83.212.121.173')
      {
        $appPathSeparator='/';
        $appSystemType='Linux'; 
        $appDBHost='localhost';
        $appSignServerURL='http://83.212.121.173/drasi1/pdfsign/pdfsign.php';
        $signingMode='PDFlib';
        $fileStoragePath='/var/www/drasi1/storage/files/';
        $appIsDev='false';
      }
      else
      {
       
      }
    }

?>