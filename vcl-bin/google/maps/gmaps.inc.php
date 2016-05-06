<?php
/**
*  This file is part of the VCL for PHP project
*
*  Copyright (c) 2004-2008 qadram software S.L. <support@qadram.com>
*
*  Checkout AUTHORS file for more information on the developers
*
*  This library is free software; you can redistribute it and/or
*  modify it under the terms of the GNU Lesser General Public
*  License as published by the Free Software Foundation; either
*  version 2.1 of the License, or (at your option) any later version.
*
*  This library is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
*  Lesser General Public License for more details.
*
*  You should have received a copy of the GNU Lesser General Public
*  License along with this library; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
*  USA
*
*/

        /**
        *
        */
        require_once("vcl/vcl.inc.php");

        use_unit("controls.inc.php");

        /**
        * Provides a wrapper over the Google Maps API
        *
        * @package Google
        */
        class GoogleMap extends Control
        {
            function __construct($aowner = null)
            {
                parent::__construct($aowner);
                $this->ControlStyle="csVerySlowRedraw=1";
            }

            private $_mapskey="ABQIAAAAQlQ8ZvigZnDc1z7MTEuUQxTJO8fVsnY3pyCJC531oZiosu_8phSnTlxi08R1_58Gfdyd9NUJdyES5w";

            /**
            * Specifies the key to use google API
            *
            * Use this property to specify the key to use for google API
            *
            * @return string
            */
            function getMapsKey() { return $this->_mapskey; }
            function setMapsKey($value) { $this->_mapskey=$value; }
            function defaultMapsKey() { return "ABQIAAAAQlQ8ZvigZnDc1z7MTEuUQxTJO8fVsnY3pyCJC531oZiosu_8phSnTlxi08R1_58Gfdyd9NUJdyES5w"; }

            private $_address="Scotts Valley, CA";

            /**
            * Specifies the address to show in the map
            *
            * Use this property to specify the address to show in the map, i.e. Scotts Valley, CA
            *
            * @return string
            */
            function getAddress() { return $this->_address; }
            function setAddress($value) { $this->_address=$value; }
            function defaultAddress() { return "Scotts Valley, CA"; }



            function dumpHeaderCode()
            {
?>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $this->MapsKey; ?>"
      type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[
    function <?php echo $this->Name; ?>load()
    {
      if (GBrowserIsCompatible())
      {
        var map = new GMap2(document.getElementById("<?php echo $this->Name; ?>_div"));
        map.addControl(new GLargeMapControl());
        map.addControl(new GScaleControl());
        map.addControl(new GMapTypeControl());

        var geocoder = new GClientGeocoder();

        var address="<?php echo $this->Address; ?>";

        geocoder.getLatLng (address,

        function(point)
        {
                if (!point)
                {
                        alert(address + " not found");
                }
                else
                {
                        map.setCenter(point, 13);
                        var marker = new GMarker(point);
                        map.addOverlay(marker);
                        marker.openInfoWindowHtml(address);
                }
        }
        );
      }
      if (<?php echo $this->Name; ?>_load!=null) <?php echo $this->Name; ?>_load();
   }
    //]]>
    </script>
<?php
            }

            function dumpContents()
            {
                echo "<div id=\"".$this->Name."_div\" style=\"width: ".$this->Width."px; height: ".$this->Height."px\"></div>";
?>
    <script type="text/javascript">
    <?php echo $this->Name; ?>_load=window.onload;
    window.onload=<?php echo $this->Name; ?>load;
    </script>
<?php
            }
        }

?>
