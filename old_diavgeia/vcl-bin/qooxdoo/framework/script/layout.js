
qx.log.Logger.ROOT_LOGGER.removeAllAppenders();
qx.log.Logger.ROOT_LOGGER.addAppender(new qx.log.DivAppender("demoDebug"));

document.write('<div id="demoHead">qooxdoo: <span>The new era of web development</span></div>');
document.write('<div id="demoFoot">');
document.write('[<a href="javascript:qx.dev.Pollution.consoleInfo("window");">Global Pollution</a>] &#160;');
document.write('[<a href="javascript:qx.core.Object.summary();">Object Summary</a>] &#160;');
document.write('</div>');
document.write('<div id="demoDebug"></div>');
document.write('<div id="demoFrame">&#160;</div>');

(function(sitemap)
{
  document.write('<select id="demoFiles" onchange="if(this.options[this.selectedIndex].value)window.location.href=this.options[this.selectedIndex].value">');
  var url = window.location.pathname.split('/');
  var basename = window.location.href.substring(0, window.location.href.lastIndexOf("/"));
  var cat = url[url.length-2];
  var file = url[url.length-1];

  var pages = sitemap[cat];
  pages.sort();

  var index = pages.indexOf(file);
  
  for( var i=0; i<pages.length; i++ )
  {
    var href = window.location.href;
    var page = cat + "/" + pages[i];
    var pageuri = "../" + page;
    var pageid = pages[i].replace(".html", "").replace("_", " ");
    document.write('<option value="' + pageuri + '"');
    if(href.lastIndexOf(page) === href.length-page.length) {
      document.write(' selected="selected"');
    
    }
    document.write('>' + pageid + '</option>');
  }
  document.write('</select>');
  
  document.write('<div id="demoJump">');
  if (index > 0) {
    document.write("<button onclick='window.location.href=\"" + basename + '/' + pages[index-1] + "\"'>&lt;</button>");
  }
  if (index < pages.length-1) {
    document.write("<button onclick='window.location.href=\"" + basename + '/' + pages[index+1] + "\"'>&gt;</button>");
  }
  document.write('</div>');
 
})({example:["Atom_1.html","Atom_2.html","Atom_3.html","Button_1.html","ButtonView_1.html","ButtonView_2.html","CheckBox_1.html","ColorPopup_1.html","ColorSelector_1.html","ColorSelector_2.html","ComboBox_1.html","ComboBoxEx_1.html","Command_1.html","Command_2.html","DateChooser_1.html","Drag_1.html","Fields_1.html","Flash_1.html","Fsm_1.html","Gallery_1.html","GalleryList_1.html","GroupBox_1.html","GroupBox_2.html","GroupBox_3.html","Iframe_1.html","Inline_1.html","List_1.html","ListView_1.html","ListView_2.html","ListView_3.html","ListView_4.html","Menu_1.html","NativeWindow_1.html","RadioButton_1.html","RepeatButton_1.html","Resizer_1.html","RpcTreeFullControl_1.html","Spinner_1.html","SplitPane_1.html","SplitPane_2.html","Table_1.html","Table_2.html","TabView_1.html","TabView_2.html","ToolBar_1.html","ToolBar_2.html","ToolBar_3.html","ToolBar_4.html","ToolTip_1.html","Tree_1.html","TreeFullControl_1.html","TreeFullControl_2.html","TreeFullControl_3.html","TreeFullControl_4.html","Window_1.html"],test:["Atom_1.html","Atom_2.html","Atom_3.html","Atom_4.html","Atom_5.html","Atom_6.html","Atom_7.html","Atom_8.html","Atom_9.html","Border_1.html","BoxLayout_1.html","BoxLayout_2.html","Builder_1.html","Builder_2.html","Builder_3.html","Builder_4.html","Button_1.html","CanvasLayout_1.html","CanvasLayout_3.html","CanvasLayout_4.html","CanvasLayout_5.html","Clipping_1.html","Clone_1.html","Clone_2.html","ColorTheme_1.html","ColorTheme_2.html","ColorTheme_3.html","ComboBox_1.html","ComboBox_2.html","ComboBox_3.html","ComboBox_4.html","Cookie_1.html","CookieStorage_1.html","CookieStorage_2.html","CrossBrowser_1.html","CrossBrowser_2.html","CSS_1.html","DateChooserButton_1.html","DateChooserButton_2.html","DockLayout_1.html","DockLayout_2.html","DockLayout_3.html","DockLayout_4.html","DockLayout_5.html","DockLayout_6.html","DragAndDropManager_1.html","DragAndDropManager_2.html","EnabledDisabled_1.html","Fields_1.html","FieldSet_1.html","FlowLayout_1.html","FlowLayout_2.html","FlowLayout_3.html","FocusManager_1.html","Font_1.html","FormUtils_1.html","Gallery_2.html","Gallery_3.html","Generate_1.html","GridLayout_1.html","GridLayout_10.html","GridLayout_11.html","GridLayout_2.html","GridLayout_3.html","GridLayout_4.html","GridLayout_5.html","GridLayout_6.html","GridLayout_7.html","GridLayout_8.html","GridLayout_9.html","History_1.html","HorizontalBoxLayout_1.html","HorizontalBoxLayout_2.html","HorizontalBoxLayout_3.html","HtmlTable_1.html","HtmlTable_2.html","IconHtml_1.html","Image_1.html","Image_2.html","Keyhandler_1.html","Label_1.html","Label_2.html","Label_3.html","Label_4.html","Leak_1.html","Link_1.html","List_1.html","List_2.html","List_3.html","ListView_1.html","ListView_10.html","ListView_2.html","ListView_3.html","ListView_4.html","ListView_5.html","ListView_6.html","ListView_7.html","ListView_8.html","ListView_9.html","Menu_1.html","Menu_2.html","Node_1.html","Popups_1.html","Popups_2.html","RPC_1.html","RPC_2.html","RPC_3.html","RPC_4.html","RPC_5.html","SplitPane_1.html","Table_1.html","Table_2.html","Table_3.html","Table_4.html","Table_5.html","ToolBar_1.html","ToolBar_2.html","ToolBar_3.html","ToolBar_4.html","Transport_1.html","Transport_2.html","Transport_3.html","Transport_4.html","Transport_5.html","Transport_6.html","Tree_1.html","Tree_2.html","Tree_3.html","Tree_4.html","Tree_5.html","Tree_6.html","Tree_7.html","TreeVirtual_1.html","TreeVirtual_2.html","TreeVirtual_3.html","TreeVirtual_4.html","TreeVirtual_5.html","TreeVirtual_6.html","Umlauts_1.html","VerticalBoxLayout_1.html","VerticalBoxLayout_2.html","VerticalBoxLayout_3.html","Window_1.html","Window_2.html","Window_3.html","Window_4.html","Window_5.html","Window_6.html"],performance:["ArrayCreate_1.html","ArrayCreate_2.html","GlobalObject_1.html","GlobalObject_2.html","GlobalObject_3.html","GlobalObject_4.html","LocalObject_1.html","LocalObject_2.html","LocalObject_3.html","LocalObject_4.html","LocalObject_5.html","NumberCreate_1.html","ObjectCreate_1.html","ObjectCreate_2.html","ObjectLevel_1.html","ObjectLevel_2.html","ObjectLevel_3.html","ObjectSize_1.html","Qooxdoo_1.html","StringConcat_1.html","StringConcat_2.html","StringConcat_3.html","TypeCheck_1.html"]});

(function()
{
  var url = location.href;
  var pos = url.indexOf("/html/")+6;
  var split = url.substring(pos).split("/");
  var category = split[0];
  category = category.charAt(0).toUpperCase() + category.substring(1);
  var pagename = split[1].replace(".html", "").replace(/_/g, " ");
  pagename = pagename.charAt(0).toUpperCase() + pagename.substring(1);

  document.title = "qooxdoo » Demo » Sample » " + category + " » " + pagename;

  if (window.location.href.indexOf("demo.qooxdoo.org") != -1)
  {
    document.write('<script type="text/javascript">var a_vars = []; var pagename=""; var phpmyvisitesSite = 5; var phpmyvisitesURL = "http://counter.qooxdoo.org/phpmyvisites.php";</script>');
    document.write('<script type="text/javascript" src="http://counter.qooxdoo.org/phpmyvisites.js"></script>');
    document.write('<script type="text/javascript" src="http://www.google-analytics.com/urchin.js"></script>');
    document.write('<script type="text/javascript">_uacct = "UA-415440-1"; function urchinStart() { urchinTracker() }; if(window.addEventListener)window.addEventListener("load", urchinStart, false); else if(window.attachEvent)window.attachEvent("onload", urchinStart);</script>');
  }
})();
