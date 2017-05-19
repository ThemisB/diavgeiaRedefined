/*
	DynAPI Distribution
	Package File

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
*/

var l = dynapi.library;
var p = dynapi.library.path;
l._pakLoaded=true;

l.addPackage('dynapi',p);
l.add('dynapi.library','ext/library.js');
l.add('dynapi.debug','ext/debug.js','dynapi.functions.Image');

// Functions
l.addPackage('dynapi.functions',p+'ext/');
l.add('dynapi.functions.Color','functions.color.js');
l.add('dynapi.functions.Math','functions.math.js');
l.add('dynapi.functions.Date','functions.date.js');
l.add('dynapi.functions.Image','functions.image.js',((dynapi.ua.ns4)? 'MouseEvent':null)); // ns4 required MouseEvent for Image functions
l.add('dynapi.functions.Numeric','functions.numeric.js');
l.add('dynapi.functions.String','functions.string.js');
l.add('dynapi.functions.System','functions.system.js');

// API - Core Events & DynDocument
l.addPackage('dynapi.api',p+'api/');
l.add(['dynapi.api.DynEvent','dynapi.api.EventObject','dynapi.api.DynElement'],'event.js');
l.add('dynapi.api.DynDocument','dyndocument.js','DynEvent');
	// DynLayer
l.add('dynapi.api.DynLayerBase','dynlayer_base.js','DynDocument');
if (dynapi.ua.ns4) l.add('dynapi.api.DynLayer','dynlayer_ns4.js','DynLayerBase');
else if (dynapi.ua.ie) l.add('dynapi.api.DynLayer','dynlayer_ie.js','DynLayerBase');
else if (dynapi.ua.opera) l.add('dynapi.api.DynLayer','dynlayer_opera.js','DynLayerBase');
else l.add('dynapi.api.DynLayer','dynlayer_dom.js','DynLayerBase');
	// MouseEvent
if (dynapi.ua.ns4) l.add('dynapi.api.MouseEvent','mouse_ns4.js','DynLayer');
else if(dynapi.ua.ie||dynapi.ua.opera) l.add('dynapi.api.MouseEvent','mouse_ie.js','DynLayer');
else l.add('dynapi.api.MouseEvent','mouse_dom.js','DynLayer');

	// Extensions
	l.addPackage('dynapi.api.ext',p+'api/ext/');
	l.add('dynapi.api.ext.DragEvent','dragevent.js','DynDocument');
	l.add(['dynapi.api.ext.DynKeyEvent','dynapi.api.ext.TabManager'],'dynkeyevent.js','DynLayer');
	l.add('dynapi.api.ext.DynLayerInline','dynlayer.inline.js','DynLayer');

// FX
l.addPackage('dynapi.fx',p+'fx/');
l.add('dynapi.fx.Thread','thread.js','DynLayer');
l.add('dynapi.fx.PathAnimation','pathanim.js','Thread');
l.add('dynapi.fx.SlideAnimation','slideanim.js','Thread');
l.add('dynapi.fx.GlideAnimation','glideanim.js',['Thread','dynapi.functions.Math']);
l.add('dynapi.fx.CircleAnimation','circleanim.js',['Thread','dynapi.functions.Math']);
l.add('dynapi.fx.HoverAnimation','hoveranim.js',['Thread','dynapi.functions.Math']);
l.add('dynapi.fx.Bezier','bezier.js','Thread');
l.add('dynapi.fx.TimerX','timerx.js','DynLayer');
l.add('dynapi.fx.MotionX','motionx.js','DynLayer');
l.add('dynapi.fx.SnapX','snapx.js','DynLayer');
l.add('dynapi.fx.FlashSound','fsound.js','DynLayer');
l.add('dynapi.fx.Fader','fader.js','DynLayer');
l.add('dynapi.fx.Swiper','swiper.js','DynLayer');
l.add('dynapi.fx.TextAnimation','textanim.js','DynLayer');

// GUI
l.addPackage('dynapi.gui',p+'gui/');
l.add('dynapi.gui.BorderManager','bordermanager.js','Highlighter');
l.add('dynapi.gui.GroupManager','groupmanager.js','DynLayer');
l.add('dynapi.gui.FocusManager','focusmanager.js','DynLayer');
l.add('dynapi.gui.StyleManager','stylemanager.js','DynLayer'); 
l.add('dynapi.gui.TemplateManager','templmngr.js','DynLayer');
l.add('dynapi.gui.Frame','frame.js','Highlighter');
l.add('dynapi.gui.PanelBar','panelbar.js','DynLayer');
l.add('dynapi.gui.Label','label.js','DynLayer');
l.add('dynapi.gui.NodeItem','nodeitem.js','DynLayer');
l.add('dynapi.gui.List','list.js','Label');
l.add('dynapi.gui.Tree','tree.js','DynLayer');
	// Components
