/*
	DynAPI Distribution
	HTMLProgressBar Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: HTMLComponent
*/

function HTMLProgressBar(css,w,h,value,min,max){
	this.HTMLComponent = HTMLComponent;
	this.HTMLComponent(css||'HCPBar');

	this.w=w||100;
	this.h=h||20;
	this._elmId = this.id+'HCPBar';
	this._defEvtResponse = true;

	this.setRange(min,max);
	this.setValue(value);
};
var p = dynapi.setPrototype('HTMLProgressBar','HTMLComponent');
// Design Properties
p.backCol = '#FFFFFF';
p.barCol = '#0000AA';
p.barImage = null;
// Methods
p._assignElm = function(elm){
	if(!this.parent) return;
	else if(!this.parent._created) return;
	var doc=this.parent.doc;
	if(!elm) {
		id = this._elmId;
		if(dynapi.ua.ie) elm=doc.all[id];
		else if(dynapi.ua.dom) elm=doc.getElementById(id);
		else if(dynapi.ua.ns4) elm = doc.layers[id];
		if(!elm) return;
		// get gauge elm
		id = this._elmId+'Gauge';
		if(dynapi.ua.ie) belm=doc.all[id];
		else if(dynapi.ua.dom) belm=doc.getElementById(id);
		else if(dynapi.ua.ns4) belm = elm.document.layers[id];
	}
	this.elm = elm;
	this.belm =belm;
	this.css = (dynapi.ua.ns4)? elm:elm.style;
	this.doc = this.parent.doc;
};
p.getInnerHTML = function(){
	var ua=dynapi.ua;
	var w=this.w;
	var h=this.h;
	w=w-4;
	if(ua.ns4) h-=3;
	else if(ua.ie) h-=4;
	else h-=2;
	w=parseInt(w*(((this._value/this._max)*100)/100));
	if(ua.ns4) {
		bar = '<layer id="'+this._elmId+'Gauge" left="2" top="2" width="'+w+'" height="'+h+'" '
		+(this.barImage ? 'background="'+this.barImage.src+'"':'bgcolor="'+this.barCol+'"')+' z-index="1"></layer>';
	}
	else {
		bar = '<div id="'+this._elmId+'Gauge" style="left:1px; top:1px; width:'+w+'px; height:'+(h)+'px; '
		+(this.barImage ? 'background-image:url('+this.barImage.src+');':'background-color:'+this.barCol+';')+' z-index:1; display:block; font-size:1px; position:absolute;"></div>';
	}
	return HTMLCell(this._class,this._elmId,bar,this.w,this.h,null,this.backCol,0,false);
};
p.getValue = function(){
	return this._value;
};
p.setValue = function(v){
	var w=this.w;
	if(v<this._min) v = this._min;
	if(v>this._max) v = this._max;
	this._value = v;
	if(this.getElm()){
		w=w-4;
		w=w*(v/this._max);
		if(w<1) w=0; else w=parseInt(w);
		if(dynapi.ua.ns4) this.belm.clip.width = w;
		else this.belm.style.width = w;
	}
};
p.setRange = function(min,max){
	this._min = min||0;
	this._max = max||100;
};

// Write Style to browser
HTMLComponent.writeStyle({
	HCPBar:		'border: 1px solid #000000'
});