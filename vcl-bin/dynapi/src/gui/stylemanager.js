/*
	DynAPI Distribution
	StyleManager Class by Raymond Irving (http://dyntools.shorturl.com)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: DynLayer
*/


// Style Object
function Style(){};
var p=Style.prototype;
p.foreColor='#000000';		// same as text-color
p.backColor='#EFEBD7'; 		// #EFEDDE
p.lightColor='#FFFFFF';		// Highlight
p.darkColor='#C0C0C0';		// Shadow
p.borderColor = '#000000';
p.disableColor='#C0C0C0';
p.selForeColor='#000000';
p.selBackColor='#C1D2EE';
p.fontBold = false;
p.fontItalics = false;
p.fontUnderline = false;
p.fontSize='2';
p.fontFamily='arial, helvetica, geneva, sans-serif';
p.initStyle = p.renderStyle = p.removeStyle = p.getParent = p.loadImages = function(){};
// modifies the style's global attribute. This will affect all objects using the style
p.setStyleAttribute = function(name,value,redrawObjects){
	var p = this.getParent();
	if(typeof(name)!='object') this[name]=value;
	else for(var i in name) this[i]=name[i];
	if(redrawObjects) Styles.redraw(this._styleName);
	else if(p) p.renderStyle();
};
// get the global attributes for the style. this function should be used instead of style.attributeName
p.getStyleAttribute = function(name){
	return this[name];
};
p.toString = function(){
	return this.styleName||'Style';
};

