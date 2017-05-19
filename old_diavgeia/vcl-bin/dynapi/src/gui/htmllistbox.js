/*
	DynAPI Distribution
	HTMLListbox Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: HTMLComponent
*/

function HTMLListbox(css,items,length,multiSelect,title,elmName){
	this.HTMLComponent = HTMLComponent;
	this.HTMLComponent(css);
	
	this._elmId = elmName||(this.id+'LST');
	this._lIndex = 0; // last index
	this._opts = items||[];
	this._length = (length>2)? length:5;
	this._defEvtResponse = true;

	this.setMultiSelect(multiSelect);
};
var p = dynapi.setPrototype('HTMLListbox','HTMLComponent');
p._inlineEvents+=' onchange="return htc._e(\'change\',this,event);" ';
// Methods
p._oldHCLBEvt = HTMLComponent.prototype._e;
p._getDSValue = function(){ // DataSource functions
	return this.getSelected();
};
p._setDSValue = function(d){
	this.setSelected(d);
};
p._e = function(evt,elm,arg){
	if(evt=='change') this._selected = this._getSelValues();
	return this._oldHCLBEvt(evt,elm,arg);
};
p._assignElm = function(elm){
	if(!this.parent) return;
	else if(!this.parent._created) return;
	var doc=this.parent.doc;
	if(!elm) {
		if(dynapi.ua.ie) elm=doc.all[this._elmId];
		else if(dynapi.ua.dom) elm=doc.getElementById(this._elmId);
		else if(dynapi.ua.ns4){
			for(i=0;i<doc.forms.length;i++){
				elm=doc.forms[i][this._elmId];
				if(elm) break;
			}
		}
		if(!elm) return;
	}
	this.elm = elm;
	this.css = (dynapi.ua.ns4)? elm:elm.style;
	this.doc = this.parent.doc;
};
p._buildOptions  = function(){
	var h=[''],o=this._opts;
	var sel = '||'+this._selected+'||';
	for(var i in o){
		if(this._selected==i||(this._msel && this._selected[i])) s=' selected';else s='';
		if(o[i]!=null) h[h.length]='<option value="'+i+'"'+s+'>'+o[i]+'</option>';
	}
	return h.join('\n');
};
p._getSelValues = function(){
	if(!this.getElm()) return this._selected;
	else {	
		var sel;
		var opt = this.elm.options;
		var inx = opt.selectedIndex;
		if(inx<0) return;
		if(!this._msel) sel=opt[inx].value;
		else {
			sel = [];
			for(var i=0;i<opt.length;i++) if(opt[i].selected) sel[opt[i].value]=opt[i].value;
		}
		return sel;
	}
};
p.getInnerHTML = function(){
	var evt,multi = (this._msel)? ' multiple ':'';
	evt = this._generateInlineEvents(this);
	return '<select class="'+this._class+'" id="'+this._elmId+'" name="'+this._elmId+'" size="'+this._length+'"'
	+multi+evt+' title="'+this._title+'">'+this._buildOptions()+'</select>';
};
p.addItem = function(text,value,selected){
	if(value==null) value=this._lIndex;
	this._opts[value]=text;
	if(!this._msel && selected) this._selected=value;
	else if(this._msel && selected) this._selected+=value+'||';
	if(this.getElm()){
		var l=this.elm.options.length;
		this.elm.options[l]=new Option(text,value);
	}
	return this._lIndex++;
};
p.getItem = function(index){
	if(index!=null && this.getElm()) {
		var o = this.elm.options;
		if(typeof(index)=='number' && (index>=0 && index<o.length)) return {text:o[index].text,value:o[index].value};
		else {
			for(var i=0;i<o.length;i++) if(index==o[i].value) return {
				text:o[i].text,
				value:o[i].value
			}
		}
	}		
};
p.getSelected = function(){
	if(!this._msel) return this._getSelValues();
	else {
		var ar=[];
		var sel = this._selected = this._getSelValues();
		if(sel==null) return;
		for(var i in sel) ar[ar.length]=i;
		return ar;
	}
};
p.removeAllItems = function(){
	delete this._opts;
	this._opts = [];
	this._lIndex = 0;
	if(this.getElm()) this.elm.options.length = 0;
};
p.removeItem = function(index){
	if(!index) return;
	if(this.getElm()) {
		if(typeof(index)=='number') {
			var tmp=o[index].value;
			o[index]=null;
			index=tmp;
		}
		else{
			var o = this.elm.options;
			for(var i=0;i<o.length;i++){
				if(index==o[i].value) o[i]=null;
			}
		}
		this._opts[index]=null;
		delete this._opts[o[index]];
	}
};
p.setElementName = function(t){
	if(t) this._elmId = t;
};
p.setItems = function(o){
	for (var i in o) this.addItem(o[i],i);
};
p.setSelected = function(index){
	if(!index) return;
	if(!this._msel) this._selected = index;
	else this._selected[index]=index;
	if(this.getElm()) {
		var o=this.elm.options;
		if(typeof(index)=='number') o[index].selected = true;
		else for(var i=0;i<o.length;i++){
			if(index==o[i].value) o[i].selected=true; 
		}
	}
};
p.setMultiSelect = function(b){
	this._msel = (b)? true:false;
	if(this.getElm()) this.elm.multiple='multiple';
	if(this._msel) this._selected = [];
	else {
		delete this._selected;
		this._selected = null;
	}
};
// sort either by value or by text
p.sortBy = function(vt,desc){
	var v,dt,ar=[];
	var link = [];
	var o=this._opts;
	for(var i in o){
		v=i;
		if(vt=='text') v=o[i]; 
		ar[ar.length]=v;		
		link[v]=i; // store value;
	}
	ar.sort();
	if(desc && ar.reverse) ar.reverse();
	if(this.getElm()) this.elm.options.length=0;
	for(i=0;i<ar.length;i++){
		v=link[ar[i]];		
		if(o[v]) this.addItem(o[v],v);
	}
	
};