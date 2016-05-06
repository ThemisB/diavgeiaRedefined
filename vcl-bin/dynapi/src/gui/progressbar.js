/*
   DynAPI Distribution
   ProgressBar class

   The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

   Requires: DynLayer, ScrollBar
*/

function ProgressBar(orient,x,y,w,h,value,min,max,style){
	this.DynLayer = DynLayer;
	this.DynLayer(null,x,y,w,h);

	this.w=w||20;
	this.h=h||20;
	this._min = min||0;
	this._max = max||100;
	this._value = (value<this._min ? this._min:(value>this._max ? this._max:value));
	this._orient = (orient=='horz')? 'H':'V';
	
	this.addChild(new DynLayer(),'lyrBar');

	this.setStyle(style||'ProgressBar');	
};
var p = dynapi.setPrototype('ProgressBar','DynLayer');
// Private
p.VPaneOldSetSize = DynLayer.prototype.setSize;
// Public
p.setSize = function(w,h){
	this.VPaneOldSetSize(w,h);
	this.renderStyle('resize');
};
p.getValue = function(){
	return this._value;
};
p.setValue = function(v){
	this._value = (v<this._min ? this._min:(v>this._max ? this._max:v));
	this.renderStyle('resize');
};
p.setRange = function(min,max){
	this._min = min||0;
	this._max = max||100;
	this.setValue(this._value);
};

