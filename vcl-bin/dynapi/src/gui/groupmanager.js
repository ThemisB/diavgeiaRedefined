/*
	DynAPI Distribution
	GroupManager Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

	requires: Dynlayer
*/

function GroupManager(){
	this.EventObject=EventObject;
	this.EventObject();
	
	this.x = this.y = null;
	this.w = this.h = null;
	this._objects={};
	
};
GroupManager._NewSetSize = function(w,h){
	this._OldDynGMSetSize(w,h);	
	this._grpManager._setSize(this);
	this._grpManager._resetSize();
	this._grpManager.changeLocationBy(0,0);
};
GroupManager._NewSetLocation = function(x,y){
	var byX=x-this.x;
	var byY=y-this.y;
	if(this._grpUX) byX=0; else x=null;
	if(this._grpUY) byY=0; else y=null;
	if(x!=null || y!=null) this._OldDynGMSetLocation(x,y);
	if(!this._grpUX || !this._grpUY) {
		this._grpManager.changeLocationBy(byX,byY);
	}
};
var p= dynapi.setPrototype("GroupManager","EventObject");
p._setSize = function(dlyr){
	var lw,lh,px,py;
	if(!dlyr) return;
	// store previous x,y
	px=this.x; py=this.y;
	// calc x,y
	this.x = (this.x==null||(dlyr.x!=null && this.x>dlyr.x))? dlyr.x:this.x;
	this.y = (this.y==null||(dlyr.y!=null && this.y>dlyr.y))? dlyr.y:this.y;
	// calc w,h
	lw=(dlyr.x+dlyr.w)-this.x; lh=(dlyr.y+dlyr.h)-this.y;
	this.w = (this.w==null||(dlyr.w!=null && this.w<lw))? lw:this.w;
	this.h = (this.h==null||(dlyr.h!=null && this.h<lh))? lh:this.h;
	// add trailing or leading w/h
	if(px>dlyr.x) this.w+=(px-dlyr.x);
	if(py>dlyr.y) this.h+=(py-dlyr.y);
};
p._resetSize = function(){
	var o,objs=this._objects;
	this.x=this.y=this.w=this.h=null;
	for (var i in objs){
		o=objs[i];
		this._setSize(o);
	}
};

