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

use_unit("classes.inc.php");

/**
*
*/
define('taNone','taNone');
define('taLeft','taLeft');
define('taCenter','taCenter');
define('taRight','taRight');
define('taJustify','taJustify');

define('fsNormal','fsNormal');
define('fsItalic','fsItalic');
define('fsOblique','fsOblique');

define('caCapitalize','caCapitalize');
define('caUpperCase','caUpperCase');
define('caLowerCase','caLowerCase');
define('caNone','caNone');

define('vaNormal','vaNormal');
define('vaSmallCaps','vaSmallCaps');

define('psDash', 'psDash');
define('psDashDot', 'psDashDot');
define('psDashDotDot', 'psDashDotDot');
define('psDot', 'psDot');
define('psSolid', 'psSolid');

define('FLOW_LAYOUT','FLOW_LAYOUT');
define('XY_LAYOUT','XY_LAYOUT');
define('ABS_XY_LAYOUT','ABS_XY_LAYOUT');
define('REL_XY_LAYOUT','REL_XY_LAYOUT');
define('GRIDBAG_LAYOUT','GRIDBAG_LAYOUT');
define('ROW_LAYOUT','ROW_LAYOUT');
define('COL_LAYOUT','COL_LAYOUT');


/**
 * Layout encapsulation to allow any component to hold
 * controls and render them in very different ways
 *
 * @see FocusControl::readLayout()
 *
 */
class Layout extends Persistent
{
            public $_control=null;

            private $_type=ABS_XY_LAYOUT;

        /**
        * Type of this layout, it can be any value of the available ones:
        *
        * FLOW_LAYOUT - Controls are rendered without any layout, that is, one after another
        *
        * XY_LAYOUT - Controls are rendered in their fixed pos, but using HTML tables
        *
        * ABS_XY_LAYOUT - Controls are rendered using absolute position
        *
        * REL_XY_LAYOUT - Controls are rendered using relative positions
        *
        * GRIDBAG_LAYOUT - Controls are rendered in a grid, you can set the Rows and Cols
        *
        * ROW_LAYOUT - Controls are rendered in a single row, Cols property sets how many cells
        *
        * COL_LAYOUT - Controls are rendered in a single column, Rows property sets how many cells
        *
        * @return enum
        */
            function getType() { return $this->_type; }
            function setType($value) { $this->_type=$value; }
            function defaultType() { return ABS_XY_LAYOUT; }

            protected $_rows=5;

            function readOwner()
            {
                return($this->_control);
            }

        /**
        * Rows for this layout, used in GRIDBAG_LAYOUT and COL_LAYOUT
        * @see getCols()
        * @return integer
        */
            function getRows() { return $this->_rows; }
            function setRows($value) { $this->_rows=$value; }
            function defaultRows() { return 5; }

            protected $_cols=5;

        /**
        * Columns for this layout, used in GRIDBAG_LAYOUT and ROW_LAYOUT
        * @see getRows()
        * @return integer
        */
            function getCols() { return $this->_cols; }
            function setCols($value) { $this->_cols=$value; }
            function defaultCols() { return 5; }

            protected $_usepixeltrans=1;

            /**
            * Specifies if the code generated should use a transparent pixel or not
            *
            * To preserve compatibility with older browsers, tables must use a transparent
            * pixel on empty cells to make the table behave correctly, on modern browsers
            * you can set this property to false.
            *
            * @return boolean
            */
            function getUsePixelTrans() { return $this->_usepixeltrans; }
            function setUsePixelTrans($value) { $this->_usepixeltrans=$value; }
            function defaultUsePixelTrans() { return 1; }

        /**
        * Dump an absolute layout
        *
        * Dump all controls on the layout using absolute pixel coordinates.
        *
        * @param array $exclude Classnames of the controls you want to exclude from dumping
        */
            function dumpABSLayout($exclude=array())
            {
                if ($this->_control!=null)
                {
                        reset($this->_control->controls->items);
                        while (list($k,$v)=each($this->_control->controls->items))
                        {
                                if (!empty($exclude))
                                {
                                        if (in_array($v->classname(),$exclude))
                                        {
                                                continue;
                                        }
                                }
                                $dump=false;
                                if( $v->Visible && !$v->IsLayer )
                                {
                                    if( $this->_control->methodExists('getActiveLayer') )
                                    {
                                        $dump = ( (string)$v->Layer == (string)$this->_control->Activelayer );
                                    }
                                    else
                                    {
                                        $dump = true;
                                    }
                                }

                                if ($dump)
                                {
                                        $left=$v->Left;
                                        $top=$v->Top;
                                        $aw=$v->Width;
                                        $ah=$v->Height;

                                        $style="Z-INDEX: $k; LEFT: ".$left."px; WIDTH: ".$aw."px; POSITION: absolute; TOP: ".$top."px; HEIGHT: ".$ah."px";

                                        echo "<div id=\"".$v->_name."_outer\" style=\"$style\">\n";
                                        $v->show();
                                        echo "\n</div>\n";
                                }
                        }
                }
            }


            /**
            * Compares top position of two objects, for internal use
            *
            * @see dumpRELLayout
            *
            * @return integer 0=top are equals, +1 $a->Top > $b->Top, -1 $a->Top < $b->Top
            */
            function cmp_obj($a, $b)
            {
                $al = $a->Top;
                $bl = $b->Top;
                if ($al == $bl) {
                    return 0;
                }
                return ($al > $bl) ? +1 : -1;
            }


        /**
        * Dump a fixed coordinate layout using relative coordinates
        *
        * Dump all controls in the layout generating div tags using relative coordinates
        *
        * @param array $exclude Classnames of the controls you want to exclude from dumping
        */
            function dumpRELLayout($exclude=array())
            {
                if ($this->_control!=null)
                {
                        reset($this->_control->controls->items);
                        $shift = 0;

                        $arrayOfControls = $this->_control->controls->items;
                        usort($arrayOfControls, array(&$this, "cmp_obj"));

                        while (list($k,$v)=each($arrayOfControls))
                        {
                                if (!empty($exclude))
                                {
                                        if (in_array($v->classname(),$exclude))
                                        {
                                                continue;
                                        }
                                }
                                $dump=false;
                                if( $v->Visible && !$v->IsLayer )
                                {
                                    if( $this->_control->methodExists('getActiveLayer') )
                                    {
                                        $dump = ( (string)$v->Layer == (string)$this->_control->Activelayer );
                                    }
                                    else
                                    {
                                        $dump = true;
                                    }
                                }

                                if ($dump)
                                {
                                        $left=$v->Left;
                                        $top=$v->Top;
                                        $aw=$v->Width;
                                        $ah=$v->Height;
                                        $top = $top - $shift;
                                        $shift= $shift + $v->Height;

                                        $style="Z-INDEX: $k; LEFT: ".$left."px; WIDTH: ".$aw."px; POSITION: relative; TOP: ".$top."px; HEIGHT: ".$ah."px";

                                        echo "<div id=\"".$v->_name."_outer\" style=\"$style\">\n";
                                        $v->show();
                                        echo "\n</div>\n";
                                }
                        }
                }
            }

