/*
   DynAPI Distribution
   ListBox Component by Raymond Irving (http://dyntools.shorturl.com)

   The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

   Requires: StyleManager, ScrollBar, ListBoxStyle (Optional)
*/

function ListBox(items,x,y,w,h,style) {
	this.DynLayer = DynLayer;
	this.DynLayer(null,x,y,w,h);

	this._lh=0
	this._items=[];
	this._itemkeys={};
	this._lastXPos=0;
	this._lastYPos=0;
	this._itemHeight=18;
	this._autoHeight=false;
	this._checkMode=false;
	this._multiSelect=false;
	this._pool = new PoolManager(this);	
	this.addChild(new DynLayer(null,0,0,0,0),'lyrItms');
	this.lyrItms.setAnchor({left:1,right:1,top:1,bottom:1})
	this.addChild(new ScrollBar('vert'),'vscBar');
	this.vscBar.addEventListener(ListBox.VScrollBarEvents);
	this.vscBar.setVisible(false);
	
	// setup inserted items
	if(items) for(var i in items) this.addItem(items[i],i);
	
	this.onCreate(this._initItemsLayout);
	this.setStyle(style||'ListBox');

};

/* Prototype */
var p = dynapi.setPrototype('ListBox','DynLayer');
// Private
p._CreatePoolObject=function(){
	var lyr=this.lyrItms.addChild(new DynLayer(null,0,0,0,0));
	lyr.setTextSelectable(false);
	lyr.setCursor('default')
	if(dynapi.ua.ns4) lyr.captureMouseEvents();
	lyr.setAnchor({left:0,right:0})
	lyr.addEventListener(ListBox.ItemEvents);
	return lyr;
};
p._ResetPoolObject=function(o){
	if(o) {
		o.setVisible(false);
		return o;
	}
};
p._adjustLayoutSize = function(lw,lh){
	if(lw>this.w) this._lastWidth=lw;
	else this._lastWidth=this.w;
	if(lh) this._lastHeight=lh;
	if(lh>this.h) {
		this.vscBar.setVisible(true);
		this.vscBar.setRange(0,lh-this.h);
		this.vscBar.setSmallChange(this._itemHeight);
		this.vscBar.setLargeChange(this._itemHeight*3);
		if((this.h-2)!=this.vscBar.h) this.renderStyle('resize');
	}
};
p._adjustItemSize = function(itm){
	if(!this._autoHeight) {
		itm.w = this.w;
		itm.h=this._itemHeight;
	}else {
		var sz=Styles.getContentSize(itm.html);	
		itm.w=sz.width;
		itm.h=sz.height;
	}
	return itm;
};
p._getItem = function(indexkey){
	var i=indexkey;
	if(typeof(i)=='string') i=this._itemkeys[i];
	if(i==null) return;
	return this._items[i];
};
p._modItemsLayout = function(redraw){
	var scont;
	var i,fc,img,o,c,ly;
	// make sure unsed items are returned to pool
	for(i=0;i<this.lyrItms.children.length;i++){
		c=this.lyrItms.children[i];
		o=this._items[c._itemIndex];
		if(o){
			ly=o.y-(this._lastYPos*-1); // get last Y
			if(!(o.h && ((ly>=0 && ly<=this.h) || ((ly+o.h)>=0 && ly<=this.h)))){
				if(o.h && o.lyr) {
					this._pool.storeObject(o.lyr);
					o.lyr=null;
				}
			}
		}
	}
	for(i=0;i<this._items.length;i++){
		itm=this._items[i];
		if(itm){
			ly=itm.y-(this._lastYPos*-1);
			if(itm.h && ((ly>=0 && ly<=this.h) || ((ly+itm.h)>=0 && ly<=this.h))){
				if(itm.lyr) scont=false;
				else {
					itm.lyr=this._pool.getObject();
					itm.lyr._itemIndex=i;
					scont=true;
				}
				if(redraw || scont) this._modItemContent(itm);
				this._modItemColor(itm);
				itm.lyr.setY(itm.y+this._lastYPos);
				itm.lyr.setHeight(itm.h);
				itm.lyr.setVisible(true);
			}
			else if(itm.h && itm.lyr) {
				// return layer to pool when not in use
				this._pool.storeObject(itm.lyr);
				itm.lyr=null;
			}
		}
	}
};
p._modItemContent = function(itm){
	var c,t,img;
	var css = itm.css;
	if(!itm.lyr) return;
	if(!this._checkMode) img=Styles.createPixel(3,1);
	else {
		img=(itm.selected)? this.getStyleAttribute('imageOn'):this.getStyleAttribute('imageOff');
		if(img) img = img.getHTML(); else img='';
	}
	c=(itm.selected)? this.getStyleAttribute('selForeColor'):null;
	if(css) t=itm.html;
	else t=Styles.createText(itm.html,
		this.getStyleAttribute('fontFamily'),
		this.getStyleAttribute('fontSize'),
		this.getStyleAttribute('fontBold'),
		this.getStyleAttribute('fontItalics'),
		this.getStyleAttribute('fontUnderline'),c
	);
	if(css && css!=true) css='class="'+css+'"'; else css='';
	if(dynapi.ua.ns4) t='<ilayer '+css+'>'+t+'</ilayer>';
	t='<table '+css+' width="100%" border="0" cellpadding="1" cellspacing="0"><tr>'
	+'<td valign="top" nowrap width="1">'+img+'</td><td nowrap>'+t+'</td></tr></table>';
	itm.lyr.setHTML(t);
};
p._modItemColor = function(itm){
	if(!itm.lyr) return;
	var c;
	var i=itm.lyr._itemIndex;
	if((i%2)!=0) c=this.getStyleAttribute('firstRowColor');
	else c=this.getStyleAttribute('altRowColor');
	if(!itm.selected) itm.lyr.setBgColor(c);
	else itm.lyr.setBgColor(this.getStyleAttribute('selBackColor'));
};
p._modItemSelState = function(itm,state){
	var lItm=this._lastSelItem;
	itm.selected=state;
	if(lItm && lItm!=itm && !this._multiSelect) {
		lItm.selected=false;
		this._modItemContent(lItm);
		this._modItemColor(lItm);
	}
	this._modItemContent(itm);
	this._modItemColor(itm)
	this._lastSelItem = itm;
};
p._initItemsLayout = function(){
	var i,sz,itm,lh=0,lw=0;
	for(i=0;i<this._items.length;i++){
		itm=this._items[i];
		if(itm){
			itm=this._adjustItemSize(itm);
			itm.y=lh;
			if(lh==0) lh=itm.h;
			else lh+=itm.h;
			if(lw<itm.w) lw=itm.w;			
		}
	}
	this._adjustLayoutSize(lw,lh);
	window.setTimeout(this+'._modItemsLayout();',100);
};
p.LBoxOldSetSize = DynLayer.prototype.setSize;

