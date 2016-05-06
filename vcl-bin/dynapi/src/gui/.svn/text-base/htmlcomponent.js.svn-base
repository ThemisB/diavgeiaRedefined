/*
	DynAPI Distribution
	HTMLComponent (HC) Class - See also quickref.htmlcomponent.html

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: DynElement
	
*/

function HTMLComponent(css){
	this.DynElement = DynElement;
	this.DynElement();
	this._class = css||'';
	this._defEvtResponse = false; // default event response type;
	this.HC = HTMLComponent; 
	this.FSO = null;
};
HTMLComponent.FSO = null;
HTMLComponent.pixel = dynapi.functions.getImage(dynapi.library.path+'gui/images/pixel.gif',1,1);
HTMLComponent._lyrSetLocation = function(x,y){
	if(dynapi.ua.ns4) {
		this.left=x;
		this.top=y;
	}
	else if(dynapi.ua.ie) {
		this.style.pixelLeft=x;
		this.style.pixelTop=y;
	}
	else {
		this.style.left=x+'px';
		this.style.top=y+'px';
	}
};
HTMLComponent._lyrSetVisible = function(b){
	if(this._visible!=b) {
		if(dynapi.ua.ns4) this.visibility = b? "inherit" : "hide";
		else this.style.visibility = b? "inherit" : "hidden";	
	}
};
HTMLComponent.buildLayer = function(id,attribs,html) {
	var t;
	if(dynapi.ua.ns4) t='\n<layer name="'+id+'" '+(attribs||'')+'>'+(html||'')+'</layer>';
	else t='<div id="'+id+'" '+(attribs||'')+'>'+(html||'')+'</div>'
	return t;
};
HTMLComponent.getLayerById = function(id,doc){
	var lyr;
	doc=doc||document;
	if(dynapi.ua.ie) lyr = doc.all[id];
	else if(dynapi.ua.dom) lyr = doc.getElementById(id);
	else if(dynapi.ua.ns4) {
		lyr=doc.layers[id];
		if(!lyr){
			var i,layers;
			layers = doc.layers;
			for (i=0;i<layers.length;i++){
				lyr=layers[i];
				if (lyr.id == id) break;
				else if (lyr.layers.length){
					lyr = this.getLayerById(id,lyr);
					if (lyr) break;
				}				
			}
		}
	}
	if(lyr && !lyr.setLocation) lyr.setLocation = this._lyrSetLocation;	
	if(lyr && !lyr.setVisible) lyr.setVisible = this._lyrSetVisible;	
	return lyr;
};
HTMLComponent.writeStyle = dynapi.document.writeStyle;
HTMLComponent.setFlashSound = function(fs){		
	this.FSO = fs; // sets FSO for all HCs
};
var p = dynapi.setPrototype('HTMLComponent','DynElement');
// Design Properties
p.backCol = '#FFFFFF';
p.foreCol = '#000000';
p.sndOnClick = '';		// FSO format: target@frame
p.sndOnMouseover = ''; 	// example: /click@start
p.sndOnMouseout = ''; 	// where /click is targeted instance
p.sndOnChange = '';		// and start is the name of the label or frame
p.sndOnKeypress = '';
// Methods
p._assignElm =  p._create = p._destroyAllChildren = p.getInnerHTML = dynapi.functions.Null;
p._remove = function(){
	var p=this.parent;
	if (p && this._alias) p[this._alias]=null;	
	this.elm=null;
};
p._destroy = function(){
	this._remove();
	this.parent = this.css = this.doc = null;
	DynObject.all[this.id] = null;	
};
p._createInserted = function(){
	this._assignElm();
	DynElement._flagCreate(this);
};
p._inlineEvents = ' onclick="return htc._e(\'click\',this,event);" '
+' onmouseover="return htc._e(\'mouseover\',this,event);" '
+' onmousedown="return htc._e(\'mousedown\',this,event);" '
+' onmouseout="return htc._e(\'mouseout\',this,event);" '
+' onfocus="return htc._e(\'focus\',this,event);" '
+' onblur="return htc._e(\'blur\',this,event);" ';
p._generateInlineEvents = function(htc){
	return this._inlineEvents.replace(/htc/g,htc.toString());
};
// event handler
p._e = function(evt,elm,args){
	this._evtResponse  = this._defEvtResponse;
	if(elm && !this.elm) this._assignElm(elm);
	this._ePlaySnd(evt); // plays a sound
	this.invokeEvent(evt,null,args);
	return this._evtResponse;
};
// sound event handler
p._ePlaySnd = function(evt){
	var snd = (evt+'');
	snd='sndOn'+(snd.substr(0,1).toUpperCase()+snd.substr(1));
	if(this[snd]) this.playSound(this[snd]);
};
p.allowEvent = function(){ this._evtResponse = true;};
p.cancelEvent = function(){ this._evtResponse = false;};
p.getOuterHTML = function() {
	return this.getInnerHTML();
};
p.getElm = function(){
	if(!this.e) this._assignElm();
	return this.elm;
};
p.getCss = function(){
	if(!this.css) this._assignElm();
	return this.css;
};
p.playSound = function(t){
	if(!t) return;
	var fs = this.FSO||this.HC.FSO;
	t = t.split('@'); // separate target and frame
	if(fs) fs.gotoAndPlay(t[0],t[1]);
};
p.setFlashSound = HTMLComponent.setFlashSound; // sets FSO only for this HC


