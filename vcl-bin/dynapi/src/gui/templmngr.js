/*
	DynAPI Distribution
	TemplateManager Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: DynLayer
*/

TemplateManager = {};
TemplateManager.isDynLayer = function(c){
	return (c.DynLayer||c._className=='DynLayer');
};
TemplateManager.isLayer = function(c) {
	var b = (c.DynLayer||c._className=='DynLayer'); // DynLayer
	b = (b||c.HTMLContainer||c._className=='HTMLContainer'); // HTMLContainer
	return b;
};


function Template(html,x,y,w,h,color,image){
	this.DynLayer = DynLayer;
	this.DynLayer(null,x,y,w,h,color,image);
	
	this._fields=[];
	this.setHTML(html);
};
var p = dynapi.setPrototype('Template','DynLayer');
p._TemplateSetHTML = DynLayer.prototype.setHTML;
p._insertField = function(fld,value){
	if(!this.html) return;
	var re = new RegExp('\\{@'+fld+'\\}',"g"); // global
	this.html = this.html.replace(re,value);
};
p._insertChild = function(c){
	if(!c._created) DynElement._flagPreCreate(c);
	var TM = TemplateManager;
	var html=c.getOuterHTML();
	if(!c._tmplFld) this.html+=html;
	else {
		var re = new RegExp('\\{@'+c._tmplFld+'\\}');
		// Mozilla will collapse/expand table cells whenever the content of the layer changes. To solve this, specify a width for your table cells
		if(TM.isLayer(c) && dynapi.ua.ns4) {
			// NS4 inline layers does not honor <td align="right">, they're always left align. To solve this a <table> must be used to wrap the ilayers. This will also ensure that <ilayers> behave like block elements in DOM
			html='<table cellpadding="0" cellspacing="0" border="0"><tr><td>'+html+'</td></tr></table>';
		}
		var bf = this.html; //before
		var af = this.html.replace(re,html); //after
		c.isInline = (bf!=af);
		this.html = af;
	}
};
p._parseFields = function(){  // retrieve hypertext component & container fields from template 
	// NOTE: This version of parseField does not support 
	// nested container fields - any ideas,solution to this?
	var i,f,ar,rxC,rxH;
	var t=this._template||'';
	var exists = t.match(/<htc:.*?\/>/)||t.match(/\{\@(\w+?)\:\[/);
	if(!exists) return;
	t=t.replace(/\r\n|\n/g,'§'); // convert to single line text
	if(dynapi.ua.ns4) {
		// ns4 does not support non-greedy matching
		rxC = /\{\@(\w+?)\:\[[^\[]*\]\}/g; 
		rxH = /\<htc\:[^:]*\/\>/g; 
	}
	else{
		rxC = /\{\@(\w+?)\:\[.*?\]\}/g; 
		rxH = /\<htc\:.*?\/\>/g; 		
	}
	ar = t.match(rxC); // get all container fields
	htc = t.match(rxH); // get all HyperTextComponent fields
	
	if(ar){
		// Container field
		for(i=0;i<ar.length;i++){
			f=ar[i];
			f=f.substr(2,f.length-4);
			f=f.split(':[');
			this._fields[f[0]]=f[1].replace(/§/g,'\n');
		}
	}
	if(htc) {
		// HyperText Component field - e.g. <htc:DynLayer(null,10,10,10,0,"Blue") @lyr1 />
		for(i=0;i<htc.length;i++){
			f=htc[i];
			f=f.substr(5,f.length-7);
			f=f.split('@');
			this.addChild(eval('new '+f[0]),f[1].replace(/\s/g,''));
		}
	}
	
	// replace container field with regular field
	if(dynapi.ua.ns4) t=t.replace(/\{\@(\w+?)\:\[[^\[]*\]\}/g,'{@$1}');
	else t=t.replace(/\{\@(\w+?)\:\[.*?\]\}/g,'{@$1}');
	
	// replace hyper-text component field with regular field	
	if(dynapi.ua.ns4) t=t.replace(/<htc:[^:]*@(\w+)[^\/]*\/>/g,'{@$1}');
	else t=t.replace(/<htc:.*?@(\w+).*?\/>/g,'{@$1}');
	
	// replace § with \n
	this._template = this.html = t.replace(/§/g,'\n');
};
p.addChild = function(c,fld){
	if (!c) return dynapi.debug.print("Error: No object sent to [Template].addChild()");
	if (c.isChild) c.removeFromParent();
	c.isChild = true;
	c.parent = this;
	if (c._saveAnchor) {
		c.setAnchor(c._saveAnchor);
		c._saveAnchor = null;
		delete c._saveAnchor;
	}
	c._alias = fld;	
	if(fld) {
		var oc=this[fld];
		if(oc && oc.removeFromParent) oc.removeFromParent(); // remove old child
		this[fld]=c;
		c.isInline=true;
		c._tmplFld=fld;
		c._noInlineValues=true;	
	}
	var TM = TemplateManager;
	if(TM.isDynLayer(c)) {
		if(c._tmplFld) c.setPosition('relative');
		// NS4 seems to create line breaks with inline layers that contains html
		if(dynapi.ua.ns4) c.enableBlackboard(); // this will force a <layer> arround the inline html
	}
	this.children[this.children.length] = c;
	return c;	
};
p.addField = function(fld,adjFld,content){
	if(!fld) return;
	var rx,nFld='{@'+fld+'}';
	if(content!=null) this._fields[fld] = content;
	if(!adjFld) this.html=this._template+=nFld;
	else {
		nFld = '{@'+adjFld+'}'+nFld;
		rx = new RegExp('\\{@'+adjFld+'\\}',"g"); // global
		this._template=this.html=this._template.replace(rx,nFld);
	}
};
p.clearTemplate = function(){
	delete this._fields;
	this.deleteAllChildren();
	this._fields = [];
	this._template = this.html = '';
	this._parseFields();
	this._TemplateSetHTML('&nbsp;');
};
p.cloneField = function(fld){
	if(!fld) return;
	var cFld='{@'+fld+'}';
	var ar=arguments;
	var vl=this._fields[fld];	
	var rx = new RegExp('\\{@'+fld+'\\}',"g"); // global
	for(var i=1;i<ar.length;i++) {
		this._fields[ar[i]]=vl;
		cFld+='{@'+ar[i]+'}';
	}
	this._template = this.html = this._template.replace(rx,cFld);		
};
// Template Object does not support enableBlackboard
p.enableBlackboard = dynapi.functions.Null;	
p.getInnerHTML=function() {	
	var s = '', fld = this._fields;
	var i,c,ch=this.children;
	// insert fields
	for(i in fld) this._insertField(i,fld[i]);
	// insert child layers/objects
	for (i=0;i<ch.length;i++) this._insertChild(ch[i]);	
	if (this.html!=null) {
		if(!dynapi.ua.ns4) s+=this.html;
		else {
			if (this.w==null) s += '<nobr>'+this.html+'</nobr>';
			else s+=this.html;
		}
	}
	// replaced unused fields
	if(this._defFld!=null) s=s.replace(/\{@(\w+?)\}/g,this._defFld);
	else s=s.replace(/\{@(\w+?)\}/g,'<!--$1-->');
	return s;
};
p.generate = function(){
	// generate and display the changes made to the template 
	if(!this._created) return;
	else {
		this.html=this._template; // reset html to last template
		var h=this.getInnerHTML();
		var i,c,ch=this.children;
		this.html = null;
		this._TemplateSetHTML(h);		
		for (i=0;i<ch.length;i++) {
			c=ch[i];
			c.elm=c.css=null;
			if(c.isClass('DynLayer')) DynLayer._assignElement(c);
			if(!c._created) DynElement._flagCreate(c);
		}
	}
};
p.setHTML = function(html){
	html=(html==null)? '': html+'';
	if(this._template!=html){
		this._template = this.html = html;
		this._parseFields();
		if(this._created) this.generate();
	}
};
p.getField = function(fld) {return this._fields[fld]};
p.setField = function(fld,value){
	this._fields[fld]=value;
};
p.setDefaultFieldValue = function(v){ 
	// changes the default value to be used in unused fields 
	// from <!--fieldname--> to value specified
	this._defFld=v;
};