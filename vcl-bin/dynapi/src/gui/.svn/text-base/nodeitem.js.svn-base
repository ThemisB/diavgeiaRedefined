function NodeItem(content,value){
	this.DynLayer=DynLayer;
	this.DynLayer();
	this.value = value;
	this.deselectable = true;
	this.isMouseOver = false;
	this.selected = false;
	this.itemStyle = {};
	
	this.autoWidth = false;
	this.autoHeight = true;
	
	this.normalContent=content;
	this.selectedContent=content;
	this.rolloverContent=content;
	this.setHTML(this.normalContent);
	this.onCreate(this.preCreate);
	this.listevents={
	onmousedown:
	    function (e) {
		var o = e.getSource();
		o.setSelected(!o.selected);
		o.pack();
	    },
	ondragover:function(e)
	{
	    function (e) {
		var o = e.getSource();
		if (!o.selected && !o.isMouseOver) {
		    o.setBgColor(o.itemStyle.bgColorRoll);
			o.setHTML(o.rolloverContent);
			o.pack()
		}
		o.isMouseOver = true;
	    }
		
	},
	onmouseover:
	    function (e) {
		var o = e.getSource();
		if (!o.selected && !o.isMouseOver) {
		    o.setBgColor(o.itemStyle.bgColorRoll);
			o.setHTML(o.rolloverContent);
			o.pack();
		}
		o.isMouseOver = true;
	    },
	ondragout:
	    function (e) {
		var o = e.getSource();
		    if (!o.selected && o.isMouseOver) {
			o.setBgColor(o.itemStyle.bgColor);
			o.setHTML(o.normalContent);
			o.pack()
		    }
		o.isMouseOver = false;
	    },
	onmouseout:
	    function (e) {
		var o = e.getSource();
		    if (!o.selected && o.isMouseOver) {
			o.setBgColor(o.itemStyle.bgColor);
			o.setHTML(o.normalContent);
			o.pack();
		    }
		o.isMouseOver = false;
	    }
	};
	this.addEventListener(this.listevents);
}
var p=dynapi.setPrototype('NodeItem','DynLayer');
p.setColors = function(bg,bgr,bgs) {
    var s = this.itemStyle;
	s.bgColor = bg||'#eeeeee';
	s.bgColorRoll = bgr||'#cccccc';
	s.bgColorSelect = bgs||'lightblue';
	this.setBgColor(s.bgColor);
};
p.setSelectedContent = function(content) {
	this.selectedContent=content;
};
p.setRolloverContent = function(content) {
	this.rolloverContent = content;
};
	
p.setSelected = function(b) {
	if (this.selected==b || !this.deselectable) return;
	this.selected=b;
	if (b) {
		this.setBgColor(this.itemStyle.bgColorSelect);
		this.setHTML(this.selectedContent);
		this.pack();
		this.invokeEvent("select");
	}
	else {
		this.setBgColor(this.isMouseOver?this.itemStyle.bgColorRoll:this.itemStyle.bgColor)
		this.setHTML(this.isMouseOver?this.rolloverContent:this.normalContent);
		this.invokeEvent("deselect");
	}
}
p.setValue = function(value) {
	this.value=value;
};
p.getValue = function() {
	return this.value;
};
p.setAutoResize = function (bwidth,bheight)
{
	this.autoWidth=bwidth;
	this.autoHeight=bheight;
	this.pack(this.autoWidth,this.autoHeight);
}
p.pack = function()
{
	bWidth=this.autoWidth;
	bHeight=this.autoHeight;
	if (!bWidth && bWidth!=false) bWidth=true;
	if (!bHeight && bHeight!=false) bHeight=true;
	var w = bWidth? this.getContentWidth() : this.w;
	var h = bHeight? this.getContentHeight() : this.h;
	if (this._created) this.setSize(w,h,false);
}
