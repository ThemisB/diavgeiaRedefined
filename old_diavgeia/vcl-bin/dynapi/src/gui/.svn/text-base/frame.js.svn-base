/*
	DynAPI Distribution
	BorderManager Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

	requires: Highlighter
*/

/* Outer Border uses Frame class with image support.
	by:
	  Kevin Gargan (kevin[at]kegcl.demon.co.uk)
	useage:
	  f=new Frame([widths],[sidecolors||sideimages],[cornerimages])
	and
	  f.setBorder([widths],[sidecolors||sideimages],[cornerimages])
	where
	  Parameter widths, sidecolors, sideimages and cornerimages may be scalar
	  or array defining top, right, bottom and left (defaulting like css). In
	  addition the corner images are defined as from top right, bottom right,
	  bottom left and top left.
	e.g.
	  1,'white'
	  10,'tile.gif'
	  [1,2,3,4],['red','green','blue','yellow']
	  10,['t.gif','r.gif']
	  10,['t.gif','r.gif','b.gif','l.gif'],['tr.gif','br.gif','bl.gif','tl.gif']
*/
function Frame(widths,sideimgs,cornerimgs) {
  this.DynLayer = DynLayer;
  this.DynLayer();
  
  this.setDefaults(widths,sideimgs,cornerimgs);
  this.addChild(new Skin('n',this.sides[0]),'_fN');
  this.addChild(new Skin('e',this.sides[1]),'_fE');
  this.addChild(new Skin('s',this.sides[2]),'_fS');
  this.addChild(new Skin('w',this.sides[3]),'_fW');
  if(cornerimgs) {
    this.addChild(new Skin('ne',this.corners[0]),'_fNE');
    this.addChild(new Skin('se',this.corners[1]),'_fSE');
    this.addChild(new Skin('sw',this.corners[2]),'_fSW');
    this.addChild(new Skin('nw',this.corners[3]),'_fNW');
  }
}
Frame._defaults=function(arry,def) {
  var i=(arry==null)?[def]:(typeof(arry)!='object')?[arry]:arry, out=[];
  out[0]=i[0];
  out[1]=(i[1]!=null)?i[1]:out[0];
  out[2]=(i[2]!=null)?i[2]:out[0];
  out[3]=(i[3]!=null)?i[3]:out[1];
  return out;
};
Frame._defaultCorners=function(haveCorners,ws,cimgs) {
  var corners=[];
  corners[0]=[haveCorners?ws[1]:0,haveCorners?ws[0]:0,null,null,null,cimgs[0]];
  corners[1]=[haveCorners?ws[1]:0,haveCorners?ws[2]:0,null,null,null,cimgs[1]];
  corners[2]=[haveCorners?ws[3]:0,haveCorners?ws[2]:0,null,null,null,cimgs[2]];
  corners[3]=[haveCorners?ws[3]:0,haveCorners?ws[0]:0,null,null,null,cimgs[3]];
  return corners;
};
Frame._defaultSides=function(ws,cs,simgs) {
  var sides=[];
  var isCol=(simgs[0].indexOf('.')<0); // Color or image.gif file.
  sides[0]=[null,ws[0],ws[1],cs[3][0],isCol?simgs[0]:null,isCol?null:simgs[0]];
  sides[1]=[ws[1],null,cs[0][1],ws[2],isCol?simgs[1]:null,isCol?null:simgs[1]];
  sides[2]=[null,ws[2],cs[1][0],ws[3],isCol?simgs[2]:null,isCol?null:simgs[2]];
  sides[3]=[ws[3],null,ws[0],cs[2][1],isCol?simgs[3]:null,isCol?null:simgs[3]];
  return sides;
};
var p = dynapi.setPrototype('Frame','DynLayer');
p.setDefaults=function(widths,sideimgs,cornerimgs) {
  this.widths=Frame._defaults(widths,0);
  this.sideimgs=Frame._defaults(sideimgs,'black');
  this.cornerimgs=Frame._defaults(cornerimgs,null);
  this.corners=Frame._defaultCorners(cornerimgs,this.widths,this.cornerimgs);
  this.sides=Frame._defaultSides(this.widths,this.corners,this.sideimgs);
};
p.setBorder=function(widths,sideimgs,cornerimgs) {
  var wso=this.widths; // Widths old.
  var eo=wso[1], wo=wso[3], no=wso[0], so=wso[2];
  this.setDefaults(widths,sideimgs,cornerimgs);
  this._fN.graft(this.sides[0]);
  this._fE.graft(this.sides[1]);
  this._fS.graft(this.sides[2]);
  this._fW.graft(this.sides[3]);
  if(cornerimgs) {
    if(this._fNE==null) this.addChild(new Skin('ne',this.corners[0]),'_fNE');
    else this._fNE.graft(this.corners[0]);
    if(this._fSE==null) this.addChild(new Skin('se',this.corners[1]),'_fSE');
    else this._fSE.graft(this.corners[1]);
    if(this._fSW==null) this.addChild(new Skin('sw',this.corners[2]),'_fSW');
    else this._fSW.graft(this.corners[2]);
    if(this._fNW==null) this.addChild(new Skin('nw',this.corners[3]),'_fNW');
    else this._fNW.graft(this.corners[3]);
  }
  else {
    if(this._fNE) this._fNE.graft(this.corners[0]);
    if(this._fSE) this._fSE.graft(this.corners[1]);
    if(this._fSW) this._fSW.graft(this.corners[2]);
    if(this._fNW) this._fNW.graft(this.corners[3]);
  }
  var ws=this.widths; // Widths new.
  var de=ws[1]-eo, dw=ws[3]-wo, dn=ws[0]-no, ds=ws[2]-so; // Deltas.
  this.setSize(this.w+de+dw,this.h+dn+ds);
  var left=Math.ceil((ws[3]-ws[1])/2), top=Math.ceil((ws[0]-ws[2])/2);
  this._fC.setAnchor({centerH:left,centerV:top});
};
p.addContent=function(c) {
  if(c._fP) return;
  else c._fP=this;
  this.setLocation(c.x,c.y);
  var ws=this.widths;
  this.setSize(c.w+ws[1]+ws[3],c.h+ws[0]+ws[2]);
  var left=Math.ceil((ws[3]-ws[1])/2), top=Math.ceil((ws[0]-ws[2])/2);
  c.setAnchor({centerH:left,centerV:top});
  return this.addChild(c,'_fC');
};

// Square Picture Frame
function SquarePictureFrame(widths,sideimgs,cornerimgs,image,w,h,color) {
  this.Frame=Frame;
  this.Frame(widths,sideimgs,cornerimgs);
  
  if(color) this.setBgColor(color);
  this.addContent(new DynLayer(image.getHTML(),null,null,w,h));
  var longest=(w>h)?w:h, ws=this.widths;
  this.setSize(longest+ws[1]+ws[3],longest+ws[0]+ws[2]);
};
p = dynapi.setPrototype('SquarePictureFrame','Frame');