        /**
        * Dump a fixed coordinate layout using tables
        *
        * Dump all controls in the layout generating tables and placing controls
        * inside the right cells.
        *
        * @param array $exclude Classnames of the controls you want to exclude from dumping
        */
            function dumpXYLayout($exclude=array())
            {
                        $x=array();
                        $y=array();
                        $pos=array();
                        //Iterates through controls calling show for all of them

                        reset($this->_control->controls->items);
                        while (list($k,$v)=each($this->_control->controls->items))
                        {
                                $dump=false;

                                if( $v->Visible && !$v->IsLayer )
                                {
                                    if( $this->_control->methodExists('getActiveLayer') )
                                    {
                                        $dump = ( (string)$v->Layer == (string)$this->_control->Activelayer );
                                    }
                                    else
                                    {
                                        $dump = true;
                                    }
                                }

                                if ($dump)
                                {
                                        $left=$v->Left;
                                        $top=$v->Top;
                                        $aw=$v->Width;
                                        $ah=$v->Height;

                                        $x[]=$left;
                                        $x[]=$left+$aw;
                                        $y[]=$top;
                                        $y[]=$top+$ah;

                                        $pos[$left][$top]=$v;
                                }
                        }

                        $width=$this->_control->Width;
                        $height=$this->_control->Height;

                        $x[]=$width;
                        $y[]=$height;

                        sort($x);
                        sort($y);


                                //Dumps the inner controls
                                if ($this->_control->controls->count()>=1)
                                {
                                        $widths=array();
                                        reset($x);
                                        if ($x[0]!=0) $widths[]=$x[0];
                                        while (list($k,$v)=each($x))
                                        {
                                                if ($k<count($x)-1)
                                                {
                                                        if ($x[$k+1]-$v!=0) $widths[]=$x[$k+1]-$v;
                                                }
                                                else $widths[]="";
                                        }

                                        $heights=array();
                                        reset($y);
                                        if ($y[0]!=0) $heights[]=$y[0];
                                        while (list($k,$v)=each($y))
                                        {
                                                if ($k<count($y)-1)
                                                {
                                                        if ($y[$k+1]-$v!=0) $heights[]=$y[$k+1]-$v;
                                                }
                                                else $heights[]="";
                                        }


                                        $y=0;
                                        reset($heights);

                                        while (list($hk,$hv)=each($heights))
                                        {
                                                        if ($hv!="")
                                                        {

                                                        }
                                                        else continue;


                                                $rspan=false;

                                                $x=0;
                                                reset($widths);

                                                ob_start();
                                                while (list($k,$v)=each($widths))
                                                {
                                                        $cs=1;
                                                        $rs=1;


                                                        if (isset($pos[$x][$y]))
                                                        {
                                                                if ((!is_object($pos[$x][$y]))  && ($pos[$x][$y]==-1))
                                                                {
                                                                        $x+=$v;
                                                                        continue;
                                                                }
                                                        }

                                                        if (isset($pos[$x][$y]))
                                                        {
                                                                $control=$pos[$x][$y];
                                                        }
                                                        else $control=null;

                                                        $w=0;

                                                        if (is_object($control))
                                                        {
                                                                $w=$control->Width;
                                                                $h=$control->Height;

                                                                $tv=0;
                                                                $th=0;

                                                                $also=array();

                                                                for ($kkk=$hk;$kkk<count($heights);$kkk++)
                                                                {
                                                                        if ($heights[$kkk]!='')
                                                                        {
                                                                                $tv+=$heights[$kkk];
                                                                                if ($h>$tv)
                                                                                {
                                                                                        $rs++;
                                                                                        $pos[$x][$y+$tv]=-1;
                                                                                        $also[]=$y+$tv;
                                                                                }
                                                                                else break;
                                                                        }
                                                                }

                                                                for ($ppp=$k;$ppp<count($widths);$ppp++)
                                                                {
                                                                        if ($widths[$ppp]!='')
                                                                        {
                                                                                $th+=$widths[$ppp];

                                                                                if ($w>$th)
                                                                                {
                                                                                        $cs++;
                                                                                        $pos[$x+$th][$y]=-1;

                                                                                        reset($also);
                                                                                        while(list($ak,$av)=each($also))
                                                                                        {
                                                                                                $pos[$x+$th][$av]=-1;
                                                                                        }
                                                                                }
                                                                                else break;
                                                                        }
                                                                }
                                                        }


                                                        $width="";
                                                        if ($v!="")
                                                        {
                                                                $zv=round(($v*100)/$this->_control->Width,2);
                                                                $zv.="%";
                                                                $width=" width=\"$v\" ";
                                                        }

                                                        if ($rs!=1)
                                                        {
                                                                $rspan=true;
                                                                $rs=" rowspan=\"$rs\" ";
                                                        }
                                                        else $rs="";

                                                        if ($cs!=1)
                                                        {
                                                                $cs=" colspan=\"$cs\" ";
                                                                $width="";
                                                        }
                                                        else $cs="";

                                                        $hh="";

                                                        echo "<td $width $hh $rs $cs valign=\"top\">";

                                                        if (is_object($control))
                                                        {
                                                                echo "<div id=\"".$control->Name."_outer\">\n";
                                                                $control->show();
                                                                echo "\n</div>\n";
                                                        }
                                                        else
                                                        {
                                                                if ($this->_usepixeltrans) echo "<img src=\"vcl/images/pixel_trans.gif\" width=\"1\" height=\"1\">";
                                                        }

                                                        echo "</td>\n";
                                                        $x+=$v;
                                                }
                                                $trow=ob_get_contents();
                                                ob_end_clean();
                                                if ($hv!="")
                                                {
                                                        $zhv=round(($hv*100)/$this->_control->Height,2);
                                                        $zhv.="%";
                                                        echo "<tr height=\"$hv\">";
                                                }
                                                echo $trow;
                                                echo "</tr>\n";
                                                $y+=$hv;
                                        }
                                }
                                else
                                {
                                        echo "<tr><td>";
                                        if ($this->_usepixeltrans) echo "<img src=\"vcl/images/pixel_trans.gif\" width=\"1\" height=\"1\">";
                                        echo "</td></tr>";
                                }

                        reset($this->_control->controls->items);
                        while (list($k,$v)=each($this->_control->controls->items))
                        {
                                if (($v->Visible) && ($v->IsLayer))
                                {
                                        echo "<div id=\"".$v->Name."_outer\">\n";
                                        $v->show();
                                        echo "\n</div>\n";
                                }
                        }
            }