// HTML Cell - usage: var t = HTMLCell()
HTMLCell = function(css,id,text,w,h,evt,backCol,padding,absolute,cssText){
	var tag,str='';
	id =(id||'');
	cssText = (cssText||'');
	text = (text||'');
	// In IE4 width must be a miniumum of 3 pixels.
	if (dynapi.ua.def) {
		str += '<div id="' + id + '" style="left:0px; top:0px; position: '+(absolute? 'absolute':'relative')+'; width: ' + w + '; height: ' + h + '; visibility: inherit; ';
		if (backCol) str += 'background: ' + backCol + '; ';
		str += '" ';
	}else if (dynapi.ua.ns4) {
		tag = (absolute)? 'layer':'ilayer';
		str += '<'+tag+(absolute? ' left="0" top="0" ':' clip="0 0 0,0" onload="this.clip.width=this.document.width;this.clip.height=this.document.height-19;"')+' id="' + id + '" width="' +  w + '" height="' + h + '" visibility="inherit" ';
		if (backCol) str += 'bgcolor="' + backCol + '" ';
	}
	if (css) str += 'class="' + css + '" ';	
	if(evt) str += evt; // Add mouse event handlers.
	str+='>';
	
	// In IE/NS6+, add padding if there's a border to emulate NS4's layer padding.
	str += '<table width="' + (w - 8) + '" border="0" cellspacing="0" cellpadding="' + ((!dynapi.ua.ns4 && css)? padding : 0) + '"><tr>'
	+'<td class="' + cssText + '" align="left" height="' + (h - 7) + '">' + text +'</td>'
	+'</tr></table>' + (dynapi.ua.ns4 ? '</'+tag+'>' : '</div>');
	return str;
};

// HTML Text - usage: var t = HTMLText()
HTMLText = function(css,text,color,family,size,bold,italics,underline){
	var t = (text||'');
	if(css) return '<span class="'+css+'">'+t+'</span>';
	else {
		var fs =(size==null)? '':' size="'+size+'" ';
		var ff =(family==null)? '':' name="'+family+'" ';
		var fc =(color==null)? '':' color="'+color+'" ';
		if(bold) t='<b>'+t+'</b>';
		if(italics) t='<i>'+t+'</i>';
		if(underline) t='<u>'+t+'</u>';
		return '<font'+ff+fs+fc+'>'+t+'</font>';		
	}
};