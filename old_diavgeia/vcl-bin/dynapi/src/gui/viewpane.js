/*
   DynAPI Distribution
   Explorer Tree class

   The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

   Requires: DynLayer, ScrollBar
*/

function ViewPane(content,x,y,w,h,style){
	this.DynLayer = DynLayer;
	this.DynLayer(null,x,y,w,h);

	this._showVBar = true;
	this._showHBar = true;

	this.addChild(new DynLayer(null),'lyrContent');
	this.addChild(new DynLayer(),'lyrCorner');
	this.addChild(new ScrollBar('horz',0,0,0,0,0,'ViewPaneScrollBar'),'hscBar');
	this.addChild(new ScrollBar('vert',0,0,0,0,0,'ViewPaneScrollBar'),'vscBar');
	
	this.hscBar.addEventListener(ViewPane.ScrollEvents);
	this.vscBar.addEventListener(ViewPane.ScrollEvents);

	this.lyrContent.addEventListener(ViewPane.ContentResizeEvent);
	this.lyrContent.setAutoSize(true,true);
	this.setContent(content);
	
	this.setStyle(style||'ViewPane');
	this.onCreate(ViewPane.CreateEvent);
};
ViewPane.CreateEvent = function(){
	this.renderStyle();
};
ViewPane.ContentResizeEvent = {
	onresize:function(e){
		var o = e.getSource();
		var vp = o.parent;
		vp.renderStyle('resize');
	}
};
ViewPane.ScrollEvents = {
	onscroll:function(e){
		var o = e.getSource();
		var vp = o.parent;
		var v = o.getValue()*-1;
		if(o==vp.hscBar) vp.lyrContent.setX(v);
		else if(o==vp.vscBar) vp.lyrContent.setY(v);
		vp.invokeEvent('scroll');
	}
};
var p = dynapi.setPrototype('ViewPane','DynLayer');
// Private
p.VPaneOldSetSize = DynLayer.prototype.setSize;
// Public
p.setSize = function(w,h){
	this.VPaneOldSetSize(w,h);
	this.renderStyle('resize');
};
p.setContent = function(c){
	if(c==null) return;
	var lyr = this.lyrContent;
	lyr.setLocation(0,0);
	if(lyr.content) lyr.content.removeFromParent();
	if(typeof(c)=='string') lyr.setHTML(c);
	else {
		lyr.setHTML('&nbsp;');
		lyr.content = lyr.addChild(c);
	}
};
p.setScrollBars = function(v,h){
	this._showVBar=v;
	this._showHBar=h;
	this.renderStyle('resize');
};

// Setup ViewPane ScrollBar styles - to prevent getStyle() from calling loadImages() on registered styles use getStyle('name',true)
Styles.addStyle('ViewPaneScrollBar',Styles.getStyle('ScrollBar',true));
