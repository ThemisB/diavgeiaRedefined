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
use_unit("controls.inc.php");

/**
 * A control to paginate sets of data and adapted to work with datasets also
 *
 * This control provides an interface to browse sets of data using pages, you
 * specify how much records you have and how much records per page and the control
 * provide the required buttons and behaviour to allow the user browse the data set.
 *
 */
class Pager extends Control
{
	public $total_records = 0;
    public $number_of_pages = 0;
    public $offset = 0;
    public $updated=0;

	function __construct($AOwner=null)
    {
    	parent::__construct($AOwner);
        $this->Width=377;
        $this->Height=33;
    }

    function serialize()
    {
    	parent::serialize();

        //Stores the current page on the session, to recover it later
        $owner = $this->readOwner();
        if ($owner != null)
        {
        	$prefix = $owner->readNamePath().".".$this->_name.".";
            $_SESSION[$prefix."_current_page"] = $this->current_page;
        }
    }

    function unserialize()
    {
    	parent::unserialize();

        //Recovers the current page from the session, if any
        $owner = $this->readOwner();
        if ($owner != null)
        {
        	$prefix = $owner->readNamePath().".".$this->_name.".";
            $this->current_page = $_SESSION[$prefix."_current_page"];
            if ($this->current_page<=0) $this->current_page=1;
        }
    }

    /**
    * Updates all the internal variables according to the settings
    *
    * This method is used internally to perform all calculations required
    * before show the controls to navigate through the data
    *
    */
    function updateControls()
    {
        	$ds=null;

        	if ($this->updated==0)
            {
            	$this->updated=1;
	        	$this->total_records=$this->_designtotalrecords;
    	    	if (($this->ControlState & csDesigning) != csDesigning)
        		{
                	//If we are in runtime and a datasource is attached
        			if ($this->_datasource!=null && $this->_datasource->Dataset!=null && $this->_datasource->Dataset->Active)
            		{
                    	//Get the record count for the dataset
	            		$ds = $this->_datasource->DataSet;
    	        		$ds->LimitStart=-1;
        	        	$ds->LimitCount=-1;
            	        $ds->close();
                	    $ds->open();
	                	$this->total_records= $ds->RecordCount;
    	        	}
        		}

            //Calculates the total number of pages
			$this->number_of_pages = ceil($this->total_records / $this->_recordsperpage);

      		if ($this->current_page > $this->number_of_pages) $this->current_page = $this->number_of_pages;

      		//Calculates the starting page depending on the current page
            $this->offset = ($this->_recordsperpage * ($this->current_page - 1));

            if ($ds!=null)
            {
            	//Set the limits for the dataset
            	$ds->LimitStart=$this->offset;
                $ds->LimitCount=$this->_recordsperpage;
                $ds->close();
                $ds->open();
            }
            }

        }

	public $baseurl='';
    public $current_page=1;

    protected $_designtotalrecords=100;

    /**
    * Set the maximum number of records for the pager
    *
    * This property can be used in design-time where no Dataset is active or in
    * runtime if you want to use this control without dataset attached.
    *
    * @return integer
    */
    function getDesignTotalRecords() { return $this->_designtotalrecords; }
    function setDesignTotalRecords($value) { $this->_designtotalrecords=$value; }
    function defaultDesignTotalRecords() { return 100; }

    protected $_recordsperpage=10;

    /**
    * Specifies how many records are shown on each page
    *
    * Use this property to set how many records will paginate this control per each
    * page.
    *
    * @return integer
    */
    function getRecordsPerPage() { return $this->_recordsperpage; }
    function setRecordsPerPage($value) { $this->_recordsperpage=$value; }
    function defaultRecordsPerPage() { return 10; }

    protected $_maxbuttons=10;

    /**
    * The maximum number of buttons to show before show a ... button
    *
    * If the number of pages exceed the width of the control, a button ... is show
    * to allow the user navigate through blocks of pages. This property controls
    * how many buttons are shown on the control at a single time
    *
    * @return integer
    */
    function getMaxButtons() { return $this->_maxbuttons; }
    function setMaxButtons($value) { $this->_maxbuttons=$value; }
    function defaultMaxButtons() { return 10; }



    protected $_cssfile='digg.css';

    /**
    * Specifies the css file to be used to apply to the control
    *
    * Use this property to specify a css file to be included on the
    * page to format the pager control. The file will be gathered
    * from vcl/css folder, if you want to use your css file, just use
    * a StyleSheet component.
    *
    * @return string
    */
    function getCSSFile() { return $this->_cssfile; }
    function setCSSFile($value) { $this->_cssfile=$value; }
    function defaultCSSFile() { return 'digg.css'; }

    function getFont() { return $this->readfont(); }
    function setFont($value) { $this->writefont($value); }

