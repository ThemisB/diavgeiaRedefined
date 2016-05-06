/*
   DynAPI Distribution
   List Class

   The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

   Requirements:
	dynapi.api [dynlayer, dyndocument, nodeitem, events]
	dynapi.gui [NodeItem]
*/

function Tree(showLines,defaultOpen){
	this.DynLayer=DynLayer;
	this.DynLayer();
	this.multiMode = false;
	
	this._level=0;
	this.lastItem = false;
	
	this.items = [];
	this.root_name="root";
	
	this.listener={
	    onselect : function(e){
	    	var o=e.getSource().parent;o.select(e.getSource());
	    },
	    ondeselect : function(e){
	    	var o=e.getSource().parent;o.deselect(e.getSource());
	    }
	};
	this.onCreate(this.PreCreate);
	this.defaultOpen=defaultOpen;
	/*default style*/
	this.treeStyle = {};
	this.treeStyle.icons = {};
	this.treeStyle.icons.expand=dynapi.library.path+'gui/images/tvw_expand.gif';
	this.treeStyle.icons.collapse=dynapi.library.path+'gui/images/tvw_collapse.gif';
	this.treeStyle.icons.open=dynapi.library.path+'gui/images/tvw_open.gif';
	this.treeStyle.icons.openLast=dynapi.library.path+'gui/images/tvw_openlast.gif';
	this.treeStyle.icons.close=dynapi.library.path+'gui/images/tvw_close.gif';
	this.treeStyle.icons.closeLast=dynapi.library.path+'gui/images/tvw_closelast.gif';
	this.treeStyle.icons.noChildren=dynapi.library.path+'gui/images/tvw_nochildren.gif';
	this.treeStyle.icons.noChildrenLast=dynapi.library.path+'gui/images/tvw_nochildrenlast.gif';
	this.treeStyle.icons.line=dynapi.library.path+'gui/images/tvw_line.gif';
	this.treeStyle.icons.empty=dynapi.library.path+'gui/images/tvw_white.gif';
	
	this.icons = {};
	this.icons.normal_item=dynapi.library.path+'gui/images/tvw_foldclose.gif';
	this.icons.selected_item=dynapi.library.path+'gui/images/tvw_foldopen.gif';
	this.icons.dir_closed=dynapi.library.path+'gui/images/tvw_foldclose.gif';
	this.icons.dir_opened=dynapi.library.path+'gui/images/tvw_foldopen.gif';
	this.icons.root=dynapi.library.path+='gui/images/tvw_drive.gif';
	
	this.items[this.root_name]=[];
	this.items[this.root_name].haveChild=false;
	this.items[this.root_name].lastItem=false;
	this.items[this.root_name].id=0;
	
	this.level_icons=[];

	this.showLines = showLines;
	
	this.treeStyle.indent = 16;
	this.treeStyle.borders = 1;
	this.treeStyle.spacing = 1;
	this.treeStyle.padding = 4;
	this.treeStyle.bos = false;
	this.treeStyle.ios = false;
	this.treeStyle.bg = 'white';
	this.treeStyle.bgRoll = 'silver';
	this.treeStyle.bgSelect = 'gray';
	this.totalHeight = this.treeStyle.borders;
	this.itemListener = false;
	this.deleteTree=[];
	
	this.itemsAutoWidth=true;
	this.itemsAutoHeight=true;
	this.autoWidth=false;
	this.autoHeight=true;
	this.pWidth=true;
	this.pHeight=true;
}
var p = dynapi.setPrototype('Tree','DynLayer');
p.PreCreate=function()
{
	if(this._created)
	{
		this.arrangeItems();
	}
}
p.addItemEventListener = function (listener)
{
	this.itemListener=listener;
	for(i in this.items)
	{
		if(i!=this.root_name)
		{
			this.items[i]["node"].addEventListener(this.itemListener);
		}
	}
}