l.add('dynapi.gui.Highlighter','highlighter.js','DynLayer');
l.add('dynapi.gui.ImageClip','imageclip.js','DynLayer');
l.add('dynapi.gui.LoadPanel','loadpanel.js','DynLayer');
l.add('dynapi.gui.Graphics','graphics.js','DynLayer');
l.add('dynapi.gui.Button','button.js','ButtonStyle'); 
l.add('dynapi.gui.Knob','knob.js',['KnobStyle','DragEvent']); 
l.add('dynapi.gui.ScrollBar','scrollbar.js',['Button','Knob','ScrollBarStyle']); 
l.add('dynapi.gui.ListBox','listbox.js',['ScrollBar','PoolManager','ListBoxStyle']);
l.add('dynapi.gui.Marquee','marquee.js','MarqueeStyle');
l.add('dynapi.gui.RadioButton','radiobutton.js','RadioButtonStyle');
l.add('dynapi.gui.CheckBox','checkbox.js','CheckBoxStyle');
l.add('dynapi.gui.Explorer','explorer.js','ExplorerStyle');
l.add('dynapi.gui.ViewPane','viewpane.js',['ScrollBar','ViewPaneStyle']);
l.add('dynapi.gui.ProgressBar','progressbar.js','ProgressBarStyle');
l.add('dynapi.gui.Stacker','stacker.js','DynLayer');
	// Component Styles
l.add('dynapi.gui.ButtonStyle','button.style.js',['StyleManager','BorderManager']);
l.add('dynapi.gui.ButtonFlatStyle','button.flatstyle.js',['StyleManager','BorderManager']);
l.add('dynapi.gui.ButtonImageStyle','button.imagestyle.js','StyleManager');
l.add('dynapi.gui.KnobStyle','knob.style.js',['StyleManager','BorderManager']);
l.add('dynapi.gui.ScrollBarStyle','scrollbar.style.js','StyleManager');
l.add('dynapi.gui.ListBoxStyle','listbox.style.js','StyleManager');
l.add('dynapi.gui.MarqueeStyle','marquee.style.js','StyleManager');
l.add('dynapi.gui.RadioButtonStyle','radiobutton.style.js','StyleManager');
l.add('dynapi.gui.CheckBoxStyle','checkbox.style.js','StyleManager');
l.add('dynapi.gui.ExplorerStyle','explorer.style.js','StyleManager');
l.add('dynapi.gui.ExplorerBlockStyle','explorer.block.style.js','ExplorerStyle');
l.add('dynapi.gui.ViewPaneStyle','viewpane.style.js',['StyleManager','BorderManager']);
l.add('dynapi.gui.ProgressBarStyle','progressbar.style.js',['StyleManager','BorderManager']);
	// HTML Components
l.add('dynapi.gui.HTMLButton','htmlbutton.js','HTMLComponent');
l.add('dynapi.gui.HTMLComponent','htmlcomponent.js','DynElement');
l.add('dynapi.gui.HTMLContainer','htmlcontainer.js','HTMLComponent');
l.add('dynapi.gui.HTMLCalendar','htmlcalendar.js','HTMLContainer');
l.add('dynapi.gui.HTMLCheckBox','htmlcheckbox.js','HTMLComponent');
l.add('dynapi.gui.HTMLHyperLink','htmlhyperlink.js','HTMLComponent');
l.add('dynapi.gui.HTMLRollover','htmlrollover.js',['HTMLHyperLink','Image']);
l.add('dynapi.gui.HTMLClock','htmlclock.js','HTMLContainer');
l.add('dynapi.gui.HTMLMenu','htmlmenu.js','HTMLComponent');
l.add('dynapi.gui.HTMLTextBox','htmltextbox.js','HTMLComponent');
l.add('dynapi.gui.HTMLTextArea','htmltextarea.js','HTMLComponent');
l.add('dynapi.gui.HTMLRadioButton','htmlradiobutton.js','HTMLComponent');
l.add('dynapi.gui.HTMLFile','htmlfile.js','HTMLComponent');
l.add('dynapi.gui.HTMLListbox','htmllistbox.js','HTMLComponent');
l.add('dynapi.gui.HTMLDropDownMenu','htmldropdownmenu.js','HTMLListbox');
l.add('dynapi.gui.HTMLDatePicker','htmldatepicker.js','HTMLComponent');
l.add('dynapi.gui.HTMLProgressBar','htmlprogressbar.js','HTMLComponent');
l.add('dynapi.gui.HTMLColorPicker','htmlcolorpicker.js','HTMLMenu');

// Util
l.addPackage('dynapi.util',p+'util/');
l.add('dynapi.util.Cookie','cookie.js');
l.add('dynapi.util.IOElement','ioelement.js','DynLayer');
l.add('dynapi.util.IOElementSoda','ioelement.soda.js',['Math','IOElement']);
l.add('dynapi.util.IOElementSync','ioelement.sync.js','IOElement');
l.add('dynapi.util.DataSource','datasource.js','IOElement');
l.add('dynapi.util.StringBuffer','stringbuffer.js','DynObject');
l.add('dynapi.util.PoolManager','poolmanager.js');
l.add('dynapi.util.FileReader','filereader.js','IOElementSync');



// Load buffered includes ---------
if(l._buffer){
	var i,ar=l._buffer;
	for(i=0;i<ar.length;i++) l.include(true,ar[i]); // pass agruments true and bufferedAgruments 
	l._buffer=null;
}

