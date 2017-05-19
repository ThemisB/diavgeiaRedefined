/*
	DynAPI Distribution
	Button Component by Raymond Irving (http://dyntools.shorturl.com)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: StyleManager, ButtonStyle (Optional)
*/

function Button(cap,x,y,w,h,style){
	this.DynLayer = DynLayer;
	this.DynLayer(null,x,y,w,h);
	this._hAlign = 'center';
	this._vAlign = 'middle';
	this._caption = cap||'';
	this.setStyle(style||'Button');
};
p = dynapi.setPrototype('Button','DynLayer');
// Private
p.BtnOldSetSize = DynLayer.prototype.setSize;
p._getCapHTML = function(){
	var c = this._caption;
	var ff=this.getStyleAttribute('fontFamily');
	var fs=this.getStyleAttribute('fontSize');
	var fb=this.getStyleAttribute('fontBold');
	var fi=this.getStyleAttribute('fontItalics');
	var fu=this.getStyleAttribute('fontUnderline');
	var fc=(this._disabled)? this.getStyleAttribute('disableColor'):this.getStyleAttribute('foreColor');
	return Styles.createCell(
		Styles.createText(c,ff,fs,fb,fi,fu,fc),
		this.w,this.h,0,this._vAlign,this._hAlign
	);
};
// Public
p.getCaption=function(){return this._caption;};
p.setSize = function(w,h){
	this.BtnOldSetSize(w,h);
	this.renderStyle('resize');
};
p.setCaption = function(t,hAlign,vAlign){
	this._caption = t||'';
	this._hAlign =  (hAlign)? hAlign:this._hAlign;
	this._vAlign = (vAlign)? vAlign:this._vAlign;
	this.renderStyle('caption');
};
p.setEnabled = function(b){
	this._disabled=!b;
	this.renderStyle('caption');
};