/*
   DynAPI Distribution
   List Class

   The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

   Requirements:
	dynapi.api [dynlayer, dyndocument, nodeitem, events]
	dynapi.gui [NodeItem]
*/

function List(){
	this.DynLayer=DynLayer;
	this.DynLayer();
	this.multiMode = false;
	this.items = [];
	this.listener={
	    onselect : function(e){
	    	var o=e.getSource().parent;o.select(e.getSource());
	    },
	    ondeselect : function(e){
	    	var o=e.getSource().parent;o.deselect(e.getSource());
	    }
	};
	this.onCreate(this.PreCreate);

	/*default style*/
	this.listStyle = {};
	this.listStyle.borders = 1;
	this.listStyle.spacing = 1;
	this.listStyle.padding = 4;
	this.listStyle.bos = false;
	this.listStyle.ios = false;
	this.listStyle.bg = "#eeeeee";
	this.listStyle.bgRoll = "#cccccc";
	this.listStyle.bgSelect = "lightblue";
	this.totalHeight = this.listStyle.borders;
}
var p = dynapi.setPrototype('List','DynLayer');
p.PreCreate=function()
{
	if(this._created)
	{
		this.arrangeItems();
	}
}
p.add = function(){
	if((arguments.length>1) || (arguments.length<5))
	{
		var ls = this.listStyle;
		switch(arguments.length)
		{
			case 2:
				var content=arguments[0];
				var selectedcontent=arguments[0];
				var i = new NodeItem(content,arguments[1]);
				if (ls.bos) selectedcontent="<b>"+selectedcontent+"</b>";
				if (ls.ios) selectedcontent="<i>"+selectedcontent+"</i>";
				i.setSelectedContent(selectedcontent);
			break;

			case 3:
				var i = new NodeItem(arguments[0],arguments[2]);
				i.setSelectedContent(arguments[1]);
			break;

			case 4:
				var i = new NodeItem(arguments[0],arguments[3]);
				i.setSelectedContent(arguments[1]);
				i.setRolloverContent(arguments[2]);
			break;
		}
		i.setColors(ls.bg,ls.bgRoll,ls.bgSelect);
		i.addEventListener(this.listener);
		i.setAutoResize(false,true);
		this.items[this.items.length] = i;
		this.addChild(i);
		if(dynapi.loaded) this.arrangeItems();
	}
};

p.arrangeItems = function(){
	this.totalHeight = this.listStyle.borders;
	for (var i=0;i<this.items.length;i++){
		this.items[i].setLocation(this.listStyle.borders,this.totalHeight);
		this.items[i].setWidth(this.w-this.listStyle.borders*2);
		this.totalHeight = this.totalHeight+this.items[i].h+this.listStyle.spacing;
	}
	this.setHeight(this.totalHeight-this.listStyle.spacing+this.listStyle.borders);
};
p.remove = function(item){
	var i = this.getIndexOf(item);
	if (i==-1) return;
	this.items[i].deleteFromParent();
	dynapi.functions.removeFromArray(this.items,item);
	if (this.selectedIndex==i){
		this.selectedIndex=-1;
		this.selectedItem=null;
	}
	this.arrangeItems();
};

p.origSetWidth = DynLayer.prototype.setWidth;
p.setWidth = function(w){
	this.origSetWidth(w);
	for (var i=0;i<this.items.length;i++){
		this.items[i].setWidth(w-this.listStyle.borders*2);
	}
	this.arrangeItems();
};

p.getIndexOf = function(item){
	for (var i=0;i<this.items.length;i++){
		if (this.items[i]==item) return i;
	}
	return -1;
};
p.select = function(item){
	this.selectedIndex = this.getIndexOf(item);
	this.selectedItem = item;
	this.selectedItem.setSelected(true);
	if (this.multiMode) return;
	for (var i=0;i<this.items.length;i++){
		if (this.items[i] != item) this.items[i].setSelected(false);
	}
	this.invokeEvent("select");
};
p.deselect = function(item){
	if (this.selectedItem == item){
		this.selectedItem = null;
		this.selectedIndex = -1;
	}
};
p.deselectAll = function(){
	for (var i=0;i<this.items.length;i++) {
		if (this.items[i].selected) this.items[i].setSelected(false);
	}
};
	
p.setSelectionMode = function(mode) {
	this.deselectAll();
	this.multiMode = mode;
};
p.setColors = function(bg,bgRoll,bgSelect){
    var ls = this.listStyle;
	ls.bg = bg||ls.bg;
	ls.bgRoll = bgRoll||ls.bgRoll;
	ls.bgSelect = bgSelect||ls.bgSelect;
	if (this.items.length == 0) return;
	for (var i=0;i<this.items.length;i++) {
		this.items[i].setColors(bg,bgRoll,bgSelect);
	}
};
p.boldOnSelect = function(b) {
	this.listStyle.bos = b;
};
p.italicOnSelect = function(b) {
	this.listStyle.ios = b;
};
p.getSelectedIndex = function() {
    return this.selectedIndex;
};
p.getSelectedItem = function() {
	return this.selectedItem;
};
p.getSelectedIndexes = function() {
	var a = [];
	for (var i=0;i<this.items.length;i++) if (this.items[i].selected) a[a.length] = i;
	return a;
};
p.setBorders = function(b){
	this.listStyle.borders = b;
	if (this._created) this.arrangeItems();
};
p.setSpacing = function(b){
	this.listStyle.spacing = b;
	if (this._created) this.arrangeItems();
};
