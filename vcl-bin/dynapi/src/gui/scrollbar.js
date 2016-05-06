/*
   DynAPI Distribution
   ScrollBar Component by Raymond Irving (http://dyntools.shorturl.com)

   The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

   Requires: StyleManager, Button, ScrollBarStyle (Optional)
*/

function ScrollBar(orient,x,y,length,min,max,style){	
	this.DynLayer=DynLayer;
	this.DynLayer(null,x,y);

	this.addChild(new DynLayer(),'lyrTrack');
	var up=this.addChild(new Button(null,null,null,null,null,'ScrollBarButton'),'btnUp');
	var dn=this.addChild(new Button(null,null,null,null,null,'ScrollBarButton'),'btnDown');
	var knob=this.addChild(new Knob(null,null,null,null,'ScrollBarKnob'),'knob');

	this._lScale=1;
	this._sScale=1;
	this._knobMinSize=16;	
	this._value=(min||0);
	this._fixKnobSize=false;
	this._bartype=(orient=='horz')? 'H':'V';
	
	up.addEventListener(ScrollBar.ButtonEvents);
	dn.addEventListener(ScrollBar.ButtonEvents);
	knob.addEventListener(ScrollBar.KnobEvents);
	this.addEventListener(ScrollBar.MouseEvents);

	this.setLength(length);
	this.setRange(min,max);
	
	this.setStyle(style||'ScrollBar');
};
var p= dynapi.setPrototype('ScrollBar','DynLayer');
// Private
p.ScrlOldSetSize = DynLayer.prototype.setSize;
// Public
p.setSize = function(w,h){
	this.ScrlOldSetSize(w,h);
	this._adjustKnob();
	this.renderStyle('resize');
};
p._adjustKnob = function(){
	var knob=this.knob;
	if(this._min==this._max) knob.setVisible(false);
	else{
		var ww,scale,bs,trackLen,knobXY;
		var vl=this._value-this._min;
		var range=(this._max-this._min);
		var oldKnobSize=this.knobSize;
		if(this._bartype=='V') {	
			bs=this.btnUp.h;
			trackLen=this.h-(bs*2);
		}else {
			bs=this.btnUp.w;
			trackLen=this.w-(bs*2);
		}
		this._btnSize=bs;
		if (this._fixKnobSize) this.knobSize=this._knobMinSize;
		else this.knobSize=Math.max(Math.floor(trackLen-((range+1)/2)),this._knobMinSize);
		scale=this._scale=(trackLen-this.knobSize)/range;
		knobXY=bs+Math.floor(vl*scale);
		if(this._bartype=='V') {
			knob.setLocation(null,knobXY);
			knob.setHeight(this.knobSize);
		}else {
			knob.setLocation(knobXY,null);
			knob.setWidth(this.knobSize);
		}
		if(!knob.getVisible()) knob.setVisible(true);
	}
};
p._autoScroll = function(b,_loop){
	var knob=this.knob;
	var ay=this._autoY;
	var ax=this._autoX;
	var kh=knob.h, kw=knob.w;
	var ky=knob.y, kx=knob.x;
	var ms=0;

	b=(b)? true:false;
	if (this._autoDir=='up') this.scrollUp(b);
	else if(this._autoDir=='dn') this.scrollDown(b);
	else if(this._bartype=='V'){
		if(ay>=ky && ay<=(ky+kh)){this.stopAutoScroll();return;}
		else if(this._dir=='up' && ay>(kh+ky)) this.scrollUp(b);
		else if(this._dir=='dn' && ay<(kh+ky)) this.scrollDown(b);
		else{
			this.stopAutoScroll();
			return;
		}
	}else{
		if(ax>=kx && ax<=(kx+kw)) {this.stopAutoScroll();return;}
		else if(this._dir=='up' && ax>(kw+kx)) this.scrollUp(b);
		else if(this._dir=='dn' && ax<(kw+kx)) this.scrollDown(b);
		else {
			this.stopAutoScroll();
			return;
		}
	}
	if(_loop) ms=10; else ms=400;
	this._srclTimer=window.setTimeout(this+'._autoScroll('+b+',true)',ms);
};
p._setDSValue = function(b){
	this.setValue(b);
};