p.add = function(parent,id,content,value){		//parent,id,content,value,[icon],[selected icon],[selected content]
	var ts = this.treeStyle;
	var i = new NodeItem(content,value)
	if(arguments.length>6)
	{
		selectedContent=arguments[6];
	}else
	{
		selectedContent=content;
		if (ts.bos) selectedContent="<b>"+selectedContent+"</b>";
		if (ts.ios) selectedContent="<i>"+selectedContent+"</i>";
	}
	i.setSelectedContent(selectedContent);
	i.setColors(ts.bg,ts.bgRoll,ts.bgSelect);
	i.addEventListener(this.listener);
	if(this.itemListener!=false) i.addEventListener(this.itemListener);
	i.setAutoResize(this.itemsAutoWidth,this.itemsAutoHeight);

	var treeObj=new Object();
	treeObj.opened = this.defaultOpen;
	treeObj.parent = parent;
	treeObj.node = i;
	treeObj.id = id;

	icon = new DynLayer();
	treeObj.icon = icon;
	
	selecticon = new DynLayer();
	treeObj.selecticon = selecticon;
	treeObj.normal_icon=this.icons.normal_item;
	treeObj.selected_icon=this.icons.selected_item;
	if(arguments.length>4)	if(arguments[4]!=false){
		treeObj.normal_icon=arguments[4];
		treeObj.selected_icon=arguments[4];
	}
	if(arguments.length>5)	if(arguments[5]!=false) treeObj.selected_icon=arguments[5];

	treeObj.haveChild = false;
	treeObj.lastItem = false;
	this.items[id] = treeObj; 
	this.items[parent].haveChild=true;
	this.items[parent].lastItem = id;

	this.addChild(i);
	this.addChild(icon);
	this.addChild(selecticon);
	if(dynapi.loaded) this.arrangeItems();
};

p.arrangeItems = function()
{
	for(i in this.items)
	{
		if(i!=this.root_name)
		{
			this.items[i].node.setVisible(false);
			this.items[i].icon.setVisible(false);
			this.items[i].selecticon.setVisible(false);
		}
	}
	this.totalHeight = this.treeStyle.borders;
	this._recursiveItems(this.root_name);
	this.setHeight(this.totalHeight-this.treeStyle.spacing+this.treeStyle.borders);
	//this.pack();
}
p._setSelectIcon = function(id,icon)
{
	if(id!=this.root_name)
	{
		this.items[id].selecticon.setHTML('<img src="'+icon+'" border=0>');
	}
}
p._recursiveItems = function(parent)
{
	this._level+=1;
	for(i in this.items)
	{
		if(this.items[i].parent==parent)
		{
			var item=this.items[i];
			var IconContent = '';
			var PreIconContent='';
			var is_last=(this.items[parent].lastItem==i)? true:false;
			if(item.haveChild)
			{
				if(this.showLines)
				{
					open_icon=(is_last)?this.treeStyle.icons.openLast:this.treeStyle.icons.open;
					close_icon=(is_last)?this.treeStyle.icons.closeLast:this.treeStyle.icons.close;
					if(item.opened) IconContent+='<a href="javascript:;" onClick="'+this.toString()+'.collapse(\''+item.id+'\')"><img src="'+close_icon+'" border=0></a>';
					else IconContent+='<a href="javascript:;" onClick="'+this.toString()+'.expand(\''+item.id+'\')"><img src="'+open_icon+'" border=0></a>';
				}else
				{
					if(item.opened) IconContent+='<a href="javascript:;" onClick="'+this.toString()+'.collapse(\''+item.id+'\')"><img src="'+this.treeStyle.icons.collapse+'" border=0></a>';
					else IconContent+='<a href="javascript:;" onClick="'+this.toString()+'.expand(\''+item.id+'\')"><img src="'+this.treeStyle.icons.expand+'" border=0></a>';
				}
			}else
			{
				nochildren_icon=(is_last)?this.treeStyle.icons.noChildrenLast:this.treeStyle.icons.noChildren;
				if(this.showLines) IconContent+='<img src="'+nochildren_icon+'" border=0>';
				else IconContent+='<img src="'+this.treeStyle.icons.empty+'" border=0>';
			}
			if(item.haveChild)
			{
				if(item.opened) SIconContent=this.icons.dir_opened;
				else SIconContent=this.icons.dir_closed;
			}else
			{
				SIconContent=item.normal_icon;
			}
			for(var k=0;k<this.level_icons.length;k++)
			{
				PreIconContent+=this.level_icons[k];
			}
			IconContent=PreIconContent+IconContent;
			item.icon.setHTML(IconContent);
			this._setSelectIcon(item.id,SIconContent);
			iconIndent=(this._level-1)*this.treeStyle.indent;
//			iconIndent=0;
			selectIndent=(this._level)*this.treeStyle.indent;
			contentIndent=(this._level+1)*this.treeStyle.indent+2;
			item.selecticon.setLocation(this.treeStyle.borders+selectIndent,this.totalHeight);
			
			item.icon.setLocation(this.treeStyle.borders,this.totalHeight);
			item.node.setLocation(this.treeStyle.borders+contentIndent,this.totalHeight);
			item.node.setWidth(this.w-this.treeStyle.borders*2);
			item.selecticon.setVisible(true);
			item.icon.setVisible(true);
			item.node.setVisible(true);
			this.totalHeight = this.totalHeight+item.node.h+this.treeStyle.spacing;
			if(item.opened && (item.haveChild))
			{
				if(is_last) this.level_icons[this.level_icons.length]='<img src="'+this.treeStyle.icons.empty+'" border=0>';
				else this.level_icons[this.level_icons.length]='<img src="'+this.treeStyle.icons.line+'" border=0>';
//				this.level_icons[this._level]=;
				this._recursiveItems(i);
				this.level_icons.pop();
			}
		}
	}
	this._level-=1;
}
p.collapse = function(id)
{
	this.items[id].opened=false;
	this.arrangeItems();
}
p.expand = function(id)
{
	this.items[id].opened=true;
	this.arrangeItems();
}
p._removeTree = function(parent)
{
	this.deleteTree[this.deleteTree.length]=parent;
	if(this.items[parent].haveChild)
	{
		for(i in this.items)
		{
			if((i!=this.root_name) && (this.items[i].parent==parent)) this._removeTree(i);
		}
	}
	//alert(this.items[this.items[parent].parent].lastItem);
/*	
	alert(this.items[parent].parent+"=>"+this.items[this.items[parent].parent].lastItem);
*/
}
p.removeSelected=function()
{
	del=this.getSelectedIndexes();
	if(del.length>0)
	{
		for(i in del)
		{
			this._removeItem(del[i]);
		}
	}
}

