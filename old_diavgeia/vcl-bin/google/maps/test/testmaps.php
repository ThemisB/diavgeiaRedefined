<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("google/maps/gmaps.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class GoogleMapTest extends Page
        {
               public $GoogleMap1 = null;
        }

        global $application;

        global $GoogleMapTest;

        //Creates the form
        $GoogleMapTest=new GoogleMapTest($application);

        //Read from resource file
        $GoogleMapTest->loadResource(__FILE__);

        //Shows the form
        $GoogleMapTest->show();

?>