        /**
        * Dump a flow layout, basically, no layout at all
        *
        * This type of layout simply dumps controls in their creation order, one
        * after another.
        *
        * @param array $exclude Classnames of the controls you want to exclude from dumping
        */
            function dumpFlowLayout($exclude=array())
            {
                //Iterates through controls calling show for all of them
                reset($this->_control->controls->items);
                while (list($k,$v)=each($this->_control->controls->items))
                {
                        if (!empty($exclude))
                        {
                                if (in_array($v->classname(),$exclude))
                                {
                                        continue;
                                }
                        }

                        $dump=false;

                        if( $v->Visible && !$v->IsLayer )
                        {
                                if( $this->_control->methodExists('getActiveLayer') )
                                {
                                        $dump = ( (string)$v->Layer == (string)$this->_control->Activelayer );
                                }
                                else
                                {
                                        $dump = true;
                                }
                        }

                        if ($dump)
                        {
                                echo "<span id=\"".$v->Name."_outer\">\n";
                                $v->show();
                                echo "\n</span>\n";
                        }
                }
            }

        /**
        * Dump the layout contents depending on the layout type.
        *
        * It checks the type it has to dump
        * and calls the appropiate method, you can also exclude certain controls to be rendered by
        * passing an array with the classnames of the components you don't want to get rendered
        *
        * @param array $exclude Classnames of the controls you want to exclude from dumping
        */
            function dumpLayoutContents($exclude=array())
            {
                switch($this->_type)
                {
                        case COL_LAYOUT: $this->dumpColLayout($exclude); break;
                        case ROW_LAYOUT: $this->dumpRowLayout($exclude); break;
                        case GRIDBAG_LAYOUT: $this->dumpGridBagLayout($exclude); break;
                        case ABS_XY_LAYOUT: $this->dumpABSLayout($exclude); break;
                        case REL_XY_LAYOUT: $this->dumpRELLayout($exclude); break;
                        case XY_LAYOUT: $this->dumpXYLayout($exclude); break;
                        case FLOW_LAYOUT: $this->dumpFlowLayout($exclude); break;
                }
            }

        /**
        * Dump a table layout
        *
        * This method dump all controls inside using the cols and rows set and using
        * tables.
        *
        * @param array $exclude Classnames of the controls you want to exclude from dumping
        */
            function dumpGridBagLayout($exclude=array())
            {
                    $this->dumpGrid($exclude, $this->_cols, $this->_rows, "100%");
            }

        /**
        * Dump a row layout
        *
        * Dumps a 1 row layout.
        *
        * @param array $exclude Classnames of the controls you want to exclude from dumping
        */
            function dumpRowLayout($exclude=array())
            {
                    $this->dumpGrid($exclude, $this->_cols, 1, "100%");
            }

        /**
        * Dump a col layout
        *
        * Dumps a 1 col layout
        *
        * @param array $exclude Classnames of the controls you want to exclude from dumping
        */
            function dumpColLayout($exclude=array())
            {
                    $this->dumpGrid($exclude, 1, $this->_rows, "100%");
            }

        /**
        * Dump a grid layout
        *
        * This method is used for rowlayout, collayout and grid layout.
        *
        * @param array $exclude Classnames of the controls you want to exclude from dumping
        * @param integer $cols Number of columns for the grid
        * @param integer $rows Number of rows for the grid
        * @param string $width Width for the layout
        */
            function dumpGrid($exclude=array(),$cols,$rows,$width)
            {
                    $pwidth=$this->_control->Width;
                    $pheight=$this->_control->Height;

                    $cwidth = round($pwidth / $cols,0);
                    $cheight = round($pheight / $rows,0);

                    $controls=array();
                        reset($this->_control->controls->items);
                        while (list($k,$v)=each($this->_control->controls->items))
                        {
                            $col=round($v->Left / $cwidth,0);
                            $row=round($v->Top / $cheight,0);

                            $controls[$col][$row]=$v;
                        }

                    echo "<table width=\"$width\" height=\"$pheight\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
                    for($y=0;$y<=$rows-1;$y++)
                    {
                        echo "<tr>\n";
                        for($x=0;$x<=$cols-1;$x++)
                        {
                            if (isset($controls[$x][$y]))
                            {
                                $v=$controls[$x][$y];
                                if (is_object($v))
                                {
                                    $v->AdjustToLayout=true;

                                    $cspan="";
                                    $rspan="";

                                    $cspan = round(($v->Width / $cwidth),0);
                                    if ($cspan > 1)
                                    {
                                        //for ($xx=$x+1;$xx<=$x+$cspan;$xx++)  $controls[$xx][$y]=-1;
                                    }

                                    $rspan = round(($v->Height / $cheight),0);
                                    if ($rspan > 1)
                                    {
                                        //for ($yy=$y+1;$yy<=$y+$rspan;$yy++)  $controls[$x][$yy]=-1;
                                    }


                                    for ($xx=$x;$xx<$x+$cspan;$xx++)
                                    {
                                        for ($yy=$y;$yy<$y+$rspan;$yy++)
                                        {
                                            $controls[$xx][$yy]=-1;
                                        }
                                    }


                                    if ($cspan>1) $cspan=" colspan=\"$cspan\" ";
                                    else $cspan="";

                                    if ($rspan>1) $rspan=" rowspan=\"$rspan\" ";
                                    else $rspan="";

                                    $pw=round((100*$v->Width)/$pwidth);
                                    $pw=" width=\"$pw%\" ";

                                    $ph=round((100*$v->Height)/$pheight);
                                    $ph=" height=\"$ph%\" ";

                                    echo "<td valign=\"top\" $pw $ph $cspan $rspan>\n";
                                        echo "<div id=\"".$v->Name."_outer\" style=\"height:100%;width:100%;\">\n";
                                        $v->show();
                                        echo "\n</div>\n";
                                    echo "\n</td>\n";
                                }
                            }
                            else
                            {
                                echo "<td>&nbsp;\n";
                                echo "</td>\n";
                            }
                        }
                        echo "</tr>\n";
                    }
                    echo "</table>\n";
            }
}

/**
 * Font encapsulates all properties required to represent a font on the browser.
 *
 * Font describes font characteristics used when displaying text. Font defines a set
 * of characters by specifying the height, font name (typeface), attributes (such as bold or
 * italic) and so on.
 *
 * @see Control::readFont()
 *
 */
class Font extends Persistent
{
        protected $_family="Verdana";
        protected $_size="10px";
        protected $_color="";
        protected $_weight="";
        protected $_align="taNone";
        protected $_style="";
        protected $_case="";
        protected $_variant="";
        protected $_lineheight="";

        public $_control=null;

        private $_updatecounter = 0;

