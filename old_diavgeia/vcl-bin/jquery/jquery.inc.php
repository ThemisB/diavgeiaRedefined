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
        * This component provides a slider for information
        *
        * @package JQuery
        */
        class JQSlider extends Control
        {
            function __construct($aowner = null)
            {
                parent::__construct($aowner);
                $this->Width=300;
                $this->Height=100;
            }

            function getFont() { return $this->readfont(); }
            function setFont($value) { $this->writefont($value); }

            function getParentFont() { return $this->readparentfont(); }
            function setParentFont($value) { $this->writeparentfont($value); }

            protected $_lines=array();

            /**
            * Specifies the news to show on this component
            *
            * Use this property to specify the lines to show on this component
            *
            * @return array
            */
            function getLines() { return $this->_lines; }
            function setLines($value) { $this->_lines=$value; }
            function defaultLines() { return array(); }

            protected $_topcaption="Slider";

            /**
            * Specifies the top caption
            *
            * Use this property to specify the top caption to be shown on this component
            *
            * @return string
            */
            function getTopCaption() { return $this->_topcaption; }
            function setTopCaption($value) { $this->_topcaption=$value; }
            function defaultTopCaption() { return "Slider"; }

            function dumpHeaderCode()
            {
                if (!defined('JQUERY'))
                {
                    define('JQUERY',1);
                    echo '<script language="javascript" type="text/javascript" src="'.VCL_HTTP_PATH.'/jquery/jquery.js"></script>'."\n";
                }

                if (!defined('JQUERY_NEWS'))
                {
                    define('JQUERY_NEWS',1);
                    echo '<script language="javascript" type="text/javascript" src="'.VCL_HTTP_PATH.'/jquery/jquery.accessible-news-slider.js"></script>'."\n";
                }
?>
<script language="javascript" type="text/javascript">
$(function() {
    $(".<?php echo $this->_name; ?>").accessNews({
        newsHeadline: "<?php echo $this->_topcaption; ?>",
        newsSpeed: "normal"
    });
});
</script>

<?php
    $itemwidth=($this->_width/2)-30;
?>
<style type="text/css" media="screen, projection">
.fl {
	float: left; display: inline;
}
img {
	border: 0; display: block;
}
.<?php echo $this->_name; ?>_news_slider {
	position: relative; width: <?php echo $this->_width; ?>px; margin: 0 auto 20px auto; text-align: left;
}

.<?php echo $this->_name; ?>_news_slider .messaging {
	display: block; padding: 5px; margin: 0 20px 5px 20px; background: #ffffcc;
}
.<?php echo $this->_name; ?>_news_slider .prev, .<?php echo $this->_name; ?>_news_slider .next {
	position: absolute; top: 42%; display: none;
}
.<?php echo $this->_name; ?>_news_slider .next {
	right: 0;
}
.<?php echo $this->_name; ?>_news_slider .container {
	position: relative; top: 0; left: 0; width: 100%; background: #eeeeed;
}
.<?php echo $this->_name; ?>_news_slider .news_items {
    /*
        The width must be equal to .item ((width + margin-right) * 2).
    */
	position: relative; width: <?php echo ($itemwidth+10)*2; ?>px; top: 0; left: 20px; overflow: hidden;
}
.<?php echo $this->_name; ?>_news_slider .view_all {
	font-size: .8em; padding: 5px; margin: 0 0 2px 0; border-top: #eeeeed 1px solid; border-bottom: #eeeeed 1px solid; text-align: center;
}
.<?php echo $this->_name; ?>_news_slider .item {
    /*
        Must contain a width and a margin-right.
    */
	width: <?php echo $itemwidth; ?>px; margin-right: 10px;
}
.<?php echo $this->_name; ?>_news_slider .item div {
	font-size: .8em; width: 175px; padding: 10px 0 10px 0;
}
.<?php echo $this->_name; ?>_news_slider .item img {
	padding: 10px;
}
</style>
<?php
            }

            function dumpContents()
            {
?>
    <div class="<?php echo $this->Name; ?>_news_slider <?php echo $this->Name; ?>">
       <div class="news_slider <?php echo $this->Name; ?>">
        <div class="messaging">
            Please Note: You may have disabled JavaScript and/or CSS. Although this news content will be accessible, certain functionality is unavailable.
        </div>
        <a href="#" class="prev"><img src="<?php echo VCL_HTTP_PATH; ?>/jquery/images/prev.gif" width="16" height="16" alt="Previous" title="Previous" env="images" /></a>
        <a href="#" class="next"><img src="<?php echo VCL_HTTP_PATH; ?>/jquery/images/next.gif" width="16" height="16" alt="Next" title="Next" env="images" /></a>
        <div class="news_items" style="<?php echo $this->Font->readFontString(); ?>">
            <div class="container fl">
            <?php
                if (count($this->_lines)>=1)
                {
                    reset($this->_lines);
                    while(list($key, $val)=each($this->_lines))
                    {
                    ?>
                <div class="item fl"><div style="<?php echo $this->Font->readFontString(); ?>"><?php echo $val; ?></div></div>
                <?php
                    }

                }
                else
                {
            ?>
                <div class="item fl">
                Edit Lines property to add new items to the slider, each line is an item, you can use HTML
                </div>
            <?php
                }
            ?>
            </div>
        </div>
        </div>
    </div>

<?php
            }
        }

?>