//# Style Manager
Styles = StyleManager = {};
Styles._styles = [];
Styles._imagePath = dynapi.library.path+'gui/images/';
Styles._pixel = dynapi.functions.getImage(dynapi.library.path+'gui/images/pixel.gif',1,1);
Styles._lyrContainer = dynapi.document.addChild(new DynLayer({visible:false}));
Styles.getContentSize = function(html){
	var w=0, h=0;
	var c = this._lyrContainer;
	if (html!=null && html!='') {
		if(!dynapi.ua.gecko) html='<table border="0" cellpadding="0" cellspacing="0"><tr><td nowrap>'+html+'</td></tr></table>';
		c.setHTML(html);
		w = c.getContentWidth();
		h = c.getContentHeight();
	}
	return {
		width	:w,
		height	:h
	}
};
Styles.getImage  = function(src,w,h,params){
	var  p = this._imagePath;
	return dynapi.functions.getImage(p+src,w,h,params);
};
Styles.setImagePath = function(p){
	this._ipSet = true;
	this._imagePath = p;
	for(var s in this._styles){ // load/reload images
		s = this._styles[s];
		if(s && s.loadImages) s.loadImages();
	}
};
Styles.addStyle = function(name,style){
	var s = this._styles[name] = ((typeof(style)=='function')? style():style);
	s._styleName=name;	
	if(this._ipSet) s.loadImages();// load default images is imagePath was set by user
	return s;
};
Styles.getStyle = function(name,noload){
	if(!noload && !this._ipSet) {
		// load images if setImagePath was not set by user - use defaults
		this.setImagePath(this._imagePath);
	}
	return this._styles[name];
};
Styles.removeStyle = function(name){
	this._styles[name]=null;
	delete this._styles[name];
};
// Redraw selected style
Styles.redraw = function(name){
	var c,i;
	if(!this._styles[name]) return null;
	for(i in DynObject.all) {
		c=DynObject.all[i];
		if(c && c.style && c.style._styleName==name) {
			c.style.loadImages();
			c.renderStyle();
		}
	}
};
// Redraw all styles
Styles.redrawAll = function(){
	var c,i;
	for(i in DynObject.all) {
		c=DynObject.all[i];
		if(c && c.style) {
			c.style.loadImages();
			c.renderStyle();
		}
	}
};
Styles.createCell = function(t,w,h,border,vAlign,hAlign,bgColor,borColor){
	return [
		'<table width="',w,'" height="',h,'" cellspacing="0" cellpadding="0" border="',(border||0),'" bordercolor="',(borColor||''),'" bgcolor="',(bgColor||''),'" ><tr><td align="',(hAlign||'left'),'" valign="',(vAlign||'middle'),'">',t,'</td></tr></table>'
	].join('');
};
Styles.createPixel = function(w,h){
	return '<img border="0" src="'+this._pixel.src+'" width="'+w+'" height="'+h+'" />';
};
Styles.createPanel = function(b,w,h,borderColor,lightColor,darkColor,backColor){
	b=(b!=null)? b:1;
	if(dynapi.ua.def) {
		// css
		return [
		'<table border="0" width="',w,'" height="',h,'" cellspacing="0" cellpadding="0" style="border:1px solid ',borderColor,'"><tr>',
		'<td valign="middle" align="center" width="100%" style="cursor:default; font-size:1px; border-left:1px solid ',lightColor,'; border-right: 1px solid ',darkColor,'; border-top: 1px solid ',lightColor,'; border-bottom: 1px solid ',darkColor,'" bgcolor="',backColor,'">',
		'&nbsp;</td></tr></table>'
		].join('');
	}
	else {
		// non-css
		return  [
		'<table border="0" width="',w,'" height="',h,'" bgcolor="',borderColor,'" cellspacing="0" cellpadding="0">',
		'<tr><td width="100%" align="center">',
		'<!--light color--><table border="0" width="',(w-2),'" bgcolor="',lightColor,'" height="',(h-2),'" cellspacing="0" cellpadding="0">',
		'<tr><td width="100%" valign="bottom" align="right">',
		'<!--dark color--><table border="0" width="',((w-2)-b),'" height="',((h-2)-b),'" bgcolor="',darkColor,'" cellspacing="0" cellpadding="0">',
		'<tr><td width="100%" valign="top" align="left">',	
		'<!--back color--><table border="0" width="',(((w-2)-b)-b),'"  height="'+(((h-2)-b)-b)+'" bgcolor="',backColor,'" cellspacing="0" cellpadding="0">',
		'<tr><td valign="middle" align="center" width="100%" nowrap>',this.createPixel(1,1),
		'</td></tr></table></td></tr></table></td></tr></table></td></tr></table>'
		].join('');
	}
};
Styles.createText = function(t,fontFamily,fontSize,bold,italics,underline,color){
	if(bold) t='<b>'+t+'</b>';
	if(italics) t='<i>'+t+'</i>';
	if(underline) t='<u>'+t+'</u>';
	return '<font size="'+(fontSize||'')+'" face="'+(fontFamily||'')+'" color="'+(color||'#000000')+'">'+t+'</font>';
};


//# DynLayer Extension
var dlyr = DynLayer.prototype;
dlyr.initStyle = dlyr.renderStyle = dlyr.removeStyle = function(){};
dlyr.setStyle = function(name,a,b,c,d,e,f,g){
	var s=Styles.getStyle(name);
	var os=this.style; // old style
	if(!s) dPrint('Missing or Invalid Style: '+name);
	else {
		if(os && os!=s) this.removeStyle(); //remove old style
		if(os!=s){
			this.style=s;
			this.initStyle = s.initStyle;
			this.renderStyle = s.renderStyle;
			this.removeStyle = s.removeStyle;
			this.initStyle(a,b,c,d,e,f,g); // initailize style with optional arguments
		}
	}
};
// modifies a local style attribute. This will only affect the selected DynLayer
dlyr.setLocalStyleAttribute = function(name,value){
	if(typeof(name)!='object') this[name]=value;
	else for(var i in name) this[i]=name[i];
	if (this.style)	this.renderStyle();
};
// Returns either the local or global style attribute. This function should be used instead of style.attributeName
dlyr.getStyleAttribute = function(name){
	var s=this.style;
	if(!s) s=this;
	return (this[name]||s[name]);
};
