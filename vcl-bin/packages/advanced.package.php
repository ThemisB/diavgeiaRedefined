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
   require_once("vcl/vcl.inc.php");
   use_unit("designide.inc.php");

   setPackageTitle("Advanced VCL for PHP Components");
   setIconPath("./icons");

//   registerComponents("Advanced",array("GraphicMainMenu"),"comctrls.inc.php");
   registerComponents("Advanced",array("PageControl"),"comctrls.inc.php");
   registerComponents("Advanced",array("ImageList"),"imglist.inc.php");
   registerComponents("Advanced",array("RichEdit", "TrackBar", "ProgressBar", "UpDown", "DateTimePicker", "MonthCalendar", "TreeView","ListView","ButtonView", "ColorSelector", "TextField", "ToolBar"),"comctrls.inc.php");
   registerComponents("Additional",array("LabeledEdit"),"comctrls.inc.php");
   registerComponents("Additional",array("Pager"),"pager.inc.php");

   //Folders required by components using this package
   registerAsset(array("RichEdit"),array("resources\xinha"));
   registerAsset(array("TrackBar"),array("jssliderbar"));
   registerAsset(array("DateTimePicker","MonthCalendar"),array("jscalendar"));
   registerAsset(array("ButtonView","ColorSelector","LabeledEdit","ListView","TreeView","PageControl","TextField","ToolBar","UpDown"),array("qooxdoo"));
   registerAsset(array("ProgressBar"),array("dynapi"));

   registerPropertyValues("CustomButtonView","Position",array('btTop','btBottom',"btRight","btLeft"));
   registerPropertyEditor("CustomButtonView","Items","TItemsPropertyEditor","native");
   registerPropertyValues("CustomButtonView","ImageList",array('ImageList'));

    registerBooleanProperty("CustomTextField","FilterInput");
   registerPropertyValues("ProgressBar","Orientation",array('pbHorizontal','pbVertical'));
   registerPropertyValues("TrackBar","Orientation",array('tbHorizontal','tbVertical'));

   registerPropertyValues("PageControl","TabPosition",array('tpTop','tpBottom'));

   registerPropertyValues("Pager","CSSFile",array('badoo.css','blue.css','digg.css','flickr.css','gray.css','gray2.css',
'green-black.css','green.css','jogger.css','meneame.css','msdn.css',
'sabrosus.css','technorati.css','viciao2k3.css','yahoo.css','yahoo2.css',
'yellow.css','youtube.css'));


   registerPropertyValues("CustomLabeledEdit","LabelPosition",array('lpAbove','lpBelow'));

   registerPropertyValues("CustomTextField", "BorderStyle",array('bsNone','bsSingle'));
   registerPropertyValues("CustomTextField", "CharCase",array('ecLowerCase','ecNormal','ecUpperCase'));
   registerBooleanProperty("CustomTextField","Enabled");
   registerBooleanProperty("CustomTextField","IsPassword");
   registerBooleanProperty("CustomTextField","ReadOnly");
   registerPropertyValues("CustomUpDown", "BorderStyle",array('bsNone','bsSingle'));

   registerPropertyEditor("CustomToolBar","Items","TItemsPropertyEditor","native");
   registerBooleanProperty("CustomToolBar","UseParts");
   registerPropertyValues("CustomToolBar","Images",array('ImageList'));

   registerPropertyValues("CustomTreeView","ImageList",array('ImageList'));
   registerBooleanProperty("CustomTreeView","Enabled");
   registerBooleanProperty("CustomTreeView","ShowLines");
   registerPropertyEditor("CustomRichedit","Toolbars","TStringListPropertyEditor","native");
   registerBooleanProperty("CustomTreeView","ShowRoot");
   registerBooleanProperty("RichEdit","AsSpecialChars");

   registerBooleanProperty("DateTimePicker","ShowsTime");

   registerDropDatafield(array("LabeledEdit","UpDown","RichEdit","TextField"));

   registerPropertyEditor("CustomListView","Columns","TStringListPropertyEditor","native");
   //registerPropertyEditor("CustomListView","Items","TItemsPropertyEditor","native");
   registerPropertyValues("CustomListView","SelectionType",array('selNone','selSingle', 'selOneInterval', 'selMultiInterval'));
   registerBooleanProperty("CustomListView","SortAscending");

?>