p.remove = function(item){
	var i = this.getIndexOf(item);
	if ((i==-1) || (i==this.root_name)) return;
	this._removeItem(i);
}
p._removeItem = function(i){
	this.deleteTree=[];
	this._removeTree(i);
	parent=this.items[i].parent;
	for(var j=0;j<this.deleteTree.length;j++)
	{
		this.items[this.deleteTree[j]]["node"].deleteFromParent();
		this.items[this.deleteTree[j]]["icon"].deleteFromParent();
		this.items[this.deleteTree[j]]["selecticon"].deleteFromParent();
		dynapi.functions.removeFromArray(this.items,this.deleteTree[j],true);
	}
	this.items[parent].haveChild=this._haveChild(parent);
	this.items[parent].lastItem=this._getLastItem(parent);
	if (this.selectedIndex==i){
		this.selectedIndex=-1;
		this.selectedItem=null;
	}
	this.arrangeItems();
};
p._getLastItem=function(id)
{
	var ret=false;
	for(i in this.items)
	{
		if(this.items[i].parent==id) ret=i;
	}
	return ret;
}
p._haveChild=function(item)
{
	for(i in this.items)
	{
		if(this.items[i].parent==item) return true;
	}
	return false;
}
p.origSetWidth = DynLayer.prototype.setWidth;
p.setWidth = function(w){
	this.origSetWidth(w);
//	for (var i=0;i<this.items.length;i++){
	for(i in this.items) {
		if(i!=this.root_name) this.items[i]["node"].setWidth(w-this.treeStyle.borders*2);
	}
	this.arrangeItems();
};

