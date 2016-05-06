<?php
class signingClass
{
   public $original_temp_filename;
   public $original_filename;
   public $ada;
   public $pdf_sha2;
   var $signed_filename;
   var $signed_temp_filename;

   function getpdf_sha2()
   {
     return $this->pdf_sha2;
   }

   function setpdf_sha2($invar)
   {
     $this->pdf_sha2=$invar;
   }

   function DownloadUrl($Url)
   {

      // is curl installed?
      if(!function_exists('curl_init'))
      {
         die('CURL is not installed!');
      }

      // create a new curl resource
      $ch = curl_init();

      /*
      Here you find more options for curl:
      http://www.php.net/curl_setopt
      */

      // set URL to download
      curl_setopt($ch, CURLOPT_URL, $Url);

      // set referer:
      curl_setopt($ch, CURLOPT_REFERER, "http://dev.gov.gr/");

      // user agent:
      curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");

      // remove header? 0 = yes, 1 = no
      curl_setopt($ch, CURLOPT_HEADER, 0);

      // should curl return or print the data? true = return, false = print
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // timeout in seconds
      curl_setopt($ch, CURLOPT_TIMEOUT, 240);
      $data = array(
                    "file_box" => "@" . $this->original_temp_filename,
                    'ada' => $this->ada
                    );
      //'url' => '',
      //'url' => 'http://193.105.109.110/apofaseis/get_doc.php/ada='.$this->ada,
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);


      // download the given URL, and return output
      $output = curl_exec($ch);

      // close the curl resource, and free system resources
      curl_close($ch);

      // print output
      return $output;
   }



   function signFile()
   {
      include('config.php');
      $signed_content = $this->DownloadUrl($appSignServerURL);
      if($signed_content)
      {
         if ($appSystemType=='Win32')
         {
            $this->pdf_sha2=hash("sha256", $signed_content);
         }
         else
         {
            $this->pdf_sha2=bin2hex(mHash(MHASH_SHA256, $signed_content));
         }
         $this->signed_temp_filename = "/tmp/signed_" . $this->ada . ".pdf";
         $filename = $this->signed_temp_filename;
         $this->signed_filename = "signed_" . $this->ada . ".pdf";
         if(!$handle = fopen($filename, 'a'))
         {
            echo "Cannot open file ($filename)";
            exit;
         }
         if(fwrite($handle, $signed_content) === FALSE)
         {
            echo "Cannot write to file ($filename)";
            exit;
         }
         fclose($handle);
         /*
         $filename="C:\\Users\\DotH\\Desktop\\temp\\".$this->signed_filename;
         if (!$handle = fopen($filename, 'a')) {
         echo "Cannot open file ($filename)";
         exit;
         }
         if (fwrite($handle, $signed_content) === FALSE) {
         echo "Cannot write to file ($filename)";
         exit;
         }
         fclose($handle);  */
         return true;
      }
      else
      {
         return false;
      }
   }

}

?>