        /**
        * Assign Font object to another Font object, this is done by assigning
        * all Font properties from one object to another
        *
        * @param object $dest Destination, where the new font settings are assigned to.
        */
        function assignTo($dest)
        {
                // make sure modified() is not always called while assigning new values
                $dest->startUpdate();

                $dest->setFamily($this->getFamily());
                $dest->setSize($this->getSize());
                $dest->setColor($this->getColor());
                $dest->setAlign($this->getAlign());
                $dest->setStyle($this->getStyle());
                $dest->setCase($this->getCase());
                $dest->setLineHeight($this->getLineHeight());
                $dest->setVariant($this->getVariant());
                $dest->setWeight($this->getWeight());

                $dest->endUpdate();
        }

        function readOwner()
        {
                return($this->_control);
        }

        /**
        * Call startUpdate() when multiple properties of the Font are updated at
        * the same time. Once finished updating, call endUpdate().
        * It prevents the updating of the control where the Font is assigned to
        * until the endUpdate() function is called.
        */
        function startUpdate()
        {
                $this->_updatecounter++;
        }

        /**
        * Re-enables the notification mechanism to the control.
        * Note: endUpdate() has to be called as many times as startUpdate() was
        *       called on the same Font object.
        */
        function endUpdate()
        {
                $this->_updatecounter--;
                // let's just make sure that if the endUpdate() is called too many times
                // that the $this->_updatecounter is valid and the font is updated
                if ($this->_updatecounter < 0)
                {
                        $this->_updatecounter = 0;
                }
                // when finished updating call the modified() function to notify the control.
                if ($this->_updatecounter == 0)
                {
                        $this->modified();
                }
        }

        /**
        * Indicates if the Font object is in update mode. If true, the control
        * where the Font is assigned to will not be notified when a property changes.
        * @return bool
        */
        function isUpdating()
        {
                return $this->_updatecounter != 0;
        }

        /**
         * Check if the font has been modified to set to false the parentfont
         * property of the control, if any
         */
        function modified()
        {
                if (!$this->isUpdating() && $this->_control!=null  && ($this->_control->_controlstate & csLoading) != csLoading && $this->_control->_name != "")
                {
                        $f=new Font();
                        $fstring=$f->readFontString();

                        $tstring=$this->readFontString();


                        if ($this->_control->ParentFont)
                        {
                                $parent=$this->_control->Parent;
                                if ($parent!=null) $fstring=$parent->Font->readFontString();
                        }

                        // check if font changed and if the ParentFont can be reset
                        if ($fstring!=$tstring && $this->_control->DoParentReset)
                        {
                                $c=$this->_control;
                                $c->ParentFont = 0;
                        }

                        if ($this->_control->methodExists("updateChildrenFonts"))
                        {
                                $this->_control->updateChildrenFonts();
                        }
                }
        }


        /**
        * Font list to be used to render this font, this should be an HTML font
        * family specifier
        *
        * @link http://www.w3.org/TR/REC-CSS2/fonts.html#font-family-prop
        *
        * @return string
        */
        function getFamily() { return $this->_family;   }
        function setFamily($value) { $this->_family=$value; $this->modified(); }
        function defaultFamily() { return "Verdana";   }

        /**
        * Size to be used to render this font, you can use a unit specifier, for example
        * px, or em
        *
        * @link http://www.w3.org/TR/REC-CSS2/fonts.html#font-size-props
        *
        * @return string
        */
        function getSize() { return $this->_size;       }
        function setSize($value) { $this->_size=$value; $this->modified(); }
        function defaultSize() { return "10px";       }

        /**
        * Height for this font, this correspond to the line paragraph
        *
        * @link http://www.w3.org/TR/REC-CSS2/visudet.html#propdef-line-height
        *
        * @return string
        */
        function getLineHeight() { return $this->_lineheight;       }
        function setLineHeight($value) { $this->_lineheight=$value; $this->modified(); }
        function defaultLineHeight() { return "";       }

        /**
        * Style to be used to render this font, can be one of these values:
        * <pre>
        * fsNormal - No changes applied to the font face
        * fsItalic - Text is rendered in Italic
        * fsOblique - Text is rendered in Oblique
        * </pre>
        * @return string
        */
        function getStyle() { return $this->_style;       }
        function setStyle($value) { $this->_style=$value; $this->modified(); }
        function defaultStyle() { return "";       }

        /**
        * Case conversion to be used to render this font, it allows you to set
        * a modifier to the case the user will see without affecting the information
        *
        * @link http://www.w3.org/TR/REC-CSS2/text.html#propdef-text-transform
        *
        * @return string
        */
        function getCase() { return $this->_case;       }
        function setCase($value) { $this->_case=$value; $this->modified(); }
        function defaultCase() { return "";       }

        /**
        * Variant conversion to be used to render this font
        *
        * @link http://www.w3.org/TR/REC-CSS2/fonts.html#propdef-font-variant
        *
        * @return string
        */
        function getVariant() { return $this->_variant;       }
        function setVariant($value) { $this->_variant=$value; $this->modified(); }
        function defaultVariant() { return "";       }

        /**
        * Color for this font, it should be an HTML valid color, i.e. #FF0000
        * @return string
        */
        function getColor() { return $this->_color;       }
        function setColor($value) { $this->_color=$value; $this->modified(); }
        function defaultColor() { return "";       }

        /**
        * Specifies the alignment to be used for this font
        * @return string
        */
        function getAlign() { return $this->_align;       }
        function setAlign($value) { $this->_align=$value; $this->modified(); }
        function defaultAlign() { return taNone;       }

        /**
        * Specifies the weight (boldness) for this font
        * @return enum
        */
        function getWeight() { return $this->_weight;   }
        function setWeight($value) { $this->_weight=$value; $this->modified(); }
        function defaultWeight() { return "";       }

