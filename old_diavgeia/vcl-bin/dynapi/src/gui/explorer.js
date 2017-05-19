/*
   DynAPI Distribution
   Explorer Component 

   The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

   Requires: StyleManager, ExplorerStyle (Optional)
*/

function Explorer(x,y,w,h,style) { // Explorer Tree object
	this.DynLayer = DynLayer;
	this.DynLayer(null,x,y,w,h);
	this.allLeaves = [];
	this.root = new Explorer.Leave(this,this+"Root");
	this.currentPos = 0;
	this.currentUrl = "";
	
	this.onCreate(Explorer.CreateEvent);
	this.setStyle(style||'Explorer');
};
// Create Event
Explorer.CreateEvent = function() {
	this.init();
	this.renderStyle();
};
// Prototype
var p = dynapi.setPrototype('Explorer','DynLayer');
p.addLeave = function(id,text,parent,icon,icon_sel,url,css,cssSel) {
	parent=(parent&&(parent!="0"))? parent:this.root.toString();
	new Explorer.Leave(this,id,text,parent,icon,icon_sel,url,css,cssSel);
};
p.fold = function(id) {
	this.allLeaves[id].open = false;
	this.renderStyle();
	return false;
};
p.unfold = function(id) {
	this.allLeaves[id].open = true;
	//alert('eee'+this.allLeaves[id].parent);
	if (this.allLeaves[id].parent) this.unfold(this.allLeaves[id].parent);	
	this.renderStyle();
	return false;
};
p.setCurrent = function(id) {
	this.lastPos = this.currentPos; // set last position
	this.currentPos = id;
	this.currentUrl = this.allLeaves[id].url;
	this.renderStyle();
	this.invokeEvent("select");
	return false;
};
p.unfoldTo = function(id) {
	this.allLeaves[this.firstOne].unfoldTo(id);
	this.currentPos = id;
};
p.getHierarchy = function(leave){
	var h = {};
	h[leave.id]=b;
	while (leave.parent) {
		h[leave.parent]=true;
		leave = this.allLeaves[leave.parent];
	}
	return h;
};
p.init = function() {
	var i,el,pat;
	for(i in this.allLeaves) {
		el = this.allLeaves[i];
		pat = el.parent;
		if(pat) {
			this.allLeaves[pat].children[this.allLeaves[pat].children.length] = el;
			this.allLeaves[pat].count++;
		}
	}
	this.initiated = true;
};



// This object represents a leave in our content tree. Notice that it is not dynlayer-inherited
Explorer.Leave = function(tree,id,text,parent,icon,icon_sel,url,css,cssSel) {
	var style = tree.style;
	// internal
	this.id = id;
	this.tree = tree;
	this.icon = icon;
	this.icon_sel = icon_sel||icon;
	this.url = url;
	this.text = text||"";
	this.parent = parent;
	this.children = [];
	this.count = 0;
	this.css = css;
	this.cssSel = cssSel;
	// state
	this.open = false;
	// init
	this.tree.allLeaves[this.id] = this;
};
p = Explorer.Leave.prototype;
p.unfoldTo = function(c) {
	this.open = false;
	for(var i in this.children) if(this.children[i].unfoldTo(c)) this.open = true;
	return this.open || (this.id == c);
};
p.toString = function() {
	return this.id 
};


	
	