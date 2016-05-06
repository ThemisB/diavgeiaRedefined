/*
   DynAPI Distribution
   Marquee Component by Raymond Irving (http://dyntools.shorturl.com)

   The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

   Requires: StyleManager, MarqueeStyle (Optional)
*/

function Marquee(html,x,y,w,h,style) {
	this.DynLayer=DynLayer;
	this.DynLayer(null,x,y,w,h);

	this._cvhtml=(html)? html:Styles.createPixel(1,1);
	var canvas=this.addChild(new DynLayer(null,-1000,-1000),'lyrCanvas');
	canvas.addEventListener(Marquee.PathEvents);
	this._inc=5;
	this._delay=120;
	this._dir='left';
	this._behave='slide';
	this._action='stop';
	this._loop=true;
	
	this.onCreate(Marquee.CreateEvent);
	this.setStyle(style||'Marquee');	
};

/* Prototype */
var p=dynapi.setPrototype('Marquee','DynLayer');
// Private
p._animate=function(){
	if(this._action=='stop') return;
	var ex=0,sx=0,sy=0,ey=0;
	var c=this.lyrCanvas;
	if(this._behave=='slide'){
		if(this._dir=='top') {sy=this.h; ey=0-c.h;}
		else if(this._dir=='bottom') {sy=0-c.h; ey=this.h;}
		else if(this._dir=='right') {sx=0-c.w; ex=this.w;}
		else {sx=this.w; ex=0-c.w}
	}else if(this._behave=='scroll'){
		if(this._dir=='top') {sy=this.h; ey=0;}
		else if(this._dir=='bottom') {sy=0-c.h; ey=this.h-c.h;}
		else if(this._dir=='right') {sx=0-c.w; ex=this.w-c.w;}
		else {sx=this.w; ex=0}
	}
	c.setLocation(sx,sy);
	c.slideTo(ex,ey,this._inc,this._delay);
};

// Public
p.setDirection = function(t) {
	//top,bottom,left,right
	this._dir=t;
};
p.setHTML = function(h){
	this.html = h;
	this.renderStyle('html');
};
p.setSpeed = function(delay,inc){
	this._delay=parseInt(delay);
	this._inc=parseInt(inc);
};
p.setBehavior = function(t){
	// slide,scroll
	this._behave=t;
};
p.setRepeat = function(b){
	this._loop=b;
};
p.start = function(){ 
	this._action='start';
	if(this._created) this._animate();
};
p.stop = function(){ 
	this._action='stop';
};

/* Events */
Marquee.PathEvents = {
	onpathfinish : function(e) {
		var canvas=e.getSource()
		var o=canvas.parent;
		if(o._loop && o._behave!='scroll') o._animate();
		else o.stop();
	}
};
Marquee.CreateEvent = function(){
	this.start();
};