        /**
         * Returns an style string to be asigned to the tag, it uses all the
         * Font properties to create an style string to be used with an HTML tag
         *
         * @return string
         */
        function readFontString()
        {
                /*
                if ($this->_control!=null)
                {
                        if ($this->_control->ParentFont)
                        {
                                $parent=$this->_control->Parent;
                                if ($parent!=null) return($parent->Font->readFontString());
                        }
                }
                */

                $textalign="";
                switch($this->_align)
                {
                        case taLeft: $textalign="text-align: left;"; break;
                        case taRight: $textalign="text-align: right;"; break;
                        case taCenter: $textalign="text-align: center;"; break;
                        case taJustify: $textalign="text-align: justify;"; break;
                }

                $fontstyle="";
                switch($this->_style)
                {
                        case fsNormal: $fontstyle="font-style: normal;"; break;
                        case fsItalic: $fontstyle="font-style: italic;"; break;
                        case fsOblique: $fontstyle="font-style: oblique;"; break;
                }

                $fontvariant="";
                switch($this->_variant)
                {
                        case vaNormal: $fontstyle="font-variant: normal;"; break;
                        case vaSmallCaps: $fontstyle="font-variant: small-caps;"; break;
                }

                $texttransform="";
                switch($this->_case)
                {
                        case caCapitalize: $texttransform="text-transform: capitalize;"; break;
                        case caUpperCase: $texttransform="text-transform: uppercase;"; break;
                        case caLowerCase: $texttransform="text-transform: lowercase;"; break;
                        case caNone: $texttransform="text-transform: none;"; break;
                }

                $color="";
                if ($this->_color!="") $color="color: $this->_color;";

                $lineheight="";
                if ($this->_lineheight!="") $lineheight="line-height: $this->_lineheight;";

                $fontweight="";
                if ($this->_weight!="") $fontweight="font-weight: $this->_weight;";


                $result=" font-family: $this->_family; font-size: $this->_size; $color$fontweight$textalign$fontstyle$lineheight$fontvariant$texttransform ";
                return($result);
        }
}

/**
 * Pen is used to draw lines or outline shapes on a canvas.
 *
 * Use Pen to describe the attributes of a pen when drawing something to a canvas (Canvas).
 * Pen encapsulates the pen properties that are selected into the canvas.
 *
 * <code>
 * <?php
 *   function PaintBox1Paint($sender, $params)
 *   {
 *    $this->PaintBox1->Canvas->Pen->Color="#FF0000";
 *    $this->PaintBox1->Canvas->Line(0,0,100,100);
 *
 *    $this->PaintBox1->Canvas->Brush->Color="#00FF00";
 *    $this->PaintBox1->Canvas->Rectangle(100,100,200,200);
 *
 *    $this->PaintBox1->Canvas->TextOut(50,50, "VCL for PHP Canvas");
 *   }
 * ?>
 * </code>
 *
 * @see Canvas::getPen()
 *
 */
class Pen extends Persistent
{
        protected $_color="#000000";
        protected $_width="1";
//        protected $_style=psSolid;
        protected $_modified=0;
        public $_control=null;

        function readOwner()
        {
            return($this->_control);
        }

        function assignTo($dest)
        {
                $dest->Color=$this->Color;
                $dest->Width=$this->Width;
//                $dest->Style=$this->Style;
        }

        /**
        * Set this Pen as being modified
        */
        function modified()             { $this->_modified=1; }

        /**
        * Returns true if the properties of the Pen has been modified
        *
        * @return boolean
        */
        function isModified()           { return $this->_modified; }

        /**
        * Sets the modified flag to 0
        */
        function resetModified()        { $this->_modified = 0; }

        /**
        * Determines the color used to draw lines on the canvas.
        *
        * Set Color to change the color used to draw lines or outline shapes.
        *
        * @return string
        */
        function getColor()             { return $this->_color; }
        function setColor($value)       { $this->_color=$value; $this->modified(); }
        function defaultColor()         { return "#000000"; }

        /**
        * Specifies the width of the pen in pixels.
        *
        * Use Width to give the line greater weight. If you attempt to set Width to a
        * value less than 0, the new value is ignored.
        *
        * @return integer
        */
        function getWidth()             { return $this->_width; }
        function setWidth($value)       { $this->_width=$value; $this->modified(); }
        function defaultWidth()         { return "1"; }

        //TODO: Style property
        //Style property
//        function getStyle()             { return $this->_style; }
//        function setStyle($value)       { $this->_style=$value; }
//        function defaultStyle()         { return psSolid; $this->modified(); }
}

/**
 * Brush represents the color and pattern used to fill solid shapes.
 *
 * Brush encapsulates several properties to hold all the attributes to fill solid shapes,
 * such as rectangles and ellipses, with a color or pattern.
 *
 * @see Canvas::getBrush()
 */
class Brush extends Persistent
{
        protected $_color="#FFFFFF";
        protected $_modified=0;
        public $_control=null;

        function readOwner()
        {
            return($this->_control);
        }

        function assignTo($dest)
        {
                $dest->Color=$this->Color;
        }

        /**
        * Mark the brush as modified.
        *
        * This method marks the brush as modified by setting an internal flag to 1
        *
        * @see isModified()
        * @see resetModified()
        */
        function modified()             { $this->_modified=1; }

        /**
        * Returns the status of the internal flag for modified state
        *
        * This function returns the status of the internal flag that marks this brush as modified
        *
        * @see modified()
        * @see resetModified()
        *
        * @return integer
        */
        function isModified()           { return $this->_modified; }

        /**
        * Mark the brush as not modified.
        *
        * This method resets the internal flag to specify it has not been modified
        *
        * @see isModified()
        * @see modified()
        */
        function resetModified()        { $this->_modified = 0; }

        /**
        * Indicates the color of the brush.
        *
        * The Color property determines the color of the brush. This is the color
        * that is used to draw the pattern.
        *
        * @return string
        */
        function getColor()             { return $this->_color; }
        function setColor($value)       { $this->_color=$value; $this->modified(); }
        function defaultColor() { return "";       }
}

/**
 * Create color based on HEX RGB mask
 *
 * This function creates a color using an hexadecimal RGB mask, the mask can be prefixed with #
 * and it returns the color resource.
 *
 * @param resource $img Image resource
 * @param string $hexColor Color in HTML format
 * @return int
 *
 */
function colorFromHex($img, $hexColor)
{
        while (strlen($hexColor) > 6) { $hexColor = substr($hexColor, 1);  };
        sscanf($hexColor, "%2x%2x%2x", $red, $green, $blue);
        return ImageColorAllocate($img, $red, $green, $blue);
}

/**
 * Create Pen based on PenStyle
 *
 * This function creates an array depending on the pen style to represent the
 * pattern for such pen.
 *
 * @param resource $img Image resource to work with
 * @param string $penStyle Style of the pen to create
 * @param string $baseColor Base color to use to create the pen
 * @param string $bgColor Background color to use to create the pen
 * @return array
 */
function createPenStyle($img, $penStyle, $baseColor, $bgColor)
{
        $b  = ColorFromHex($img, $bgColor);
        $w  = ColorFromHex($img, $baseColor);

        switch ($penStyle)
        {
                case psDash:
                        return array($w, $w, $w, $w, $b, $b, $b, $b);
                        break;
                case psDashDot:
                        return array($w, $w, $w, $w, $b, $b, $w, $b, $b);
                        break;
                case psDot:
                        return array($w, $b, $b, $w, $b, $b);
                        break;
                case psDashDotDot:
                        return array($w, $w, $w, $w, $b, $w, $b, $w, $b);
                        break;
                default:
                  //psSolid
                        return array($w);
                        break;
        }
}

