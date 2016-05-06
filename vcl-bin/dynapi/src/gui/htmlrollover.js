/*
	DynAPI Distribution
	HTMLRollover Class - a wrapper around XImage and HTMLHyperLink

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: HTMLHyperLink
*/


function HTMLRollover(css,w,h,offSrc,onSrc,dnSrc,url,title){
	this.HTMLHyperLink = HTMLHyperLink;
	this.HTMLHyperLink(css,null,url,title);	

	this._imgid=this.id+'HRO';
	this._img =  dynapi.functions.getImage(offSrc,w,h,{
		name	:this._imgid,
		link	:url,
		oversrc	:onSrc,
		downsrc	:dnSrc,
		tooltip	:title,
		onclick		:this+"._e('click',anc);",
		onmouseout	:this+"._e('mouseout',anc)",
		onmouseover	:this+"._e('mouseover',anc)",
		onmousedown	:this+"._e('mousedown',anc)"
	});
	
};
var p = dynapi.setPrototype('HTMLRollover','HTMLHyperLink');
// Methods
p.getInnerHTML = function(){
	var h=this._img.getHTML();
	// attach id,name and class to <a>
	h=h.replace(/\<a/,'<a id="'+this.id+'" name="'+this.id+'" class="'+this._class+'"');
	return h;
};
p.setBorder = function(w) {
	w=w||0;
	this._img.params.border=w;
	if(this.getElm()) {
		img=this.doc.images[this._imgid];
		if(img) img.border=w;
	}
};
p.setSrc = function(src){
	if(this.getElm()) {
		img=this.doc.images[this._imgid];
		if(img) img.src=src;
	}
};