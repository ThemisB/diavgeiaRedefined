/*
	DynAPI Distribution
	HTMLDatePicker Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: HTMLComponent
*/

function HTMLDatePicker(css,date,title,elmName){
	this.HTMLComponent = HTMLComponent;
	this.HTMLComponent(css);
	
	this._elmId = elmName||(this.id+'DP');
	this._title = title||'';
	this._defEvtResponse = true;
	
	this.setDate(date);
};
var p = dynapi.setPrototype('HTMLDatePicker','HTMLComponent');
p._inlineEvents+=' onchange="return htc._e(\'change\',this,event);" ';
// Methods
p._oldHCDPEvt = HTMLComponent.prototype._e;
p._getDSValue = function(){return this._date}; // DataSource functions
p._setDSValue = function(d){this.setDate(d)};
p._e = function(evt,elm,arg){
	if(evt=='change') {
		var odt = this._date;
		var dt,f=elm.form;
		var d=this._elmD=this._elmD||f[this._elmId+'D'];
		var m=this._elmM=this._elmM||f[this._elmId+'M'];
		var y=this._elmY=this._elmY||f[this._elmId+'Y'];
		var id=d.options[d.selectedIndex].value;
		var im=m.options[m.selectedIndex].value-1;
		var iy=y.options[y.selectedIndex].value;
		var dim = this._getDIM(im,iy); // get days in month
		if(id>dim) id=dim;
		dt = new Date(iy,im,id);
		if(isNaN(dt)) dt = new Date();
		this._date=dt;
		//reload days & years
		this._buildOptions('days',d);
		if(iy!=odt.getFullYear())this._buildOptions('years',y);
		elm = f[this._elmdId];
	};
	return this._oldHCDPEvt(evt,elm,arg);
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
p.getInnerHTML = function(){
	var dtn,evt,text=this._text||'';
	var readstate = (this._readonly)? ' readonly ':'';
	evt = this._generateInlineEvents(this);	
	if(!this._date) dt ='';
	else {
		var dt = this._date;
		dtn = dt.getMonth() +'/'+ dt.getDay() +'/'+ dt.getYear();		
	}
	return '<input type="hidden" id="'+this._elmId+'" name="'+this._elmId+'" value="'+dtn+'">'
	+'<select id="'+this._elmId+'D" name="'+this._elmId+'D" class="'+this._class+'" '+evt+' title="'+this._title+'">'+this._buildOptions('days')+'</select>'
	+'<select id="'+this._elmId+'M" name="'+this._elmId+'M" class="'+this._class+'" '+evt+' title="'+this._title+'">'+this._buildOptions('months')+'</select>'
	+'<select id="'+this._elmId+'Y" name="'+this._elmId+'Y" class="'+this._class+'" '+evt+' title="'+this._title+'">'+this._buildOptions('years')+'</select>';
};
p._buildOptions  = function(ct,elm){
	var dt = this._date;
	var s,h=[''];	
	var d = dt.getDate();
	var m = dt.getMonth();
	var y = dt.getFullYear();
	var months = ['Jan','Feb','Mar','Apr','May','June','Jul','Aug','Sep','Oct','Nov','Dec'];
	var lo=0,hi=0;
	if(ct=='days') {
		sel=d; lo=1; hi=this._getDIM(m,y);
	}
	else if(ct=='months') {
		sel=m+1; lo=1; hi=12;
	}
	else if(ct=='years') {
		sel=y; lo=sel-50; hi=sel+50;
	}
	if(elm) elm.options.length=0;
	for(var i=lo;i<=hi;i++){
		v=(ct=='months')? months[i-1]:i;
		if(sel==i) s=' selected';else s='';
		if(!elm) h[h.length]='<option value="'+i+'"'+s+'>'+v+'</option>';
		else {
			o = elm.options[elm.options.length] = new Option(i,v);		
			if(s) o.selected=true;
		}
	}
	return h.join('\n');
};
// Get Days In Month
p._getDIM = function(m,yr){
	var d=31;
	if(m==1) d=((yr/4)==Math.floor(yr/4))? 29:28;
	else if(m==3||m==5||m==8||m==10) d=30;
	return d;
};
p.getDate = function() { return this._date;};
p.setDate = function(dt){
	dt = new Date(dt);
	this._date = (!isNaN(dt))? dt:new Date();
};
p.setElementName = function(t){
	if(t) this._elmId = t;
};