p.getIndexOf = function(item){
//	for (var i=0;i<this.items.length;i++){
	for(i in this.items) {
		if (this.items[i]["node"]==item) return i;
	}
	return -1;
};
p.select = function(item){
	
	var index = this.getIndexOf(item);
	if(index!=this.root_name)
	{
		this.selectedIndex = index;
		this.selectedItem = item;
		this.selectedItem.setSelected(true);
		if(!this.items[index].haveChild) this._setSelectIcon(index,this.items[index].selected_icon);
		if (this.multiMode) return;
	//	for (var i=0;i<this.items.length;i++){
		for(i in this.items) {
			if (i!=this.root_name && this.items[i]["node"] != item)
			{
				this.items[i]["node"].setSelected(false);
				if(!this.items[i].haveChild)
				{
					this._setSelectIcon(i,this.items[i].normal_icon);
				}
			}
		}
	}
	this.invokeEvent("select");
};
p.deselect = function(item){
	if (this.selectedItem == item){
		this.selectedItem = null;
		var index=this.getIndexOf(item);
		if(index!=this.root_name)
		{
			if(!this.items[index].haveChild) this._setSelectIcon(index,this.items[index].normal_icon);
			this.selectedIndex = -1;
		}
	}
};
p.deselectAll = function(){
//	for (var i=0;i<this.items.length;i++) {
	for(i in this.items) {
		if(i!=this.root_name)
		{
			if (this.items[i]["node"].selected)
			{
				var index=i;
				if(!this.items[index].haveChild) this._setSelectIcon(index,this.items[index].normal_icon);
				this.items[i]["node"].setSelected(false);
			}
		}
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
//	for (var i=0;i<this.items.length;i++) {
	for(i in this.items)
	{
		if(i!=this.root_name) this.items[i]["node"].setColors(bg,bgRoll,bgSelect);
	}
};
p.boldOnSelect = function(b) {
	this.treeStyle.bos = b;
};
p.italicOnSelect = function(b) {
	this.treeStyle.ios = b;
};
p.getSelectedIndex = function() {
    return this.selectedIndex;
};
p.getSelectedItem = function() {
	return this.selectedItem;
};
p.getSelectedIndexes = function() {
	var a = [];
//	for (var i=0;i<this.items.length;i++) if (this.items[i].selected) a[a.length] = i;
	for(i in this.items) if(i!=this.root_name && this.items[i]["node"].selected) a[a.length] = i;
	return a;
};

p.setBorders = function(b){
	this.treeStyle.borders = b;
	if (this._created) this.arrangeItems();
};
p.setSpacing = function(b){
	this.treeStyle.spacing = b;
	if (this._created) this.arrangeItems();
};

p.showLines = function(b)
{
	this.showLines=b;
	this.arrangeItems();
}

p.itemsResize=function(bwidth,bheight)
{
	this.itemsAutoWidth=bwidth;
	this.itemsAutoHeight=bheight;
	for(i in this.items)
	{
		if(i!=this.root_name) this.items[i].node.setAutoResize(this.itemsAutoWidth,this.itemsAutoHeight);
	}
//	this.pack();
	this.arrangeItems();
}
p.getInnerWidth=function()
{
	var w=0;
	for(i in this.items)
	{
		if(i!=this.root_name)
		{
			leftpos=(this.items[i]['node'].getX()+this.items[i]['node'].getWidth());
			if(w<leftpos)
			{
				w=leftpos;
			}
		}
	}
	return w;
}
p.getInnerHeight=function()
{
	var h=0;
	for(i in this.items)
	{
		if(i!=this.root_name)
		{
			toppos=(this.items[i]['node'].getY()+this.items[i]['node'].getHeight());
			if(h<toppos)
			{
				h=toppos;
			}
		}
	}
	return h;
}

/*
p.autoResize=function(bwidth,bheight)
{
	this.autoWidth=bwidth;
	this.autoHeight=bheight;
	this.pack();
}
p.pack=function()
{
	bWidth=this.autoWidth;
	bHeight=this.autoHeight;
	if (!bWidth && bWidth!=false) bWidth=true;
	if (!bHeight && bHeight!=false) bHeight=true;
	var w = bWidth? this.getInnerWidth() : this.w;
	var h = bHeight? this.getInnerHeight() : this.h;
	alert(h);
	w+=(this.treeStyle.borders-this.treeStyle.spacing)
	h+=(this.treeStyle.borders-this.treeStyle.spacing);
	alert(h);
	if (this._created) this.setSize(w,h,false);
}
*/
