/* This compressed file is part of Xinha. For uncompressed sources, forum, and bug reports, go to xinha.org */
/* This file is part of version 0.95 released Mon, 12 May 2008 17:33:15 +0200 */
/* The URL of the most recent version of this file is http://svn.xinha.webfactional.com/trunk/plugins/ExtendedFileManager/assets/wz_jsgraphics.js */
var jg_ok,jg_ie,jg_fast,jg_dom,jg_moz;
function _chkDHTM(x,i){
x=document.body||null;
jg_ie=x&&typeof x.insertAdjacentHTML!="undefined"&&document.createElement;
jg_dom=(x&&!jg_ie&&typeof x.appendChild!="undefined"&&typeof document.createRange!="undefined"&&typeof (i=document.createRange()).setStartBefore!="undefined"&&typeof i.createContextualFragment!="undefined");
jg_fast=jg_ie&&document.all&&!window.opera;
jg_moz=jg_dom&&typeof x.style.MozOpacity!="undefined";
jg_ok=!!(jg_ie||jg_dom);
}
function _pntCnvDom(){
var x=this.wnd.document.createRange();
x.setStartBefore(this.cnv);
x=x.createContextualFragment(jg_fast?this._htmRpc():this.htm);
if(this.cnv){
this.cnv.appendChild(x);
}
this.htm="";
}
function _pntCnvIe(){
if(this.cnv){
this.cnv.insertAdjacentHTML("BeforeEnd",jg_fast?this._htmRpc():this.htm);
}
this.htm="";
}
function _pntDoc(){
this.wnd.document.write(jg_fast?this._htmRpc():this.htm);
this.htm="";
}
function _pntN(){
}
function _mkDiv(x,y,w,h){
this.htm+="<div style=\"position:absolute;"+"left:"+x+"px;"+"top:"+y+"px;"+"width:"+w+"px;"+"height:"+h+"px;"+"clip:rect(0,"+w+"px,"+h+"px,0);"+"background-color:"+this.color+(!jg_moz?";overflow:hidden":"")+";\"></div>";
}
function _mkDivIe(x,y,w,h){
this.htm+="%%"+this.color+";"+x+";"+y+";"+w+";"+h+";";
}
function _mkDivPrt(x,y,w,h){
this.htm+="<div style=\"position:absolute;"+"border-left:"+w+"px solid "+this.color+";"+"left:"+x+"px;"+"top:"+y+"px;"+"width:0px;"+"height:"+h+"px;"+"clip:rect(0,"+w+"px,"+h+"px,0);"+"background-color:"+this.color+(!jg_moz?";overflow:hidden":"")+";\"></div>";
}
var _regex=/%%([^;]+);([^;]+);([^;]+);([^;]+);([^;]+);/g;
function _htmRpc(){
return this.htm.replace(_regex,"<div style=\"overflow:hidden;position:absolute;background-color:"+"$1;left:$2;top:$3;width:$4;height:$5\"></div>\n");
}
function _htmPrtRpc(){
return this.htm.replace(_regex,"<div style=\"overflow:hidden;position:absolute;background-color:"+"$1;left:$2;top:$3;width:$4;height:$5;border-left:$4px solid $1\"></div>\n");
}
function _mkLin(x1,y1,x2,y2){
if(x1>x2){
var _x2=x2;
var _y2=y2;
x2=x1;
y2=y1;
x1=_x2;
y1=_y2;
}
var dx=x2-x1,dy=Math.abs(y2-y1),x=x1,y=y1,yIncr=(y1>y2)?-1:1;
if(dx>=dy){
var pr=dy<<1,pru=pr-(dx<<1),p=pr-dx,ox=x;
while(dx>0){
--dx;
++x;
if(p>0){
this._mkDiv(ox,y,x-ox,1);
y+=yIncr;
p+=pru;
ox=x;
}else{
p+=pr;
}
}
this._mkDiv(ox,y,x2-ox+1,1);
}else{
var pr=dx<<1,pru=pr-(dy<<1),p=pr-dy,oy=y;
if(y2<=y1){
while(dy>0){
--dy;
if(p>0){
this._mkDiv(x++,y,1,oy-y+1);
y+=yIncr;
p+=pru;
oy=y;
}else{
y+=yIncr;
p+=pr;
}
}
this._mkDiv(x2,y2,1,oy-y2+1);
}else{
while(dy>0){
--dy;
y+=yIncr;
if(p>0){
this._mkDiv(x++,oy,1,y-oy);
p+=pru;
oy=y;
}else{
p+=pr;
}
}
this._mkDiv(x2,oy,1,y2-oy+1);
}
}
}
function _mkLin2D(x1,y1,x2,y2){
if(x1>x2){
var _x2=x2;
var _y2=y2;
x2=x1;
y2=y1;
x1=_x2;
y1=_y2;
}
var dx=x2-x1,dy=Math.abs(y2-y1),x=x1,y=y1,yIncr=(y1>y2)?-1:1;
var s=this.stroke;
if(dx>=dy){
if(dx>0&&s-3>0){
var _s=(s*dx*Math.sqrt(1+dy*dy/(dx*dx))-dx-(s>>1)*dy)/dx;
_s=(!(s-4)?Math.ceil(_s):Math.round(_s))+1;
}else{
var _s=s;
}
var ad=Math.ceil(s/2);
var pr=dy<<1,pru=pr-(dx<<1),p=pr-dx,ox=x;
while(dx>0){
--dx;
++x;
if(p>0){
this._mkDiv(ox,y,x-ox+ad,_s);
y+=yIncr;
p+=pru;
ox=x;
}else{
p+=pr;
}
}
this._mkDiv(ox,y,x2-ox+ad+1,_s);
}else{
if(s-3>0){
var _s=(s*dy*Math.sqrt(1+dx*dx/(dy*dy))-(s>>1)*dx-dy)/dy;
_s=(!(s-4)?Math.ceil(_s):Math.round(_s))+1;
}else{
var _s=s;
}
var ad=Math.round(s/2);
var pr=dx<<1,pru=pr-(dy<<1),p=pr-dy,oy=y;
if(y2<=y1){
++ad;
while(dy>0){
--dy;
if(p>0){
this._mkDiv(x++,y,_s,oy-y+ad);
y+=yIncr;
p+=pru;
oy=y;
}else{
y+=yIncr;
p+=pr;
}
}
this._mkDiv(x2,y2,_s,oy-y2+ad);
}else{
while(dy>0){
--dy;
y+=yIncr;
if(p>0){
this._mkDiv(x++,oy,_s,y-oy+ad);
p+=pru;
oy=y;
}else{
p+=pr;
}
}
this._mkDiv(x2,oy,_s,y2-oy+ad+1);
}
}
}
function _mkLinDott(x1,y1,x2,y2){
if(x1>x2){
var _x2=x2;
var _y2=y2;
x2=x1;
y2=y1;
x1=_x2;
y1=_y2;
}
var dx=x2-x1,dy=Math.abs(y2-y1),x=x1,y=y1,yIncr=(y1>y2)?-1:1,drw=true;
if(dx>=dy){
var pr=dy<<1,pru=pr-(dx<<1),p=pr-dx;
while(dx>0){
--dx;
if(drw){
this._mkDiv(x,y,1,1);
}
drw=!drw;
if(p>0){
y+=yIncr;
p+=pru;
}else{
p+=pr;
}
++x;
}
}else{
var pr=dx<<1,pru=pr-(dy<<1),p=pr-dy;
while(dy>0){
--dy;
if(drw){
this._mkDiv(x,y,1,1);
}
drw=!drw;
y+=yIncr;
if(p>0){
++x;
p+=pru;
}else{
p+=pr;
}
}
}
if(drw){
this._mkDiv(x,y,1,1);
}
}
function _mkOv(_2b,top,_2d,_2e){
var a=(++_2d)>>1,b=(++_2e)>>1,wod=_2d&1,hod=_2e&1,cx=_2b+a,cy=top+b,x=0,y=b,ox=0,oy=b,aa2=(a*a)<<1,aa4=aa2<<1,bb2=(b*b)<<1,bb4=bb2<<1,st=(aa2>>1)*(1-(b<<1))+bb2,tt=(bb2>>1)-aa2*((b<<1)-1),w,h;
while(y>0){
if(st<0){
st+=bb2*((x<<1)+3);
tt+=bb4*(++x);
}else{
if(tt<0){
st+=bb2*((x<<1)+3)-aa4*(y-1);
tt+=bb4*(++x)-aa2*(((y--)<<1)-3);
w=x-ox;
h=oy-y;
if((w&2)&&(h&2)){
this._mkOvQds(cx,cy,x-2,y+2,1,1,wod,hod);
this._mkOvQds(cx,cy,x-1,y+1,1,1,wod,hod);
}else{
this._mkOvQds(cx,cy,x-1,oy,w,h,wod,hod);
}
ox=x;
oy=y;
}else{
tt-=aa2*((y<<1)-3);
st-=aa4*(--y);
}
}
}
w=a-ox+1;
h=(oy<<1)+hod;
y=cy-oy;
this._mkDiv(cx-a,y,w,h);
this._mkDiv(cx+ox+wod-1,y,w,h);
}
function _mkOv2D(_30,top,_32,_33){
var s=this.stroke;
_32+=s+1;
_33+=s+1;
var a=_32>>1,b=_33>>1,wod=_32&1,hod=_33&1,cx=_30+a,cy=top+b,x=0,y=b,aa2=(a*a)<<1,aa4=aa2<<1,bb2=(b*b)<<1,bb4=bb2<<1,st=(aa2>>1)*(1-(b<<1))+bb2,tt=(bb2>>1)-aa2*((b<<1)-1);
if(s-4<0&&(!(s-2)||_32-51>0&&_33-51>0)){
var ox=0,oy=b,w,h,pxw;
while(y>0){
if(st<0){
st+=bb2*((x<<1)+3);
tt+=bb4*(++x);
}else{
if(tt<0){
st+=bb2*((x<<1)+3)-aa4*(y-1);
tt+=bb4*(++x)-aa2*(((y--)<<1)-3);
w=x-ox;
h=oy-y;
if(w-1){
pxw=w+1+(s&1);
h=s;
}else{
if(h-1){
pxw=s;
h+=1+(s&1);
}else{
pxw=h=s;
}
}
this._mkOvQds(cx,cy,x-1,oy,pxw,h,wod,hod);
ox=x;
oy=y;
}else{
tt-=aa2*((y<<1)-3);
st-=aa4*(--y);
}
}
}
this._mkDiv(cx-a,cy-oy,s,(oy<<1)+hod);
this._mkDiv(cx+a+wod-s,cy-oy,s,(oy<<1)+hod);
}else{
var _a=(_32-(s<<1))>>1,_b=(_33-(s<<1))>>1,_x=0,_y=_b,_aa2=(_a*_a)<<1,_aa4=_aa2<<1,_bb2=(_b*_b)<<1,_bb4=_bb2<<1,_st=(_aa2>>1)*(1-(_b<<1))+_bb2,_tt=(_bb2>>1)-_aa2*((_b<<1)-1),pxl=new Array(),pxt=new Array(),_pxb=new Array();
pxl[0]=0;
pxt[0]=b;
_pxb[0]=_b-1;
while(y>0){
if(st<0){
pxl[pxl.length]=x;
pxt[pxt.length]=y;
st+=bb2*((x<<1)+3);
tt+=bb4*(++x);
}else{
if(tt<0){
pxl[pxl.length]=x;
st+=bb2*((x<<1)+3)-aa4*(y-1);
tt+=bb4*(++x)-aa2*(((y--)<<1)-3);
pxt[pxt.length]=y;
}else{
tt-=aa2*((y<<1)-3);
st-=aa4*(--y);
}
}
if(_y>0){
if(_st<0){
_st+=_bb2*((_x<<1)+3);
_tt+=_bb4*(++_x);
_pxb[_pxb.length]=_y-1;
}else{
if(_tt<0){
_st+=_bb2*((_x<<1)+3)-_aa4*(_y-1);
_tt+=_bb4*(++_x)-_aa2*(((_y--)<<1)-3);
_pxb[_pxb.length]=_y-1;
}else{
_tt-=_aa2*((_y<<1)-3);
_st-=_aa4*(--_y);
_pxb[_pxb.length-1]--;
}
}
}
}
var ox=-wod,oy=b,_oy=_pxb[0],l=pxl.length,w,h;
for(var i=0;i<l;i++){
if(typeof _pxb[i]!="undefined"){
if(_pxb[i]<_oy||pxt[i]<oy){
x=pxl[i];
this._mkOvQds(cx,cy,x,oy,x-ox,oy-_oy,wod,hod);
ox=x;
oy=pxt[i];
_oy=_pxb[i];
}
}else{
x=pxl[i];
this._mkDiv(cx-x,cy-oy,1,(oy<<1)+hod);
this._mkDiv(cx+ox+wod,cy-oy,1,(oy<<1)+hod);
ox=x;
oy=pxt[i];
}
}
this._mkDiv(cx-a,cy-oy,1,(oy<<1)+hod);
this._mkDiv(cx+ox+wod,cy-oy,1,(oy<<1)+hod);
}
}
function _mkOvDott(_39,top,_3b,_3c){
var a=(++_3b)>>1,b=(++_3c)>>1,wod=_3b&1,hod=_3c&1,hodu=hod^1,cx=_39+a,cy=top+b,x=0,y=b,aa2=(a*a)<<1,aa4=aa2<<1,bb2=(b*b)<<1,bb4=bb2<<1,st=(aa2>>1)*(1-(b<<1))+bb2,tt=(bb2>>1)-aa2*((b<<1)-1),drw=true;
while(y>0){
if(st<0){
st+=bb2*((x<<1)+3);
tt+=bb4*(++x);
}else{
if(tt<0){
st+=bb2*((x<<1)+3)-aa4*(y-1);
tt+=bb4*(++x)-aa2*(((y--)<<1)-3);
}else{
tt-=aa2*((y<<1)-3);
st-=aa4*(--y);
}
}
if(drw&&y>=hodu){
this._mkOvQds(cx,cy,x,y,1,1,wod,hod);
}
drw=!drw;
}
}
function _mkRect(x,y,w,h){
var s=this.stroke;
this._mkDiv(x,y,w,s);
this._mkDiv(x+w,y,s,h);
this._mkDiv(x,y+h,w+s,s);
this._mkDiv(x,y+s,s,h-s);
}
function _mkRectDott(x,y,w,h){
this.drawLine(x,y,x+w,y);
this.drawLine(x+w,y,x+w,y+h);
this.drawLine(x,y+h,x+w,y+h);
this.drawLine(x,y,x,y+h);
}
function jsgFont(){
this.PLAIN="font-weight:normal;";
this.BOLD="font-weight:bold;";
this.ITALIC="font-style:italic;";
this.ITALIC_BOLD=this.ITALIC+this.BOLD;
this.BOLD_ITALIC=this.ITALIC_BOLD;
}
var Font=new jsgFont();
function jsgStroke(){
this.DOTTED=-1;
}
var Stroke=new jsgStroke();
function jsGraphics(cnv,wnd){
this.setColor=function(x){
this.color=x.toLowerCase();
};
this.setStroke=function(x){
this.stroke=x;
if(!(x+1)){
this.drawLine=_mkLinDott;
this._mkOv=_mkOvDott;
this.drawRect=_mkRectDott;
}else{
if(x-1>0){
this.drawLine=_mkLin2D;
this._mkOv=_mkOv2D;
this.drawRect=_mkRect;
}else{
this.drawLine=_mkLin;
this._mkOv=_mkOv;
this.drawRect=_mkRect;
}
}
};
this.setPrintable=function(arg){
this.printable=arg;
if(jg_fast){
this._mkDiv=_mkDivIe;
this._htmRpc=arg?_htmPrtRpc:_htmRpc;
}else{
this._mkDiv=arg?_mkDivPrt:_mkDiv;
}
};
this.setFont=function(fam,sz,sty){
this.ftFam=fam;
this.ftSz=sz;
this.ftSty=sty||Font.PLAIN;
};
this.drawPolyline=this.drawPolyLine=function(x,y){
for(var i=x.length-1;i;){
--i;
this.drawLine(x[i],y[i],x[i+1],y[i+1]);
}
};
this.setColor=new Function("arg","this.color = arg;");
this.getColor=new Function("return this.color");
this.fillRect=function(x,y,w,h){
this._mkDiv(x,y,w,h);
};
this.fillRectPattern=function(x,y,w,h,url){
this.htm+="<div style=\"position:absolute;"+"left:"+x+"px;"+"top:"+y+"px;"+"width:"+w+"px;"+"height:"+h+"px;"+"clip:rect(0,"+w+"px,"+h+"px,0);"+"overflow:hidden;"+"background-image: url('"+url+"');"+"layer-background-image: url('"+url+"');"+"z-index:100;\"></div>";
};
this.drawHandle=function(x,y,w,h,_5f){
this.htm+="<div style=\"position:absolute;"+"left:"+x+"px;"+"top:"+y+"px;"+"width:"+w+"px;"+"height:"+h+"px;"+"clip:rect(0,"+w+"px,"+h+"px,0);"+"padding: 2px;overflow:hidden;"+"cursor: '"+_5f+"';"+"\" class=\"handleBox\" id=\""+_5f+"\" ></div>";
};
this.drawHandleBox=function(x,y,w,h,_64){
this.htm+="<div style=\"position:absolute;"+"left:"+x+"px;"+"top:"+y+"px;"+"width:"+w+"px;"+"height:"+h+"px;"+"clip:rect(0,"+(w+2)+"px,"+(h+2)+"px,0);"+"overflow:hidden; border: solid 1px "+this.color+";"+"cursor: '"+_64+"';"+"\" class=\"handleBox\" id=\""+_64+"\" ></div>";
};
this.drawPolygon=function(x,y){
this.drawPolyline(x,y);
this.drawLine(x[x.length-1],y[x.length-1],x[0],y[0]);
};
this.drawEllipse=this.drawOval=function(x,y,w,h){
this._mkOv(x,y,w,h);
};
this.fillEllipse=this.fillOval=function(_6b,top,w,h){
var a=w>>1,b=h>>1,wod=w&1,hod=h&1,cx=_6b+a,cy=top+b,x=0,y=b,oy=b,aa2=(a*a)<<1,aa4=aa2<<1,bb2=(b*b)<<1,bb4=bb2<<1,st=(aa2>>1)*(1-(b<<1))+bb2,tt=(bb2>>1)-aa2*((b<<1)-1),xl,dw,dh;
if(w){
while(y>0){
if(st<0){
st+=bb2*((x<<1)+3);
tt+=bb4*(++x);
}else{
if(tt<0){
st+=bb2*((x<<1)+3)-aa4*(y-1);
xl=cx-x;
dw=(x<<1)+wod;
tt+=bb4*(++x)-aa2*(((y--)<<1)-3);
dh=oy-y;
this._mkDiv(xl,cy-oy,dw,dh);
this._mkDiv(xl,cy+y+hod,dw,dh);
oy=y;
}else{
tt-=aa2*((y<<1)-3);
st-=aa4*(--y);
}
}
}
}
this._mkDiv(cx-a,cy-oy,w,(oy<<1)+hod);
};
this.fillArc=function(iL,iT,iW,iH,_74,_75){
var a=iW>>1,b=iH>>1,iOdds=(iW&1)|((iH&1)<<16),cx=iL+a,cy=iT+b,x=0,y=b,ox=x,oy=y,aa2=(a*a)<<1,aa4=aa2<<1,bb2=(b*b)<<1,bb4=bb2<<1,st=(aa2>>1)*(1-(b<<1))+bb2,tt=(bb2>>1)-aa2*((b<<1)-1),xEndA,yEndA,xEndZ,yEndZ,iSects=(1<<(Math.floor((_74%=360)/180)<<3))|(2<<(Math.floor((_75%=360)/180)<<3))|((_74>=_75)<<16),aBndA=new Array(b+1),aBndZ=new Array(b+1);
_74*=Math.PI/180;
_75*=Math.PI/180;
xEndA=cx+Math.round(a*Math.cos(_74));
yEndA=cy+Math.round(-b*Math.sin(_74));
_mkLinVirt(aBndA,cx,cy,xEndA,yEndA);
xEndZ=cx+Math.round(a*Math.cos(_75));
yEndZ=cy+Math.round(-b*Math.sin(_75));
_mkLinVirt(aBndZ,cx,cy,xEndZ,yEndZ);
while(y>0){
if(st<0){
st+=bb2*((x<<1)+3);
tt+=bb4*(++x);
}else{
if(tt<0){
st+=bb2*((x<<1)+3)-aa4*(y-1);
ox=x;
tt+=bb4*(++x)-aa2*(((y--)<<1)-3);
this._mkArcDiv(ox,y,oy,cx,cy,iOdds,aBndA,aBndZ,iSects);
oy=y;
}else{
tt-=aa2*((y<<1)-3);
st-=aa4*(--y);
if(y&&(aBndA[y]!=aBndA[y-1]||aBndZ[y]!=aBndZ[y-1])){
this._mkArcDiv(x,y,oy,cx,cy,iOdds,aBndA,aBndZ,iSects);
ox=x;
oy=y;
}
}
}
}
this._mkArcDiv(x,0,oy,cx,cy,iOdds,aBndA,aBndZ,iSects);
if(iOdds>>16){
if(iSects>>16){
var xl=(yEndA<=cy||yEndZ>cy)?(cx-x):cx;
this._mkDiv(xl,cy,x+cx-xl+(iOdds&65535),1);
}else{
if((iSects&1)&&yEndZ>cy){
this._mkDiv(cx-x,cy,x,1);
}
}
}
};
this.fillPolygon=function(_78,_79){
var i;
var y;
var _7c,maxy;
var x1,y1;
var x2,y2;
var _7f,ind2;
var _80;
var n=_78.length;
if(!n){
return;
}
_7c=_79[0];
maxy=_79[0];
for(i=1;i<n;i++){
if(_79[i]<_7c){
_7c=_79[i];
}
if(_79[i]>maxy){
maxy=_79[i];
}
}
for(y=_7c;y<=maxy;y++){
var _82=new Array();
_80=0;
for(i=0;i<n;i++){
if(!i){
_7f=n-1;
ind2=0;
}else{
_7f=i-1;
ind2=i;
}
y1=_79[_7f];
y2=_79[ind2];
if(y1<y2){
x1=_78[_7f];
x2=_78[ind2];
}else{
if(y1>y2){
y2=_79[_7f];
y1=_79[ind2];
x2=_78[_7f];
x1=_78[ind2];
}else{
continue;
}
}
if((y>=y1)&&(y<y2)){
_82[_80++]=Math.round((y-y1)*(x2-x1)/(y2-y1)+x1);
}else{
if((y==maxy)&&(y>y1)&&(y<=y2)){
_82[_80++]=Math.round((y-y1)*(x2-x1)/(y2-y1)+x1);
}
}
}
_82.sort(_CompInt);
for(i=0;i<_80;i+=2){
this._mkDiv(_82[i],y,_82[i+1]-_82[i]+1,1);
}
}
};
this.drawString=function(txt,x,y){
this.htm+="<div style=\"position:absolute;white-space:nowrap;"+"left:"+x+"px;"+"top:"+y+"px;"+"font-family:"+this.ftFam+";"+"font-size:"+this.ftSz+";"+"color:"+this.color+";"+this.ftSty+"\">"+txt+"</div>";
};
this.drawStringRect=function(txt,x,y,_89,_8a){
this.htm+="<div style=\"position:absolute;overflow:hidden;"+"left:"+x+"px;"+"top:"+y+"px;"+"width:"+_89+"px;"+"text-align:"+_8a+";"+"font-family:"+this.ftFam+";"+"font-size:"+this.ftSz+";"+"color:"+this.color+";"+this.ftSty+"\">"+txt+"</div>";
};
this.drawImage=function(_8b,x,y,w,h,a){
this.htm+="<div style=\"position:absolute;"+"left:"+x+"px;"+"top:"+y+"px;"+"width:"+w+"px;"+"height:"+h+"px;\">"+"<img src=\""+_8b+"\" width=\""+w+"\" height=\""+h+"\""+(a?(" "+a):"")+">"+"</div>";
};
this.clear=function(){
this.htm="";
if(this.cnv){
this.cnv.innerHTML="";
}
};
this._mkOvQds=function(cx,cy,x,y,w,h,wod,hod){
var xl=cx-x,xr=cx+x+wod-w,yt=cy-y,yb=cy+y+hod-h;
if(xr>xl+w){
this._mkDiv(xr,yt,w,h);
this._mkDiv(xr,yb,w,h);
}else{
w=xr-xl+w;
}
this._mkDiv(xl,yt,w,h);
this._mkDiv(xl,yb,w,h);
};
this._mkArcDiv=function(x,y,oy,cx,cy,_9f,_a0,_a1,_a2){
var _a3=cx+x+(_9f&65535),y2,h=oy-y,xl,xr,w;
if(!h){
h=1;
}
x=cx-x;
if(_a2&16711680){
y2=cy-y-h;
if(_a2&255){
if(_a2&2){
xl=Math.max(x,_a1[y]);
w=_a3-xl;
if(w>0){
this._mkDiv(xl,y2,w,h);
}
}
if(_a2&1){
xr=Math.min(_a3,_a0[y]);
w=xr-x;
if(w>0){
this._mkDiv(x,y2,w,h);
}
}
}else{
this._mkDiv(x,y2,_a3-x,h);
}
y2=cy+y+(_9f>>16);
if(_a2&65280){
if(_a2&256){
xl=Math.max(x,_a0[y]);
w=_a3-xl;
if(w>0){
this._mkDiv(xl,y2,w,h);
}
}
if(_a2&512){
xr=Math.min(_a3,_a1[y]);
w=xr-x;
if(w>0){
this._mkDiv(x,y2,w,h);
}
}
}else{
this._mkDiv(x,y2,_a3-x,h);
}
}else{
if(_a2&255){
if(_a2&2){
xl=Math.max(x,_a1[y]);
}else{
xl=x;
}
if(_a2&1){
xr=Math.min(_a3,_a0[y]);
}else{
xr=_a3;
}
y2=cy-y-h;
w=xr-xl;
if(w>0){
this._mkDiv(xl,y2,w,h);
}
}
if(_a2&65280){
if(_a2&256){
xl=Math.max(x,_a0[y]);
}else{
xl=x;
}
if(_a2&512){
xr=Math.min(_a3,_a1[y]);
}else{
xr=_a3;
}
y2=cy+y+(_9f>>16);
w=xr-xl;
if(w>0){
this._mkDiv(xl,y2,w,h);
}
}
}
};
this.setStroke(1);
this.setFont("verdana,geneva,helvetica,sans-serif","12px",Font.PLAIN);
this.color="#000000";
this.htm="";
this.wnd=wnd||window;
if(!jg_ok){
_chkDHTM();
}
if(jg_ok){
if(cnv){
if(typeof (cnv)=="string"){
this.cont=document.all?(this.wnd.document.all[cnv]||null):document.getElementById?(this.wnd.document.getElementById(cnv)||null):null;
}else{
if(cnv==window.document){
this.cont=document.getElementsByTagName("body")[0];
}else{
this.cont=cnv;
}
}
this.cnv=this.wnd.document.createElement("div");
this.cnv.style.fontSize=0;
this.cont.appendChild(this.cnv);
this.paint=jg_dom?_pntCnvDom:_pntCnvIe;
}else{
this.paint=_pntDoc;
}
}else{
this.paint=_pntN;
}
this.setPrintable(false);
}
function _mkLinVirt(_a4,x1,y1,x2,y2){
var dx=Math.abs(x2-x1),dy=Math.abs(y2-y1),x=x1,y=y1,xIncr=(x1>x2)?-1:1,yIncr=(y1>y2)?-1:1,p,i=0;
if(dx>=dy){
var pr=dy<<1,pru=pr-(dx<<1);
p=pr-dx;
while(dx>0){
--dx;
if(p>0){
_a4[i++]=x;
y+=yIncr;
p+=pru;
}else{
p+=pr;
}
x+=xIncr;
}
}else{
var pr=dx<<1,pru=pr-(dy<<1);
p=pr-dy;
while(dy>0){
--dy;
y+=yIncr;
_a4[i++]=x;
if(p>0){
x+=xIncr;
p+=pru;
}else{
p+=pr;
}
}
}
for(var len=_a4.length,i=len-i;i;){
_a4[len-(i--)]=x;
}
}
function _CompInt(x,y){
return (x-y);
}

