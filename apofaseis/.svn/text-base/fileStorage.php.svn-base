<?php

require_once("apAuth.php");
global $apAuth;
$apAuth->initUserData();

class fileStorage
{
   public $storageRoot = '';
   public $pathSeparator = '';
   function fileStorage()
   {
      global $apAuth;
      $apAuth->DB_General->DoConnect();
      $apAuth->DB_General->execute("SET NAMES utf8");
      include('config.php');
      $this->storageRoot = $fileStoragePath;
      $this->pathSeparator = $appPathSeparator;

   }

   function createPathFromUID($uid)
   {
      $uidsha1 = sha1($uid . 'stavsalt');
      $ai = 0;
      for($i = 0; $i < strlen($uidsha1); $i = $i + 2)
      {
         $uidbase36array[$ai] = substr($uidsha1, $i, 2);
         $ai++;
      }
      $uiddirroot = $this->storageRoot;


      for($i = 0; $i < count($uidbase36array); $i++)
      {
         $uiddirroot .= $uidbase36array[$i] . $this->pathSeparator;
         if(!is_dir($uiddirroot))
         {
            mkdir($uiddirroot, 2775);
         }
      }
   }

   function createPathFromUID_old($uid)
   {
      $uidbase36 = base_convert($uid, 10, 36);
      $uidbase36 = str_pad($uidbase36, 6, '0', STR_PAD_LEFT);
      //6 digits at base 36 = 2,176,782,336 possible addresses

      for($i = 0; $i < strlen($uidbase36); $i++)
      {
         $uidbase36array[$i] = substr($uidbase36, $i, 1);
      }
      $uiddirroot = $this->storageRoot;


      for($i = 0; $i < count($uidbase36array); $i++)
      {
         $uiddirroot .= $uidbase36array[$i] . $this->pathSeparator;
         if(!is_dir($uiddirroot))
         {
            mkdir($uiddirroot, 2775);
         }
      }
   }

   function getPathFromUID($uid)
   {

      $uidsha1 = sha1($uid . 'stavsalt');
      $ai = 0;
      for($i = 0; $i < strlen($uidsha1); $i = $i + 2)
      {
         $uidbase36array[$ai] = substr($uidsha1, $i, 2);
         $ai++;
      }
      $uiddirroot = $this->storageRoot;


      for($i = 0; $i < count($uidbase36array); $i++)
      {
         $uiddirroot .= $uidbase36array[$i] . $this->pathSeparator;
      }
      return $uiddirroot;
   }


   function getPathFromUID_old($uid)
   {
      $uidbase36 = base_convert($uid, 10, 36);
      $uidbase36 = str_pad($uidbase36, 6, '0', STR_PAD_LEFT);
      //6 digits at base 36 = 2,176,782,336 possible addresses

      for($i = 0; $i < strlen($uidbase36); $i++)
      {
         $uidbase36array[$i] = substr($uidbase36, $i, 1);
      }
      $uiddirroot = $this->storageRoot;


      for($i = 0; $i < count($uidbase36array); $i++)
      {
         $uiddirroot .= $uidbase36array[$i] . $this->pathSeparator;
      }
      return $uiddirroot;
   }

   function readFile($uid, $infilename)
   {
      $filename = $this->getPathFromUID($uid) . $infilename;
      if(file_exists($filename))
      {
         if($handle = fopen($filename, "r"))
         {
            $contents = fread($handle, filesize($filename));
            fclose($handle);
         }
         else
         {
            echo "Error while reading : Cannot open file<br>";
            exit;
         }
         return $contents;
      }
      else
      {
         echo 'fileStorage Class: File does not exist.';
         exit;
      }

   }
   function deleteFile($uid, $infilename)
   {
      $filename = $this->getPathFromUID($uid) . $infilename;
      if(file_exists($filename))
      {
         unlink($filename);
      }
      else
      {
         echo 'fileStorage Class: File does not exist.';
         exit;
      }

   }
   function renameFile($uid, $infilename,$outfilename)
   {
      $filename = $this->getPathFromUID($uid) . $infilename;
      $newfilename = $this->getPathFromUID($uid) . $outfilename;
      if(file_exists($filename))
      {
         rename($filename,$newfilename);
      }
      else
      {
         echo 'fileStorage Class: File does not exist.';
         exit;
      }

   }
   function writeFile($uid, $infilename, $contents)
   {
      $this->createPathFromUID($uid);
      $filename = $this->getPathFromUID($uid) . $infilename;
      if(!$handle = fopen($filename, 'w+'))
      {
         echo "Error while writing : Cannot open file<br>";
         exit;
      }

      if(fwrite($handle, $contents) === FALSE)
      {
         echo "Error while writing : Cannot write to file<br>";
         exit;
      }
      fclose($handle);

      return $returnval;
   }
}
/*
$a= new fileStorage();
$a->createPathFromUID('4561');
echo $a->getPathFromUID('4561');
echo '<br>';
$a->writeFile('4561','somefile.txt','hi there2');
echo $a->readFile('4561','somefile.txt');

$a= new fileStorage();
echo $a->getPathFromUID('2010-07-27-7083-3'); */
?>