/**
 * Canvas provides an abstract drawing space for objects that must render their own images.
 *
 * Use Canvas as a drawing surface for objects that draw an image of themselves.
 * Standard controls such as edit controls or list boxes do not require a canvas, as they are drawn by the browser, but
 * Graphic controls can use a canvas to generate an image in run-time
 *
 * Canvas provides properties, events and methods that assist in creating an image by
 *
 * Specifying the type of brush, pen and font to use.
 *
 * Drawing and filling a variety of shapes and lines.
 *
 * Writing text.
 *
 * Rendering graphic images.
 *
 * <code>
 * <?php
 *   function PaintBox1Paint($sender, $params)
 *   {
 *    $this->PaintBox1->Canvas->Pen->Color="#FF0000";
 *    $this->PaintBox1->Canvas->Line(0,0,100,100);
 *
 *    $this->PaintBox1->Canvas->Brush->Color="#00FF00";
 *    $this->PaintBox1->Canvas->Rectangle(100,100,200,200);
 *
 *    $this->PaintBox1->Canvas->TextOut(50,50, "VCL for PHP Canvas");
 *   }
 * ?>
 * </code>
 *
 * @see Pen, Brush
 * @example Canvas/TestCanvas.php How to use Canvas
 *
 */
class Canvas extends Persistent
{
        protected $_pen=null;
        protected $_brush=null;
        protected $_font=null;
        protected $_canvas="";
        protected $_object="";
        protected $_owner=null;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->_pen=new Pen();
                $this->_pen->Width=1;
                $this->_brush=new Brush();
                $this->_font=new Font();
                $this->_owner=$aowner;
        }

        /**
        * Intermal method
        *
        * This method is used to set the color for the canvas to the brush color if the brush has been modified.
        *
        */
        protected function forceBrush()
        {
                if ($this->_brush->isModified())
                {
                        echo "$this->_canvas.setColor(\"" . $this->_brush->Color . "\");\n";
                        $this->_brush->resetModified();
                        $this->_pen->modified();
                }
        }

        /**
        * Intermal method
        *
        * This method is used to set the stroke color for the canvas to the pen color if the pen has been modified.
        *
        */
        protected function forcePen()
        {
                if ($this->_pen->isModified())
                {
                        echo "$this->_canvas.setStroke(" . $this->_pen->Width . ");\n";
                        echo "$this->_canvas.setColor(\"" . $this->_pen->Color . "\");\n";
                        $this->_pen->resetModified();
                        $this->_brush->modified();
                }
        }

        /**
        * Intermal method
        *
        * This method is used to set the font for the canvas to the font property
        *
        */
        protected function forceFont()
        {
                echo "$this->_canvas.setFont(\"" . $this->_font->Family . "\", \"" . $this->_font->Size . "\", \"" . $this->_font->Style . "\");\n";
                if ($this->_font->Color != '') echo "$this->_canvas.setColor(\"" . $this->_font->Color . "\");\n";
        }

        /**
        * This method dumps the .js required to initiate graphic library
        *
        */
        function initLibrary()
        {
                if (!defined('COMMON_JS'))
                {
                  echo "<script type=\"text/javascript\" src=\"".VCL_HTTP_PATH."/js/common.js\"></script>\n";
                  define('COMMON_JS',1);
                }

                if (!defined('JSCANVAS'))
                {
                        echo "<script type=\"text/javascript\" src=\"" . VCL_HTTP_PATH . "/walterzorn/wz_jsgraphics.js\"></script>\n";
                        define('JSCANVAS', 1);
                }

                if (is_object($this->_owner))
                {
                        $this->SetCanvasProperties($this->_owner->Name);
                }
        }
        function setCanvasProperties($Name)
        {
                $this->_canvas= $Name . "_Canvas";
                $this->_object= $Name;
        }
        /**
         * Begins draw cycle.
         *
         * In VCL for PHP, graphics are drawn on the browser using javascript, and this
         * method is needed to dump the required code to initialize drawing objects and to establishes
         * internal Canvas object.
         *
         * Should be followed by EndDraw to push drawing to the page canvas.
         */
        function beginDraw()
        {
                echo "<script type=\"text/javascript\">\n";
                echo " var cnv=findObj('$this->_object');\n";
                echo " if (cnv==null) cnv=findObj('{$this->_object}_outer');\n";
                echo "  var $this->_canvas = new jsGraphics(cnv);\n";
                $this->_canvas= "  " . $this->_canvas;
        }
        /**
         * Ends draw cycle.
         *
         * In VCL for PHP, graphics are drawn on the browser using javascript, and this
         * method is needed to dump the required code to finalize drawing and to flush out
         * all drawing commands.
         */
        function endDraw()
        {
                $this->Paint();
                echo "</script>\n";
        }
        /**
         * Draws an arc on the image along the perimeter of the ellipse bounded
         * by the specified rectangle.
         *
         * Use Arc to draw an elliptically curved line with the current Pen. The
         * arc traverses the perimeter of an ellipse that is bounded by the points
         * (X1,Y1) and (X2,Y2).
         *
         * The arc is drawn following the perimeter of the ellipse, counterclockwise,
         * from the starting point to the ending point. The starting point is defined
         * by the intersection of the ellipse and a line defined by the center of
         * the ellipse and (X3,Y3). The ending point is defined by the intersection
         * of the ellipse and a line defined by the center of the ellipse and (X4, Y4).
         *
         * @param int $x1 The left point at pixel coordinates
         * @param int $y1 The top point at pixel coordinates
         * @param int $x2 The right point at pixel coordinates
         * @param int $y2 The bottom point at pixel coordinates
         * @param int $x3 The left intersection at pixel coordinates
         * @param int $y3 The top intersection at pixel coordinates
         * @param int $x4 The right intersection at pixel coordinates
         * @param int $y4 The bottom intersection at pixel coordinates
         *
         */
        function arc($x1, $y1, $x2, $y2, $x3, $y3, $x4, $y4)
        {
                $this->forcePen();
                //echo "$this->_canvas.drawArc($x1, $y1, $r * 2, $r * 2, 180, 270);\n";
        }
        /**
         * Draws the ellipse defined by a bounding rectangle on the canvas.
         *
         * Call Ellipse to draw a circle or ellipse on the canvas. Specify the bounding rectangle by giving
         * the top left point at pixel coordinates (X1, Y1) and the bottom right point at (X2, Y2).
         *
         * If the bounding rectangle is a square, a circle is drawn.
         *
         * The ellipse is outlined using the value of Pen, and filled using the value of Brush.
         *
         * @param int $x1 The left point at pixel coordinates
         * @param int $y1 The top point at pixel coordinates
         * @param int $x2 The right point at pixel coordinates
         * @param int $y2 The bottom point at pixel coordinates
         */
        function ellipse($x1, $y1, $x2, $y2)
        {
                $this->forceBrush();
                echo "$this->_canvas.fillEllipse($x1 + 1, $y1+ 1, $x2-$x1+1, $y2-$y1+1);\n";
                $this->forcePen();
                echo "$this->_canvas.drawEllipse($x1, $y1, $x2-$x1+1, $y2-$y1+1);\n";
        }
        /**
         * Fills the specified rectangle on the canvas using the current brush.
         *
         * Use FillRect to fill a rectangular region using the current brush. The region
         * is filled including the top and left sides of the rectangle, but excluding the bottom and right edges.
         *
         * @param int $x1 The left point at pixel coordinates
         * @param int $y1 The top point at pixel coordinates
         * @param int $x2 The right point at pixel coordinates
         * @param int $y2 The bottom point at pixel coordinates
         */
        function fillRect($x1, $y1, $x2, $y2)
        {
                $this->forceBrush();
                echo "$this->_canvas.fillRect($x1, $y1, $x2 - $x1, $y2 - $y1);\n";
        }

        /**
         * Draws a rectangle using the Brush of the canvas to draw the border.
         *
         * Use FrameRect to draw a 1 pixel wide border around a rectangular region.
         * FrameRect does not fill the interior of the rectangle with the Brush pattern.
         *
         * To draw a boundary using the Pen instead, use the Polygon method.
         *
         * @param int $x1 The left point at pixel coordinates
         * @param int $y1 The top point at pixel coordinates
         * @param int $x2 The right point at pixel coordinates
         * @param int $y2 The bottom point at pixel coordinates
         */
        function frameRect($x1, $y1, $x2, $y2)
        {
                $this->forcePen();
                $this->forceBrush();
                echo "$this->_canvas.drawRect($x1, $y1, $x2-$x1+1, $y2-$y1+1);\n";
        }
        /**
         * Draws a line on the canvas using specified coordinates
         *
         * Use Line to draw a 1 pixel wide line from a point (x1,y2) to another point (x2,y2)
         * using the current Pen
         *
         * @param int $x1 The left point at pixel coordinates
         * @param int $y1 The top point at pixel coordinates
         * @param int $x2 The right point at pixel coordinates
         * @param int $y2 The bottom point at pixel coordinates
         */
        function line($x1, $y1, $x2, $y2)
        {
                $this->forcePen();
                echo "$this->_canvas.drawLine($x1, $y1, $x2, $y2);\n";
        }
        /**
         * Draws a series of lines on the canvas connecting the points passed in
         * and closing the shape by drawing a line from the last point to the first point.
         *
         * Use Polygon to draw a closed, many-sided shape on the canvas, using the value of Pen.
         * After drawing the complete shape, Polygon fills the shape using the value of Brush.
         *
         * The Points parameter is an array of points that give the vertices of the polygon.
         *
         * @param array $points An array of x, y interleaved coordinates
         */
        function polygon($points)
        {
                $this->forceBrush();
                $xPoints = "  var Xpoints = new Array(";
                $yPoints = "  var Ypoints = new Array(";
                $count = count($points);
                for ($i = 0; $i < $count; $i += 2) {
                        if ($i > 1) {
                                $xPoints .= ",";
                                $yPoints .= ",";
                        }
                        $xPoints .= $points[$i];
                        $yPoints .= $points[$i+1];
                }
                $xPoints .= ");\n";
                $yPoints .= ");\n";
                echo $xPoints;
                echo $yPoints;
                echo "$this->_canvas.fillPolygon(Xpoints, Ypoints);\n";
                $this->forcePen();
                echo "$this->_canvas.drawPolygon(Xpoints, Ypoints);\n";
        }
        /**
         * Draws a series of lines on the canvas with the current pen, connecting each of the points passed to it in Points.
         *
         * Use Polyline to connect a set of points on the canvas. If you specify only two points, Polyline draws a single line.
         *
         * The Points parameter is an array of points to be connected.
         *
         * @param array $points An array of x, y interleaved coordinates
         */
        function polyline($points)
        {
                $this->forcePen();
                $xPoints = "  var Xpoints = new Array(";
                $yPoints = "  var Ypoints = new Array(";
                $count = count($points);
                for ($i = 0; $i < $count; $i += 2) {
                        if ($i > 1) {
                                $xPoints .= ",";
                                $yPoints .= ",";
                        }
                        $xPoints .= $points[$i];
                        $yPoints .= $points[$i+1];
                }
                $xPoints .= ");\n";
                $yPoints .= ");\n";
                echo $xPoints;
                echo $yPoints;
                echo "$this->_canvas.drawPolyline(Xpoints, Ypoints);\n";
        }
        /**
         * Draws a rectangle on the canvas.
         *
         * Use Rectangle to draw a rectangle using Pen and fill it with Brush.
         * Specify the rectangle’s coordinates giving four coordinates that define the upper left
         * corner at the point (X1, Y1) and the lower right corner at the point (X2, Y2).
         *
         * To fill a rectangular region without drawing the boundary in the current pen, use FillRect.
         * To outline a rectangular region without filling it, use FrameRect or Polygon. To draw
         * a rectangle with rounded corners, use RoundRect.
         *
         * @param int $x1 The left point at pixel coordinates
         * @param int $y1 The top point at pixel coordinates
         * @param int $x2 The right point at pixel coordinates
         * @param int $y2 The bottom point at pixel coordinates
         */
        function rectangle($x1, $y1, $x2, $y2)
        {
                $this->forceBrush();
                echo "$this->_canvas.fillRect($x1, $y1, $x2 - $x1 + 1, $y2 - $y1 + 1);\n";
                $this->forcePen();
                echo "$this->_canvas.drawRect($x1, $y1, $x2 - $x1 + 1, $y2 - $y1 + 1);\n";
        }
        /**
         * Draws a rectangle with rounded corners on the canvas.
         *
         * Use RoundRect to draw a rounded rectangle using Pen and fill it with Brush.
         * The rectangle will have edges defined by the points (X1,Y1), (X2,Y1), (X2,Y2), (X1,Y2),
         * but the corners will be shaved to create a rounded appearance. The curve of the rounded
         * corners matches the curvature of an ellipse with width W and height H.
         *
         * To draw an ellipse instead, use Ellipse. To draw a true rectangle, use Rectangle.
         *
         * @param int $x1 The left point at pixel coordinates
         * @param int $y1 The top point at pixel coordinates
         * @param int $x2 The right point at pixel coordinates
         * @param int $y2 The bottom point at pixel coordinates
         * @param int $w Width of the ellipse for rounded corners
         * @param int $h Height of the ellipse for rounded corners
         */
        function roundRect($x1, $y1, $x2, $y2, $w, $h)
        {
                $cx = $w/2;
                $cy = $h/2;
                $rw = $x2 - $x1 + 1;
                $rh = $y2 - $y1 + 1;
                $wp = $this->_pen->Width;
                // draw shape
                $this->forceBrush();
                echo "$this->_canvas.fillRect($x1 + $cx, $y1, $rw - $w, $rh);\n";
                echo "$this->_canvas.fillRect($x1, $y1 + $cy, $rw, $rh - $h);\n";
                // draw border
                $this->forcePen();
                echo "$this->_canvas.drawLine($x1 + $cx, $y1, $x2 - $cx, $y1);\n";
                echo "$this->_canvas.drawLine($x1 + $cx, $y2, $x2 - $cx, $y2);\n";
                echo "$this->_canvas.drawLine($x1, $y1 + $cy, $x1, $y2 - $cy);\n";
                echo "$this->_canvas.drawLine($x2, $y1 + $cy, $x2, $y2 - $cy);\n";

                $this->forcePen();
                echo "$this->_canvas.fillArc($x1, $y1, $w, $h, 90, 180);\n";
                echo "$this->_canvas.fillArc($x2 - $w + $wp, $y1, $w, $h + $wp, 0, 90);\n";
                echo "$this->_canvas.fillArc($x1, $y2 - $h + $wp, $w, $h, 180, 270);\n";
                echo "$this->_canvas.fillArc($x2 - $w + $wp, $y2 - $h + $wp, $w, $h, 270, 360);\n";

                $this->forceBrush();
                echo "$this->_canvas.fillArc($x1 + $wp, $y1 + $wp, $w - $wp, $h - $wp, 90, 180);\n";
                echo "$this->_canvas.fillArc($x2 - $w + $wp, $y1 + $wp, $w - $wp, $h - $wp, 0, 90);\n";
                echo "$this->_canvas.fillArc($x1 + $wp, $y2 - $h, $w, $h, 180, 270);\n";
                echo "$this->_canvas.fillArc($x2 - $w, $y2 - $h, $w, $h, 270, 360);\n";


                //echo "$this->_canvas.drawArc($x2 - $r * 2, $y1, $r * 2, $r * 2, 270, 360);\n";
                //echo "$this->_canvas.drawArc($x1, $y2 - $r * 2, $r * 2, $r * 2, 90, 180);\n";
                //echo "$this->_canvas.drawArc($x2 - $r * 2, $y2 - $r * 2, $r * 2, $r * 2, 360, 90);\n";
        }
        /**
         * Draws the graphic specified by the image parameter in the rectangle
         * specified by the coordinates.
         *
         * Call StretchDraw to draw a graphic on the canvas so that the image fits
         * in the specified rectangle. This may involve changing magnification and/or aspect ratio.
         *
         *
         * @param int $x1 The left point at pixel coordinates
         * @param int $y1 The top point at pixel coordinates
         * @param int $x2 The right point at pixel coordinates
         * @param int $y2 The bottom point at pixel coordinates
         * @param string $image URL to the image to draw
         */
        function stretchDraw($x1, $y1, $x2, $y2, $image)
        {
                echo "$this->_canvas.drawImage(\"$image\", $x1, $y1, $x2-$x1+1, $y2-$y1+1);\n";
        }
        /**
         * Writes a string on the canvas, starting at the point (X,Y)
         *
         * Use TextOut to write a string onto the canvas. The string will be written
         * using the current value of Font.
         *
         * @param int $x The left point at pixel coordinates
         * @param int $y The top point at pixel coordinates
         * @param string $text Text to write to the canvas
         */
        function textOut($x, $y, $text)
        {
                $this->forceFont();
                echo "$this->_canvas.drawString(\"$text\", $x, $y);\n";
        }
        /**
         * Draw Bevel-like rectangle using specified colors
         */
        function bevelRect($x1, $y1, $x2, $y2, $color1, $color2)
        {
                $this->forcePen();
                echo "$this->_canvas.setColor(\"" . $color1 . "\");\n";
                echo "$this->_canvas.drawLine($x1, $y2, $x1, $y1);\n";
                echo "$this->_canvas.drawLine($x1, $y1, $x2, $y1);\n";
                echo "$this->_canvas.setColor(\"" . $color2 . "\");\n";
                echo "$this->_canvas.drawLine($x2, $y1, $x2, $y2);\n";
                echo "$this->_canvas.drawLine($x2, $y2, $x1, $y2);\n";
        }
        /**
         * Draw the line using specified color
         */
        function bevelLine($color, $x1, $y1, $x2, $y2)
        {
                $this->forcePen();
                echo "$this->_canvas.setColor(\"" . $color . "\");\n";
                echo "$this->_canvas.drawLine($x1, $y1, $x2, $y2);\n";
        }
        /**
         * Clears the canvas
         *
         * Use this method to erase all the drawings in the canvas
         */
        function clear()
        {
                echo "$this->_canvas.clear();\n";
        }
        /**
         * Paints the canvas
         *
         * After drawing this does the actual painting of the canvas.
         * Only needed when drawing from JavaScript events or from outside
         * this canvas owner OnPaint event.
         */
        function paint()
        {
                echo "$this->_canvas.paint();\n";
        }


        /**
        * Determines the color and pattern for filling graphical shapes and backgrounds.
        *
        * Set the Brush property to specify the color and pattern to use when drawing the background or
        * filling in graphical shapes. The value of Brush is a Brush object. Set the properties of the Brush
        * object to specify the color and pattern or bitmap to use when filling in spaces on the canvas.
        *
        * Note: Setting the Brush property replaces the specified Brush object, rather than copying the current Brush object.
        *
        * @return Brush
        */
        function getBrush()                     { return $this->_brush; }
        function setBrush($value)               { if (is_object($value)) $this->_brush=$value; }

        /**
        * Specifies the font to use when writing text on the image.
        *
        * Set Font to specify the font to use for writing text on the image. The value of Font is a Font
        * object. Set the properties of the Font object to specify the font face, color, size, style, and
        * any other aspects of the font.
        *
        * Note: Setting the Font property replaces the specified Font object, rather than copying the current Font object.
        *
        * @return Font
        */
        function getFont()                      { return $this->_font; }
        function setFont($value)                { if (is_object($value)) $this->_font=$value; }

        /**
        * Specifies the kind of pen the canvas uses for drawing lines and outlining shapes.
        *
        * Set Pen to specify the pen to use for drawing lines and outlining shapes in the image. The value of Pen is a Pen
        * object. Set the properties of the Pen object to specify the color, style, width, and mode of the pen.
        *
        * Note: Setting the Pen property replaces the specified Pen object, rather than copying the current Pen object.
        *
        * @return Pen
        */
        function getPen()                       { return $this->_pen; }
        function setPen($value)                 { if (is_object($value)) $this->_pen=$value; }
}

?>