// Public
p.addItem = function(css,itext,value,key){
	if(key && this._itemkeys[key]){
		this.invokeEvent('error',null,'Duplicate key found');
		return;
	};
	var itm={x:0,y:0,selected:false};
	if(itext && itext.getHTML) itext=itex.getHTML();
	else if(itext==null) itext='';
	itm.css = css; // when css == true remove <font> tags
	itm.html=itext;
	itm.value=value;
	if(dynapi.loaded) {
		itm=this._adjustItemSize(itm);
		itm.y=this._lastHeight;
		this._lastHeight+=itm.h;
		if(itm.w>this._lastWidth) this._lastWidth=itm.w;
		this._adjustLayoutSize(this._lastWidth,this._lastHeight);
	}
	var i=itm.index=this._items.length;
	this._items[i]=itm;
	if(key) this._itemkeys[key]=i;
	if(this._created) this._modItemsLayout();
	return i;
};
p.getItemCount = function(){
	return this._items.length;
};
p.getItemValue = function(indexkey){
	var itm=(indexkey!=null)? this._getItem(indexkey):this._lastSelItem;
	if(itm) return itm.value;
};
p.getItemText = function(indexkey){
	var itm=(indexkey!=null)? this._getItem(indexkey):this._lastSelItem;
	if(itm) return itm.html;
};
p.makeItemVisible = function(indexkey){
	var itm=(indexkey!=null)? this._getItem(indexkey):this._lastSelItem;
	if(!itm) return;
	// TO DO:
	//this.vscBar.setValue(itm.y);
};
p.removeAllItems = function(){
	var i,o;
	for(i=0;i<this._items.length;i++){
		o=this._items[i];
		this._pool.storeObject(o.lyr);
	}
	this._items=[];
	this._itemkeys={};
};
p.removeItem = function(indexkey){
	var i,o;
	var itm=(indexkey!=null)? this._getItem(indexkey):this._lastSelItem;
	if(itm) {
		this._lastHeight-=itm.h;
		this._pool.storeObject(itm.lyr);
		for(i=itm.index+1;i<this._items.length;i++){
			o=this._items[i];
			o.y-=itm.h;
			o.index-=1;
			if(o.lyr) o.lyr._itemIndex-=1;
		}
		if(itm==this._lastSelItem) this._lastSelItem=null;
		this._items=dynapi.functions.removeFromArray(this._items,itm.index);
		if(itm.key) delete this._itemkeys[itm.key];
		this._modItemsLayout();
	};
};
p.setItemText = function(itext,indexkey){
	var itm=(indexkey!=null)? this._getItem(indexkey):this._lastSelItem;
	if(!itm) return;
	if(itext && itext.getHTML) itext=itex.getHTML();
	else if(itext==null) itext='';
	itm.html=itext;
	if(this._autoHeight){
		var lw=this._lastWidth;
		var lh=this._lastHeight;
		var nh,oh=itm.h, ow=itm.w;
		itm=this._adjustItemSize(itm);		
		nh=itm.h-oh;
		if(nh!=0) lh+=nh;
		if(itm.w>lw)lw=itm.w;
		this._adjustLayoutSize(lw,lh);
		if(itm.lyr) this._modItemsLayout();
	}	
};
p.setItemValue = function(vl,indexkey){
	var itm=(indexkey!=null)? this._getItem(indexkey):this._lastSelItem;
	if(itm) itm.value=vl;
};
p.selectItem = function(indexkey){
	var itm=(indexkey!=null)? this._getItem(indexkey):this._lastSelItem;
	if(itm) this._modItemSelState(itm,true);
};
p.setAltColors = function(fcolor,scolor){
	this.setLocalStyleAttribute('firstRowColor',fcolor);
	this.setLocalStyleAttribute('altRowColor',scolor);
	this.lyrItms.setBgColor(fcolor);
};
p.setItemHeight = function(n) { // 'auto' - for auto height
	if(n=='auto') this._autoHeight=true;
	else {
		this._itemHeight=18;	
		this._autoHeight=false;
	}
};
p.setCheckMode = function(b){
	this._checkMode=b;
	this._multiSelect=true;
	if(this._created) this._modItemsLayout(true);
};
p.setMultiSelect = function(b){
	this._multiSelect=b;
	if(!b){
		for(i=0;i<this._items.length;i++){
			o=this._items[i];
			o.selected=false;
		}
		if(this._created) this._modItemsLayout(true);
	}
};
p.setSize = function(w,h){
	this.LBoxOldSetSize(w,h);
	this._adjustLayoutSize();
	this.renderStyle('resize');
};
//p.sortByText();
//p.sortByValue();
//p.selectAll()
//p.deselectAll()
//invertSelection()