// Public
p.getLength = function(){return this._length;};
p.setLength = function(n){
	var sz;
	this._length=n;
	if(this._bartype=='V') {
		sz=(!this.w||this.w<16)? 16:this.w;
		this.setSize(sz,this._length);
	}else {
		sz=(!this.h||this.h<16)? 16:this.h;
		this.setSize(this._length,sz);	
	}
	if(this._created){this._adjustKnob();}
};
p.setMinKnobSize = function(n){
	this._knobMinSize=(n||16);
};
p.setRange = function(min,max){
	this._min=(min!=null)? min:0;
	this._max=(max!=null)? max:0;
	if(this._value>this._max) this._value=this._max;
	else if(this._value<this._min) this._value=this._min;
	this._adjustKnob();
};
p.getValue=function(){ return this._value;};
p.setValue=function(v,noevt){
	this._value=v
	if (this._value>this._max) this._value=this._max;
	else if (this._value<this._min) this._value=this._min;
	this._adjustKnob();
	if(!noevt) this.invokeEvent('scroll');
};
p.setLargeChange = function(n){
	this._lScale=parseInt(n);
};
p.setSmallChange = function(n){
	this._sScale=parseInt(n);
};
p.scrollUp=function(bigscale){
	var v=this._value;
	v+=(!bigscale)? this._sScale:this._lScale;
	this.setValue(v);
	this._dir='up';
	this.invokeEvent('scroll');
};
p.scrollDown=function(bigscale){
	var v=this._value;
	v-=(!bigscale)? this._sScale:this._lScale;
	this.setValue(v);
	this._dir='dn';
	this.invokeEvent('scroll');
};
p.startAutoScroll=function(dir,x,y,bigscale){
	this._autoX=x;
	this._autoY=y;
	this._autoDir=dir;
	bigscale=(bigscale)? true:false
	this._autoScroll(bigscale);
};
p.stopAutoScroll=function(){
	if(this._srclTimer==0) return;
	window.clearTimeout(this._srclTimer);
	this._srclTimer=0;
};

/* Events */
ScrollBar.ButtonEvents = {
	onmousedown : function(e){
		var bn=e.getSource();
		var o=bn.parent;
		var dir;
		e.preventBubble();
		if(bn==bn.parent.btnUp) dir='up'; else dir='dn';
		o.startAutoScroll(dir);
	},
	onmouseup : function(e){
		var bn=e.getSource();
		var o=bn.parent;
		e.preventBubble();
		o.stopAutoScroll();
		// prevent knob from being dragged when mouse over button
		if(DragEvent.dragevent.isDragging) DragEvent.dragevent.cancelDrag();
	},
	onmouseout : function(e){
		var bn=e.getSource();
		var o=bn.parent;
		e.preventBubble()
		o.stopAutoScroll();
	}
};
ScrollBar.KnobEvents = {
	onmousedown : function(e){
		var o=e.getSource().parent;	
		e.preventBubble()
	},
	ondragstart : function(e){
		var o=e.getSource().parent;	
		e.preventBubble()		
	},
	ondragstop : function(e){
		var o=e.getSource().parent;	
		e.preventBubble()
		o._adjustKnob();
	},
	ondragmove : function(e){
		var knob=e.getSource();	
		var o = knob.parent;
		var xy=(o._bartype=='V')? knob.y:knob.x;
		e.preventBubble()
		o._value = parseInt((xy-o._btnSize)/o._scale)+o._min;
		o.invokeEvent('scroll');
	}
};
ScrollBar.MouseEvents = {
	onmousedown : function(e){
		var d='x',o=e.getSource();
		var x=e.getX();
		var y=e.getY();
		if(o._bartype=='V') {
			if(y<o.knob.y) d='dn'; else  d='up';
		}
		if(o._bartype=='H'){
			if(x<o.knob.x) d='dn'; else d='up';
		}
		o._dir=d;
		o.startAutoScroll(null,x,y,true);
	},
	onmouseup : function(e){
		var o=e.getSource();
		o.stopAutoScroll();
	},
	onmouseout : function(e){
		var o=e.getSource();
		o.stopAutoScroll();
	}	
};

// Setup ScrollBar Button & Knob styles - to prevent getStyle() from calling loadImages() on registered styles use getStyle('name',true)
Styles.addStyle('ScrollBarButton',Styles.getStyle('Button',true));
Styles.addStyle('ScrollBarKnob',Styles.getStyle('Knob',true));

