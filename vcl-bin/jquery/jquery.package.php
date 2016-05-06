<?php
  require_once("vcl/vcl.inc.php");
  use_unit("designide.inc.php");

    setPackageTitle("jQuery VCL for PHP Components");
  //Change this setting to the path where the icons for the components reside
  setIconPath("./icons");

  //Change yourunit.inc.php to the php file which contains the component code
  registerComponents("jQuery",array("JQSlider"),"jquery/jquery.inc.php");

  registerPropertyEditor("JQSlider","Lines","TStringListPropertyEditor","native");
?>
