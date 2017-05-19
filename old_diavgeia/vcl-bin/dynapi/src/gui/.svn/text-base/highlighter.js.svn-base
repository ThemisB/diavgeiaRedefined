/*
	DynAPI Distribution
	Higlighter/Skin Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

	requires: DynLayer
*/

// Highlighter
function Highlighter(x,y,w,h,color,image){
	this.DynLayer=DynLayer;
	if(x && x.constructor==Object) this.DynLayer(x);	 // use dictionary
	else this.DynLayer(null,x||0,y||0,w||0,h||0,color,image);	
};
var p = dynapi.setPrototype('Highlighter','DynLayer');
p.addChild=dynapi.functions.Null;
if (!dynapi.ua.ns4){
	p._hLight= [
		'\n<div id="',1,'" style="left:',3 ,'px; top:',5,'px; width:',7,
		'px; height:',9,'px; background-color:',11,
		'; z-index:10000; visibility:inherit; background-image:',13,'; position:absolute;font-size:0px;"><!--IE?--></div>'
	]; // some versions of IE (e.g. 6.0) will not set the correct height if the layer hight is smaller than the font height. To fix this I added <!--IE?--> to the div
}
else{
	p._hLight= [
		'\n<layer id="',1,'" left="',3 ,'" top="',5,'" width="',7,
		'" height="',9,'" zIndex="10000" bgcolor="',11,'" background="',13,'"></layer>'
	];
};
p.getOuterHTML = function(){
	var a=this._hLight;
	a[1]=this.id;
	a[3]=this.x;
	a[5]=this.y;
	a[7]=this.w;
	a[9]=this.h;
	a[11]=this.bgColor||this.parent.bgColor||'none';
	a[13]=(this.bgImage==null)? 'none':'url('+this.bgImage+')'; // will prevent image reloading in IE
	return a.join('');	
};
p.getInnerHTML = function(){
	return '<!--IE?-->';
};

// Skin
function Skin(p,a) {
  this.base=Highlighter;
  var w=a[0], h=a[1], d1=a[2], d2=a[3], c=a[4], i=a[5]; this.point=p;
  if(p=='n') this.base({h:h,color:c,image:i,anchor:{top:0,right:d1,left:d2}});
  if(p=='ne') this.base({w:w,h:h,color:c,image:i,anchor:{top:0,right:0}});
  if(p=='e') this.base({w:w,color:c,image:i,anchor:{top:d1,right:0,bottom:d2}});
  if(p=='se') this.base({w:w,h:h,color:c,image:i,anchor:{right:0,bottom:0}});
  if(p=='s') this.base({h:h,color:c,image:i,anchor:{right:d1,bottom:0,left:d2}});
  if(p=='sw') this.base({w:w,h:h,color:c,image:i,anchor:{bottom:0,left:0}});
  if(p=='w') this.base({w:w,color:c,image:i,anchor:{top:d1,bottom:d2,left:0}});
  if(p=='nw') this.base({w:w,h:h,color:c,image:i,anchor:{top:0,left:0}});
};
Skin.prototype=new Highlighter();
Skin.prototype.graft=function(a) {
  var w=a[0], h=a[1], d1=a[2], d2=a[3], c=a[4], i=a[5], p=this.point;
  this.setSize(w,h); this.setBgColor(c); this.setBgImage(i);
  if(p=='n') this.setAnchor({top:0,right:d1,left:d2});
  if(p=='e') this.setAnchor({top:d1,right:0,bottom:d2});
  if(p=='s') this.setAnchor({right:d1,bottom:0,left:d2});
  if(p=='w') this.setAnchor({top:d1,bottom:d2,left:0});
};
