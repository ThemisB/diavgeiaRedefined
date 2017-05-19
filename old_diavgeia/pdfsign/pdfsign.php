<?php

$searchpath = dirname(__FILE__);

$endpage = 0;
$ada = mysql_escape_string($_REQUEST['ada']);
$ada = 'Δοκιμαστική/Μη έγκυρη Καταχώριση ΑΔΑ: ' . $ada;
$ada = mb_convert_encoding($ada, "ISO-8859-7", "UTF-8, ISO-8859-7");

$fontsize = 14;
/* 
["file_box"]=>
array(5) {
["name"]=>
string(24) "ZONGIntegrationGuide.pdf"
["type"]=>
string(18) "application/binary"
["tmp_name"]=>
string(23) "C:\wamp\tmp\php490B.tmp"
["error"]=>
int(0)
["size"]=>
int(1119397)
}
*/
$inpdffile = $_FILES['file_box']['tmp_name'];
try 
{
   $p = PDF_new();
   //PDF_set_parameter($p, "license", "L800202-010000-124324-X5HEB2-UM5BA2");
   PDF_set_parameter($p, "errorpolicy", "return");

   PDF_set_parameter($p, "SearchPath", $searchpath);

   if(PDF_begin_document($p, "", "") == 0)
   {
      die("Error: " . PDF_get_errmsg($p));
   }


   PDF_set_info($p, "Creator", "Di@vgeia");
   PDF_set_info($p, "Author", "diavgeia.gov.gr");

   $manual = PDF_open_pdi_document($p, $inpdffile, "");

   if(!$manual) 
   {
      die("Error: " . PDF_get_errmsg($p));
   }


   PDF_set_parameter($p, "topdown", "true");

   $endpage = PDF_pcos_get_number($p, $manual, "length:pages");
   for($pageno = 1; $pageno <= $endpage; $pageno++)
   {

      $page = PDF_open_pdi_page($p, $manual, $pageno, "");
      if(!$page)
      {
         die("Error: " . PDF_get_errmsg($p));
      }
      $height = PDF_info_pdi_page($p, $page, "height", "");
      $width = PDF_info_pdi_page($p, $page, "width", "");

      PDF_begin_page_ext($p, $width, $height, "");

      PDF_fit_pdi_page($p, $page, 0, $height, "scale 1");

      PDF_close_pdi_page($p, $page);
      
      $ada_offset = round($width - strlen($ada) * ($fontsize / 1.5));
      $font = PDF_load_font($p, "ARIAL", "iso8859-7", "");
      if($font == 0)
      {
         die("Error: " . PDF_get_errmsg($p));
      }
      PDF_setfont($p, $font, $fontsize);
      PDF_set_text_pos($p, $ada_offset, 24);
      PDF_show($p, $ada);

      PDF_end_page_ext($p, "");

   }



   PDF_end_document($p, "");
   PDF_close_pdi_document($p, $manual);

   $buf = PDF_get_buffer($p);
   $len = strlen($buf);


   header("Content-type: application/pdf");
   header("Content-Length: $len");
   header("Content-Disposition: inline; filename=signed_" . $ada . ".pdf");
   print $buf;
   $buf = 0;
   unlink($inpdffile);
}
catch(PDFlibException $e)
{
   die("PDFlib exception occurred :\n" . 
   "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " . 
   $e->get_errmsg() . "\n");
}
catch(Exception $e)
{
   die($e);
}
$p = 0;

?>