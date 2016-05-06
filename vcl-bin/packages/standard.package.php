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
   use_unit("designide.inc.php");                                                  //IDE functions
   use_unit("templateplugins.inc.php");                                         //Plugin functions

   //Set title for this package and the path where to find the icons for the components
   setPackageTitle("Standard VCL for PHP Components");
   setIconPath("./icons");

    addSplashBitmap("VCL for PHP 2.0 from qadram software","qadram.bmp");
   //Pages and DataModules are special components and must be registered that way
   registerNoVisibleComponents(array("Page"),"forms.inc.php");
   registerNoVisibleComponents(array("DataModule"),"forms.inc.php");

  RegisterPropertiesInCategory('Visual', array('Background','Color','Cursor','Left','Font','Top','Width','Height','Visible',
        'Enabled','Caption','Align','Alignment','ParentColor','ParentFont','Bevel*',
        'Border*','ClientHeight','ClientWidth','Scaled','AutoSize','EditMask','OnShow',
        'OnPaint','OnClose','OnCloseQuery','OnResize','OnConstrained','OnActivate',
        'OnDeactivate','OnCanResize','OnHide'));

  RegisterPropertiesInCategory('Localizable', array('Language','Directionality','Encoding','BiDiMode','Caption','Constraints',
        'EditMask','Glyph','Height','Hint','Icon','ImeMode','ImeName','Left',
        'ParentBiDiMode','ParentFont','Picture','Text','Top','Width'));
  RegisterPropertiesInCategory('Legacy', array('Ctl3d', 'ParentCtl3d', 'OldCreateOrder'));
  RegisterPropertiesInCategory('Layout', array('TopMargin','ShowHeader','ShowFooter','RightMargin','LeftMargin','Layer','Layout','FrameBorder','FrameSpacing','BottomMargin','Left', 'Top', 'Width', 'Height', 'TabOrder', 'TabStop', 'Align', 'Anchors', 'Constraints', 'AutoSize', 'AutoScroll', 'Scaled',
        'OnResize', 'OnConstrained', 'OnCanResize'));

  RegisterPropertiesInCategory('Input', array('AutoScroll','KeyPreview','ReadOnly',
        'Enabled','OnClick','OnDblClick','OnShortCut','OnKey*','OnMouse*'));
  RegisterPropertiesInCategory('Help and Hints', array('Help*', '*Help', 'Hint*', '*Hint'));
  RegisterPropertiesInCategory('Drag, Drop and Docking', array('Drag*', 'Dock*', 'UseDockManager', 'OnDockOver', 'OnGetSiteInfo', 'OnDragOver', 'On*Drop', 'On*Drag', 'On*Dock'));
  RegisterPropertiesInCategory('Action',array('IsMaster','IsForm','Action', 'Caption', 'Checked', 'Enabled', 'HelpContext', 'Hint', 'ImageIndex','ShortCut', 'Visible'));


   //Standard Palette
   registerComponents("Standard",array("Frame","Frameset"),"forms.inc.php");
   registerComponents("Standard",array("MainMenu"),"menus.inc.php");
   registerComponents("Standard",array("PopupMenu"),"menus.inc.php");
   registerComponents("Standard",array("Label","Edit","Memo","Button","CheckBox","RadioButton","ListBox","ComboBox", "ScrollBar"),"stdctrls.inc.php");
   registerComponents("Standard",array("GroupBox","RadioGroup", "Panel"),"extctrls.inc.php");
   registerComponents("Standard",array("ActionList"),"actnlist.inc.php");

   //Folders required by components using this package
   registerAsset(array("MainMenu","PopupMenu"),array("qooxdoo","dynapi"));
   registerAsset(array("ScrollBar"),array("dynapi"));
   registerAsset(array("Page"),array("js","xajax","language","smarty"));
   registerAsset(array("GroupBox"),array("qooxdoo"));
   registerAsset(array("Window"),array("qooxdoo"));


   //Additional Palette
   registerComponents("Additional",array("HiddenField"),"forms.inc.php");
   registerComponents("Additional",array("Upload"),"stdctrls.inc.php");
   registerComponents("Additional",array("BitBtn", "SpeedButton"),"buttons.inc.php");
   registerComponents("Additional",array("Image","MapShape","FlashObject", "Shape", "Bevel"),"extctrls.inc.php");
   registerComponents("Additional",array("CheckListBox"),"checklst.inc.php");
   registerComponents("Additional",array("SimpleChart"),"chart.inc.php");
   registerComponents("Additional",array("Window"),"forms.inc.php");

   registerAsset(array("BitBtn","StringGrid","SpeedButton"),array("qooxdoo"));
   registerAsset(array("SimpleChart"),array("libchart"));
   registerAsset(array("Shape","Bevel","PaintBox"),array("walterzorn"));

   //Property editors
   registerPropertyEditor("Control","Color","TSamplePropertyEditor","native");
   registerPropertyEditor("CustomPanel","BorderColor","TSamplePropertyEditor","native");
   registerPropertyEditor("Control","DesignColor","TSamplePropertyEditor","native");
   registerPropertyEditor("Control","Font.Color","TSamplePropertyEditor","native");
   registerPropertyEditor("CustomMemo","Lines","TStringListPropertyEditor","native");
   registerPropertyEditor("Button","ImageSource","TImagePropertyEditor","native");
   registerPropertyEditor("CustomPage","Icon","TImagePropertyEditor","native");
   registerPropertyEditor("CustomComboBox","Items","TValueListPropertyEditor","native");
   registerPropertyEditor("CustomCheckListBox","Checked","TValueListPropertyEditor","native");
   registerPropertyEditor("CustomCheckListBox","Header","TValueListPropertyEditor","native");
   registerPropertyEditor("CustomPanel","Include","TFilenamePropertyEditor","native");
   registerPropertyEditor("FlashObject","SwfFile","TFilenamePropertyEditor","native");
   registerPropertyValues("ImageFade","Images",array('ImageList'));
   registerPropertyEditor("GraphicMainMenu","MenuItems","TItemsPropertyEditor","native");
   registerPropertyEditor("MainMenu","BackColor","TSamplePropertyEditor","native");
   registerPropertyEditor("MainMenu","BorderColor","TSamplePropertyEditor","native");
   registerPropertyEditor("MainMenu","SelectedBackColor","TSamplePropertyEditor","native");
   registerPropertyEditor("CustomListBox","Items","TStringListPropertyEditor","native");
   registerPropertyEditor("CustomRadioGroup","Items","TStringListPropertyEditor","native");
   registerPropertyEditor("ActionList","Actions","TStringListPropertyEditor","native");
   registerPropertyEditor("Image","BorderColor","TSamplePropertyEditor","native");
   registerPropertyEditor("BitBtn","ImageSource","TImagePropertyEditor","native");
	 registerPropertyEditor("BitBtn","ImageDisabled","TImagePropertyEditor","native");
	 registerPropertyEditor("BitBtn","ImageClicked","TImagePropertyEditor","native");
	 registerPropertyEditor("BitBtn","ImageDown","TImagePropertyEditor","native");

   registerPropertyValues("Control","PopupMenu",array('PopupMenu'));

   registerPropertyEditor("PopupMenu","Items","TItemsPropertyEditor","native");
   registerPropertyValues("PopupMenu","Images",array('ImageList'));
   registerPropertyValues("MainMenu","Images",array('ImageList'));

   //Property Values for the drop-down property editor
   registerPropertyValues("Window","ResizeMethod",array('rmFrame','rmOpaque','rmLazyOpaque','rmTranslucent'));
   registerPropertyValues("CustomPage","DocType",array('dtNone','dtXHTML_1_0_Strict','dtXHTML_1_0_Transitional','dtXHTML_1_0_Frameset','dtHTML_4_01_Strict','dtHTML_4_01_Transitional' ,'dtHTML_4_01_Frameset','dtXHTML_1_1'));
   registerPropertyValues("CustomPage","FrameBorder",array('fbDefault', 'fbNo', 'fbYes'));

   registerPropertyValues("CustomPage","Directionality",array('ddLeftToRight','ddRightToLeft'));
   registerPropertyValues("Window","MoveMethod",array('mmFrame','mmOpaque','mmTranslucent'));

   registerPropertyValues('CustomPage','Cache',array('Cache'));
   registerBooleanProperty('Control','Cached');

   registerPropertyValues("Control","DataSource",array('Datasource'));
   registerPropertyValues("Control","Style",array('StyleSheet::Styles'));
   registerPropertyValues("FocusControl","Layout.Type",array('ABS_XY_LAYOUT','REL_XY_LAYOUT','XY_LAYOUT','FLOW_LAYOUT', 'GRIDBAG_LAYOUT', 'ROW_LAYOUT', 'COL_LAYOUT'));
   registerPropertyValues("Chart","ChartType",array('ctHorizontalChart','ctLineChart','ctPieChart','ctVerticalChart'));
   registerPropertyValues("Control","Align",array('alNone','alTop','alBottom','alLeft','alRight','alClient','alCustom'));
   registerPropertyValues("Control","Font.Align",array('taNone','taLeft','taRight','taCenter','taJustify'));
   registerPropertyValues("Control","Font.Case",array('caCapitalize','caUpperCase','caLowerCase','caNone'));
   registerPropertyValues("Control","Font.Style",array('fsNormal','fsItalic','fsOblique'));
   registerPropertyValues("Control","Font.Variant",array('vaNormal','vaSmallCaps'));
   registerPropertyValues("Control","Font.Weight",array('normal','bold','bolder','lighter','100','200','300','400','500','600','700','800','900'));
   registerPropertyValues("ButtonControl","ButtonType",array('btSubmit','btReset','btNormal'));
   registerPropertyValues("ScrollBar","Kind",array('sbHorizontal','sbVertical'));
   registerPropertyValues("Control","Cursor",array('crPointer','crCrossHair','crText','crWait','crDefault','crHelp','crE-Resize','crNE-Resize','crN-Resize','crNW-Resize','crW-Resize','crSW-Resize','crS-Resize','crSE-Resize','crAuto'));
   registerPropertyValues("Control","Alignment",array('agNone','agLeft','agCenter','agRight'));
   registerPropertyValues("CustomEdit","BorderStyle",array('bsNone','bsSingle'));
   registerPropertyValues("CustomEdit","CharCase",array('ecLowerCase','ecNormal','ecUpperCase'));
   registerPropertyEditor("Shape","Pen.Color","TSamplePropertyEditor","native");
   //registerPropertyValues("Shape","Pen.Style",array('psDash', 'psDashDot', 'psDashDotDot', 'psDot', 'psSolid'));
   registerPropertyValues("Shape","Shape",array('stRectangle', 'stSquare', 'stRoundRect', 'stRoundSquare', 'stEllipse', 'stCircle'));
   registerPropertyEditor("Shape","Brush.Color","TSamplePropertyEditor","native");
	 registerPropertyValues("BitBtn","Kind",array('bkCustom','bkOK','bkCancel','bkYes','bkNo','bkHelp','bkClose','bkAbort','bkRetry','bkIgnore'));
	 registerPropertyValues("BitBtn","ButtonType",array('btSubmit','btReset','btNormal'));
	 registerPropertyValues("MapShape","Kind",array('skRectangle','skCircle','skDefault'));

   registerPropertyEditor("PageControl","Tabs","TStringListPropertyEditor","native");

   registerPropertyValues("Bevel","Shape",array('bsBox', 'bsFrame', 'bsTopLine', 'bsBottomLine', 'bsLeftLine', 'bsRightLine', 'bsSpacer'));
   registerPropertyValues("Bevel","BevelStyle",array('bsLowered', 'bsRaised'));

   registerPropertyValues("CustomCheckBox","State",array("cbChecked","cbUnchecked"));
   registerPropertyValues("CustomListBox","BorderStyle",array('bsNone','bsSingle'));
   registerPropertyValues("CustomRadioGroup","Orientation",array('orHorizontal','orVertical'));
   registerPropertyValues("SimpleChart","ChartType",array("ctHorizontalChart","ctLineChart","ctPieChart","ctVerticalChart"));
   registerPropertyValues("BitBtn","ButtonLayout",array('blImageBottom','blImageLeft','blImageRight','blImageTop'));

   registerPropertyValues("Frameset","FrameBorder",array('fbNo','fbYes','fbDefault'));

   registerPropertyValues("Frame","Scrolling",array('fsAuto','fsYes','fsNo'));
   registerBooleanProperty("Frame","Resizeable");
   registerPropertyValues("FlashObject","Quality",array('fqLow', 'fqAutoLow', 'fqAutoHigh', 'fqMedium', 'fqHigh', 'fqBest'));

   registerBooleanProperty("FlashObject","Active");
   registerBooleanProperty("FlashObject","Loop");
   registerBooleanProperty("Control","DivWrap");
   registerBooleanProperty("Frame","Borders");
   registerBooleanProperty("Image","Binary");
   registerBooleanProperty("Control","Autosize");

   //Register the values for the dropdown of the TemplateEngine property
   //See also templateplugins.inc.php, smartytemplate.inc.php
   global $TemplateManager;
   registerPropertyValues("CustomPage","TemplateEngine",$TemplateManager->getEngines());

   //Register boolean properties to be handled correctly by the IDE
   registerBooleanProperty("Control","Visible");
   registerBooleanProperty("Control","Hidden");
   registerBooleanProperty("CustomEdit","FilterInput");
   registerBooleanProperty("CustomMemo","FilterInput");
   registerBooleanProperty("CustomCheckBox","Checked");
   registerBooleanProperty("Control","ParentFont");
   registerBooleanProperty("Control","ParentColor");
   registerBooleanProperty("Control","ParentShowHint");
   registerBooleanProperty("Control","ShowHint");
   registerBooleanProperty("Control","Layout.UsePixelTrans");

   registerBooleanProperty("Window","IsVisible");
   registerBooleanProperty("Window","Modal");
   registerBooleanProperty("Window","Moveable");
   registerBooleanProperty("Window","Resizeable");
   registerBooleanProperty("Window","ShowCaption");
   registerBooleanProperty("Window","ShowClose");
   registerBooleanProperty("Window","ShowIcon");
   registerBooleanProperty("Window","ShowMaximize");
   registerBooleanProperty("Window","ShowMinimize");
   registerBooleanProperty("Window","ShowStatusBar");

   registerBooleanProperty("CustomPage","IsForm");
   registerBooleanProperty("CustomPage","IsMaster");
   registerBooleanProperty("CustomPage","ShowFooter");
   registerBooleanProperty("CustomPage","ShowHeader");
   registerBooleanProperty("CustomPage","UseAjax");
   registerBooleanProperty("CustomPage","UseAjaxDebug");
   registerBooleanProperty("CustomLabel","WordWrap");
   registerBooleanProperty("Image","Autosize");
   registerBooleanProperty("Image","Border");
   registerBooleanProperty("Image","Center");
   registerBooleanProperty("Image","Proportional");
   registerBooleanProperty("CustomEdit","Enabled");
   registerBooleanProperty("CustomEdit","IsPassword");
   registerBooleanProperty("CustomEdit","ReadOnly");
   registerBooleanProperty("CustomEdit","TabStop");
   registerBooleanProperty("CustomMemo","RichEditor");
   registerBooleanProperty("CustomMemo","WordWrap");
   registerBooleanProperty("ButtonControl","Checked");
   registerBooleanProperty("ButtonControl","Default");
   registerBooleanProperty("ButtonControl","Enabled");
   registerBooleanProperty("ButtonControl","TabStop");
	 registerBooleanProperty("CustomLabel","Enabled");
   registerBooleanProperty("CustomListBox","Enabled");
   registerBooleanProperty("CustomListBox","MultiSelect");
   registerBooleanProperty("CustomListBox","Sorted");
   registerBooleanProperty("CustomListBox","TabStop");
	 registerBooleanProperty("Image","Enabled");
	 registerBooleanPropertY("Image","Stretch");
   registerBooleanProperty("CustomRadioGroup","Enabled");
   registerBooleanProperty("CustomRadioGroup","TabStop");

   registerBooleanProperty("SimpleChart","FillDummy");

   registerBooleanProperty("Control","Enabled");
   registerBooleanProperty("BitBtn","Enabled");
   registerBooleanProperty("SpeedButton","AllowAllUp");
   registerBooleanProperty("SpeedButton","Down");
   registerBooleanProperty("SpeedButton","Flat");

   registerDropDatafield(array("Label","Edit","Memo","ListBox","ComboBox","Button","CheckBox","RadioButton","RadioGroup","Image"));

   registerPropertyEditor("CustomCheckListBox","Items","TStringListPropertyEditor","native");
   registerPropertyEditor("CustomCheckListBox","BorderColor","TSamplePropertyEditor","native");
   registerPropertyValues("CustomCheckListBox","BorderStyle",array('bsNone','bsSingle'));
	 registerPropertyEditor("CustomCheckListBox","HeaderBackgroundColor","TSamplePropertyEditor","native");
	 registerPropertyEditor("CustomCheckListBox","HeaderColor","TSamplePropertyEditor","native");

   //Register available encodings

   registerPropertyValues("CustomPage","Encoding",array(
'Arabic (ASMO 708)          |ASMO-708',
'Arabic (DOS)               |DOS-720',
'Arabic (ISO)               |iso-8859-6',
'Arabic (Windows)           |windows-1256',
'Baltic (Windows)           |windows-1257',
'Central European (DOS)     |ibm852',
'Central European (ISO)     |iso-8859-2',
'Central European (Windows) |windows-1250',
'Chinese Simplified (GB2312)|gb2312',
'Chinese Simplified (HZ)    |hz-gb-2312',
'Chinese Traditional (Big5) |big5',
'Cyrillic (DOS)             |cp866',
'Cyrillic (ISO)             |iso-8859-5',
'Cyrillic (KOI8-R)          |koi8-r',
'Cyrillic (Windows)         |windows-1251',
'Greek (ISO)                |iso-8859-7',
'Greek (Windows)            |windows-1253',
'Hebrew (DOS)               |DOS-862',
'Hebrew (ISO-Logical)       |iso-8859-8-i',
'Hebrew (ISO-Visual)        |iso-8859-8',
'Hebrew (Windows)           |windows-1255',
'Japanese (EUC)             |euc-jp',
'Japanese (Shift-JIS)       |shift_jis',
'Korean (EUC)               |euc-kr',
'Thai (Windows)             |windows-874',
'Turkish (Windows)          |windows-1254',
'Ukraine (KOI8-U)           |koi8-ru',
'Unicode (UTF-8)            |utf-8',
'Vietnamese (Windows)       |windows-1258',
'Western European (ISO)     |iso-8859-1'));

   //Register values for the Language property of the CustomPage component
   registerPropertyValues("CustomPage","Language",array('(default)',
                                                        'Afrikaans',
                                                        'Albanian',
                                                        'Arabic (Algeria)',
                                                        'Arabic (Bahrain)',
                                                        'Arabic (Egypt)',
                                                        'Arabic (Iraq)',
                                                        'Arabic (Jordan)',
                                                        'Arabic (Kuwait)',
                                                        'Arabic (Lebanon)',
                                                        'Arabic (libya)',
                                                        'Arabic (Morocco)',
                                                        'Arabic (Oman)',
                                                        'Arabic (Qatar)',
                                                        'Arabic (Saudi Arabia)',
                                                        'Arabic (Syria)',
                                                        'Arabic (Tunisia)',
                                                        'Arabic (U.A.E.)',
                                                        'Arabic (Yemen)',
                                                        'Arabic',
                                                        'Armenian',
                                                        'Assamese',
                                                        'Azeri',
                                                        'Basque',
                                                        'Belarusian',
                                                        'Bengali',
                                                        'Bulgarian',
                                                        'Catalan',
                                                        'Chinese (China)',
                                                        'Chinese (Hong Kong SAR)',
                                                        'Chinese (Macau SAR)',
                                                        'Chinese (Singapore)',
                                                        'Chinese (Taiwan)',
                                                        'Chinese',
                                                        'Croatian',
                                                        'Czech',
                                                        'Danish',
                                                        'Divehi',
                                                        'Dutch (Belgium)',
                                                        'Dutch (Netherlands)',
                                                        'English (Australia)',
                                                        'English (Belize)',
                                                        'English (Canada)',
                                                        'English (Ireland)',
                                                        'English (Jamaica)',
                                                        'English (New Zealand)',
                                                        'English (Philippines)',
                                                        'English (South Africa)',
                                                        'English (Trinidad)',
                                                        'English (United Kingdom)',
                                                        'English (United States)',
                                                        'English (Zimbabwe)',
                                                        'English',
                                                        'Estonian',
                                                        'Faeroese',
                                                        'Farsi',
                                                        'Finnish',
                                                        'French (Belgium)',
                                                        'French (Canada)',
                                                        'French (Luxembourg)',
                                                        'French (Monaco)',
                                                        'French (Switzerland)',
                                                        'French (France)',
                                                        'FYRO Macedonian',
                                                        'Gaelic',
                                                        'Georgian',
                                                        'German (Austria)',
                                                        'German (Liechtenstein)',
                                                        'German (lexumbourg)',
                                                        'German (Switzerland)',
                                                        'German (Germany)',
                                                        'Greek',
                                                        'Gujarati',
                                                        'Hebrew',
                                                        'Hindi',
                                                        'Hungarian',
                                                        'Icelandic',
                                                        'Indonesian',
                                                        'Italian (Switzerland)',
                                                        'Italian (Italy)',
                                                        'Japanese',
                                                        'Kannada',
                                                        'Kazakh',
                                                        'Konkani',
                                                        'Korean',
                                                        'Kyrgyz',
                                                        'Latvian',
                                                        'Lithuanian',
                                                        'Malay',
                                                        'Malayalam',
                                                        'Maltese',
                                                        'Marathi',
                                                        'Mongolian (Cyrillic)',
                                                        'Nepali (India)',
                                                        'Norwegian (Bokmal)',
                                                        'Norwegian (Nynorsk)',
                                                        'Norwegian (Bokmal)',
                                                        'Oriya',
                                                        'Polish',
                                                        'Portuguese (Brazil)',
                                                        'Portuguese (Portugal)',
                                                        'Punjabi',
                                                        'Rhaeto-Romanic',
                                                        'Romanian (Moldova)',
                                                        'Romanian',
                                                        'Russian (Moldova)',
                                                        'Russian',
                                                        'Sanskrit',
                                                        'Serbian',
                                                        'Slovak',
                                                        'Slovenian',
                                                        'Sorbian',
                                                        'Spanish (Argentina)',
                                                        'Spanish (Bolivia)',
                                                        'Spanish (Chile)',
                                                        'Spanish (Colombia)',
                                                        'Spanish (Costa Rica)',
                                                        'Spanish (Dominican Republic)',
                                                        'Spanish (Ecuador)',
                                                        'Spanish (El Salvador)',
                                                        'Spanish (Guatemala)',
                                                        'Spanish (Honduras)',
                                                        'Spanish (Mexico)',
                                                        'Spanish (Nicaragua)',
                                                        'Spanish (Panama)',
                                                        'Spanish (Paraguay)',
                                                        'Spanish (Peru)',
                                                        'Spanish (Puerto Rico)',
                                                        'Spanish (United States)',
                                                        'Spanish (Uruguay)',
                                                        'Spanish (Venezuela)',
                                                        'Spanish (Traditional Sort)',
                                                        'Sutu',
                                                        'Swahili',
                                                        'Swedish (Finland)',
                                                        'Swedish',
                                                        'Syriac',
                                                        'Tamil',
                                                        'Tatar',
                                                        'Telugu',
                                                        'Thai',
                                                        'Tsonga',
                                                        'Tswana',
                                                        'Turkish',
                                                        'Ukrainian',
                                                        'Urdu',
                                                        'Uzbek',
                                                        'Vietnamese',
                                                        'Xhosa',
                                                        'Yiddish',
                                                        'Zulu'
                                                        ));
?>