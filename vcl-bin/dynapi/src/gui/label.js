/*
   DynAPI Distribution
   Label Class

   The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

   Requirements:
	dynapi.api [dynlayer, dyndocument, browser, events]
*/
function Label(text) {
	this.DynLayer = DynLayer;
	this.DynLayer();
	this.wrap = false;
	this.padding = 0;
	this.align = 'left';
	this.font = {};
	this.font.family="arial";
	this.font.size="2";
	this.font.color="#000000";
	this.pWidth = false;
	this.pHeight = false;
	this.selectable	= true;
	this.setText(text);
	this.first = true
	this.onCreate(
		function(e)
		{
		    if (!this.selectable)
		    {
			if (this._created&&(dynapi.ua.def))
			{
		    	    this.css.cursor="default";
			}
		    }
		}
	);
	this.event={
	    onresize:
		function(e)
		{
		    var o = this;
    		    if (o._created) {
    	    		if(dynapi.ua.ns4&&o.wrap) o.setText(o.text)
    	    		    o.pack((o.getWidth()==null)||(o.wrap&&o.pWidth),o.getHeight()==null||o.pHeight)
    	    	    }
		},
	    onmousedown:
		function(e){this._cancelEvt=true;},
	    onmousemove:
		function(e){this._cancelEvt=true;},
	    onmouseup:
		function(e){this._cancelEvt=true;}
	};
	this.addEventListener(this.event);
};
var p = dynapi.setPrototype("Label","DynLayer");

p.setText = function(text) {
	this.text = text || '';
	var styled = '<font size="'+this.font.size+'" face="'+this.font.family+'" color="'+this.font.color+'">'+this.text+'</font>';
	if (this.font.bold) styled = '<b>'+styled+'</b>';
	if (this.font.italic) styled = '<i>'+styled+'</i>';
	
	var width = this.wrap? 'width='+this.w : '';
	var wrap = this.wrap? '':'nowrap';
	this.textFull = '<table '+width+' cellpadding='+this.padding+' cellspacing=0 border=0><tr><td align="'+this.align+'" '+wrap+'>'+styled+'</td></tr></table>';
	this.setHTML(this.textFull);
};
p.setFontFamily = function(f,noevt) {
	this.font.family = f;
	if (noevt!=false) this.setText(this.text);
};
p.setFontSize = function(s,noevt) {
	this.font.size = s;
	if (noevt!=false) this.setText(this.text);
};
p.setFontBold = function(b,noevt) {
	this.font.bold = b;
	if (noevt!=false) this.setText(this.text);
};
p.setFontItalic = function(b,noevt) {
	this.font.italic = b;
	if (noevt!=false) this.setText(this.text);
};
p.setFontColor = function(b,noevt) {
	this.font.color = b;
	if (noevt!=false) this.setText(this.text);
};
p.getText = function() {
	return this.text;
};
p.setWrap = function(wrap,noevt) {
	this.wrap = wrap;
	if (noevt!=false) this.setText(this.text);
};
p.setPadding = function(p,noevt) {
	this.padding = p;
	if (noevt!=false) this.setText(this.text);
};
p.setAlignment = function(a,noevt) {
	this.align = a;
	if (noevt!=false) this.setText(this.text);
};
p.setSelectable = function(b) {
	this.selectable=b
	if (b==false) {
		this.addEventListener(this.selectListener);
		if (this._created&&(is.ie||is.dom)) {
			this.css.cursor="default";
		}
	}
	else {
		this.removeEventListener(this.selectListener);
		if (this._created&&(is.ie||is.dom)) {
			this.css.cursor="text";
		}
	}
};
p.packWidth = function() {
	this.pack(true,false);
};
p.packHeight = function() {
	this.pack(false,true);
};
p.pack = function(bWidth,bHeight) {
	if (!bWidth && bWidth!=false) bWidth=true;
	if (!bHeight && bHeight!=false) bHeight=true;
	this.pWidth = bWidth;
	this.pHeight = bHeight;
	var w = bWidth? this.getContentWidth() : this.w;
	var h = bHeight? this.getContentHeight() : this.h;
	//alert(this.created+' '+w+' '+h)
	if (this._created) this.setSize(w,h,false);
};