/* Events */
ListBox.ItemEvents = {
	onmouseover : function(e){
		var o=e.getSource();
		var lbox=o.parent.parent;
		var itm=lbox._items[o._itemIndex];
		if(itm.selected) return;
		o.setBgColor(lbox.getStyleAttribute('selBackColor'));
	},
	onmouseout : function(e){
		var c,o=e.getSource();
		var lbox=o.parent.parent;
		var itm=lbox._items[o._itemIndex];
		if(itm.selected) return;
		if((o._itemIndex%2)!=0) c=lbox.getStyleAttribute('firstRowColor');
		else c=lbox.getStyleAttribute('altRowColor');
		o.setBgColor(c);
	},
	onclick : function(e){
		var o=e.getSource();
		var lbox=o.parent.parent;
		var itm=lbox._items[o._itemIndex];
		var state=(!lbox._multiSelect)? true:!itm.selected;
		lbox._modItemSelState(itm,state);
	}
};
ListBox.VScrollBarEvents = {
	onscroll : function(e){
		var vbar=e.getSource();
		var lbox=vbar.parent;
		lbox._lastYPos=vbar.getValue()*-1;
		if(lbox.trm) window.clearTimeout(lbox.trm);
		lbox.trm=window.setTimeout(lbox+'._modItemsLayout()',10);
		lbox.invokeEvent('scroll');
	}
};
