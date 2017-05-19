<?php
        ini_set("display_errors",1);
        error_reporting(E_ALL);
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("menus.inc.php");
        use_unit("PEAR/peardatagrid.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class DataGridSample extends Page
        {
               public $MainMenu1 = null;
               public $PearDataGrid1 = null;
        }

        global $application;

        global $DataGridSample;

        //Creates the form
        $DataGridSample=new DataGridSample($application);

        //Read from resource file
        $DataGridSample->loadResource(__FILE__);

        //Shows the form
        $DataGridSample->show();

?>