p.add = function(dlyr,unlockX,unlockY){
	var lw,lh;
	if(!dlyr) return;
	if(this._objects[dlyr.id]) return;
	dlyr._grpManager=this;
	dlyr._grpUX = unlockX;
	dlyr._grpUY = unlockY;
	dlyr._OldDynGMSetSize = dlyr.setSize;
	dlyr._OldDynGMSetLocation = dlyr.setLocation;
	dlyr.setSize = GroupManager._NewSetSize;
	dlyr.setLocation = GroupManager._NewSetLocation;
	if (this.x==dlyr.x && this.w<dlyr.w) this.w=dlyr.w;	
	this._objects[dlyr.id]=dlyr;
	this._setSize(dlyr);
	return dlyr;
};
p.changeLocationBy = function(byX,byY) {
	var o,objs=this._objects;
	for (var i in objs){
		o=objs[i];
		o._OldDynGMSetLocation(o.x+byX,o.y+byY,true);
	}
	this.x+=byX; this.y+=byY;
	// Check for boundary, if any
	if (this._boundary) {
		var x=this.x,y=this.y;
		var dB = this._boundary;
		var b=dB[2];
		var r=dB[1];
		var l=dB[3];
		var t=dB[0];
		var w=this.w;
		var h=this.h;
		if (this.x<l||this.w>=r) x=l;
		else if (this.x+w>r) x=r-w;
		if (this.y<t||this.h>=b) y=t;
		else if (this.y+h>b) y=b-h;
		if(this.x!=x||this.y!=y) this.setLocation(x,y);
	}
};
p.remove = function(dlyr){
	if(!dlyr) return;
	dlyr=this._objects[dlyr.id];
	if(dlyr) {
		this._objects = dynapi.functions.removeFromObject(this._objects,dlyr.id);
		dlyr.setSize = dlyr._OldDynGMSetSize;
		dlyr.setLocation = dlyr._OldDynGMSetLocation;
		dlyr._OldDynGMSetSize = null;
		dlyr._OldDynGMSetLocation = null;
		dlyr._grpManager = null;
		this._resetSize();
	}
};
p.sendMessage = function(msg,a1,a2,a3,a4,a5,a6,a7){
	var o,objs=this._objects;
	for (var i in objs){
		o=objs[i];
		if(o[msg]) o[msg](a1,a2,a3,a4,a5,a6,a7);
		else eval(o+'.'+msg);
	}
};
p.setBoundary = function(t,r,b,l){
	if(t==null && arguments.length==1) this._boundary = null;
	else this._boundary = [t,r,b,l];
};
p.setLocation = function(x,y) {
	var byX=x-this.x;
	var byY=y-this.y;
	this.changeLocationBy(byX,byY);
};
p.unlockX = function(b,dlyr){
	if(!dlyr) {
		var objs=this._objects;
		for (var i in objs) objs[i]._grpUX=b;
	}else{
		dlyr=this._objects[dlyr.id];
		if(dlyr) dlyr._grpUX=b;
	}
	if(!b) this._resetSize();
};
p.unlockY = function(b,dlyr){
	var objs=this._objects;
	if(!dlyr) {
		var objs=this._objects;
		for (var i in objs) objs[i]._grpUY=b;
	}else{
		dlyr=this._objects[dlyr.id];
		if(dlyr) dlyr._grpUY=b;
	}
	if(!b) this._resetSize();
};
p.unlockXY = function(b,dlyr){
	if(!dlyr) {
		var objs=this._objects;
		for (var i in objs) {
			objs[i]._grpUX=b;
			objs[i]._grpUY=b;
		}
	}else{
		dlyr=this._objects[dlyr.id];
		if(dlyr) {
			dlyr._grpUX=b;
			dlyr._grpUY=b;
		}
	}
	if(!b) this._resetSize();
};
p.getUnlockX = function(dlyr){
	if(!dlyr) {
		var results = new Array();
		var trueCount = 0;
		var falseCount = 0;
		var objs=this._objects;
		for (var i in objs) {
			results[objs[i]] = objs[i]._grpUX;
			if( objs[i]._grpUX == true ) {
				trueCount++;
			} else {
				falseCount++;
			}
		}
		if( falseCount == 0 ) {
			return true;
		} else if( trueCount == 0 ) {
			return false;
		} else {
			return results;
		}
	} else {
		dlyr=this._objects[dlyr.id];
		if(dlyr) {
			return dlyr._grpUX;
		}
	}
		
}

p.getUnlockY = function(dlyr){
	if(!dlyr) {
		var results = new Array();
		var trueCount = 0;
		var falseCount = 0;
		var objs=this._objects;
		for (var i in objs) {
			results[objs[i]] = objs[i]._grpUY;
			if( objs[i]._grpUY == true ) {
				trueCount++;
			} else {
				falseCount++;
			}
		}
		if( falseCount == 0 ) {
			return true;
		} else if( trueCount == 0 ) {
			return false;
		} else {
			return results;
		}
	} else {
		dlyr=this._objects[dlyr.id];
		if(dlyr) {
			return dlyr._grpUY;
		}
	}
		
}
p.setUnlockXState = function(values) {
	if( values.length === undefined ) {
		this.unlockX(values);
	} else {
		for( var obj in values ) {
			this.unlockX(values[obj],obj);
		}
	}
}

p.setUnlockYState = function(values) {
	if( values.length === undefined ) {
		this.unlockY(values);
	} else {
		for( var obj in values ) {
			this.unlockY(values[obj],obj);
		}
	}
}

		
		