    function getParentFont() { return $this->readparentfont(); }
    function setParentFont($value) { $this->writeparentfont($value); }

    protected $_nextcaption="next >>";

    /**
    * Specifies the text to be used for the Next button
    *
    * Use this property to set the text to be used when rendering the Next
    * button
    *
    * @return string
    */
    function getNextCaption() { return $this->_nextcaption; }
    function setNextCaption($value) { $this->_nextcaption=$value; }
    function defaultNextCaption() { return "next >>"; }

    protected $_previouscaption="<< prev";

    /**
    * Specifies the text to be used for the Previous button
    *
    * Use this property to set the text to be used when rendering the Previous
    * button
    *
    * @return string
    */
    function getPreviousCaption() { return $this->_previouscaption; }
    function setPreviousCaption($value) { $this->_previouscaption=$value; }
    function defaultPreviousCaption() { return "<< prev"; }

    protected $_datasource=null;
        /**
        * DataSource property allows you to link this control to a dataset containing
        * rows of data.
        *
        * To make it work, you must also assign DataField property with
        * the name of the column you want to use
        *
        * @return Datasource
        */
        function getDataSource() { return $this->_datasource;   }
        function setDataSource($value)
        {
                $this->_datasource=$this->fixupProperty($value);
        }

    function loaded()
    {
    	parent::loaded();
        $this->setDataSource($this->_datasource);
    }

    function dumpHeaderCode()
    {
?>
<style type="text/css">
<?php
	//Dumps the css file if any
	if ($this->_cssfile!='')
	{
?>
@import "<?php echo VCL_HTTP_PATH; ?>/css/<?php echo $this->_cssfile; ?>";
<?php
	}
?>
div.pagination a,div.pagination span.current
{
<?php echo $this->_font->readFontString(); ?>
}

</style>
<?php
    }

    function init()
    {
    	//Recovers the position from the request
    	$position=$this->input->{$this->_name};
    	if (is_object($position))
    	{
     		$this->current_page=$position->asInteger();
     	}

    	//Update control data
    	$this->updateControls();
    }

	function dumpContents()
	{
    	$this->updateControls();

        //Get the script filename
    	$script = "";
        if (isset($_SERVER['PHP_SELF']))
        {
        	$script = basename($_SERVER['PHP_SELF']);
        }
        $this->baseurl=$script."?".urlencode($this->_name)."=%d";

        //Set height and width
        $style = "height:" . $this->Height . "px;width:" . $this->Width . "px;";

        //Start dumping
     	$link_string = '<div class="pagination" style="'.$style.'">';

        //Previous button
     	if ($this->current_page > 1) $link_string .= '<a href="' . sprintf($this->baseurl,($this->current_page - 1)) . '" class="prevnext">'.$this->_previouscaption.'</a>'."\n";
        else $link_string .= '<a class="disabled">'.$this->_previouscaption.'</a>'."\n";

        //Window calculation
      	$cur_window_num = intval($this->current_page / $this->_maxbuttons);
      	if ($this->current_page % $this->_maxbuttons) $cur_window_num++;

	    $max_window_num = intval($this->number_of_pages/ $this->_maxbuttons);
      	if ($this->number_of_pages % $this->_maxbuttons) $max_window_num++;

        if ($cur_window_num > 1) $link_string.= '<a href="' . sprintf($this->baseurl, (($cur_window_num - 1) * $this->_maxbuttons)) . '">...</a>'."\n";

      	//Dump buttons
        for ($jump_to_page = 1 + (($cur_window_num - 1) * $this->_maxbuttons); ($jump_to_page <= ($cur_window_num * $this->_maxbuttons)) && ($jump_to_page <= $this->number_of_pages); $jump_to_page++)
        {
        	if ($jump_to_page == $this->current_page)
            {
          		$link_string .= '<span class="current">' . $jump_to_page . '</span>'."\n";
        	}
            else
            {
          		$link_string .= '<a href="' . sprintf($this->baseurl, $jump_to_page) . '" >' . $jump_to_page . '</a>'."\n";
        	}
      	}

      	if ($cur_window_num < $max_window_num) $link_string .= '<a href="' . sprintf($this->baseurl, (($cur_window_num) * $this->_maxbuttons + 1)) . '">...</a>'."\n";

        //Dump next button
      	if (($this->current_page < $this->number_of_pages) && ($this->number_of_pages != 1)) $link_string .= '<a href="' . sprintf($this->baseurl, ($this->current_page + 1)) . '" class="prevnext">'.$this->_nextcaption.'</a>'."\n";
        else $link_string .= '<a class="disabled">'.$this->_nextcaption.'</a>'."\n";

        $link_string.="</div>";

	    echo $link_string;

	}
}

?>