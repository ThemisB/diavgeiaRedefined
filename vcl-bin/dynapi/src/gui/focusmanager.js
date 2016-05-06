/*
	DynAPI Distribution
	FocusManager Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

	requires: DynLayer
*/

FocusManager={};

// usage: FocusManager.enableFocus('auto',true,'click',lyr1,lyr2,...lyrN);
FocusManager.enableFocus=function(b,bubble,type){
	var lyr,arg=arguments;
	for (var i=3;i<arg.length;i++){
		lyr=arg[i];
		if(lyr) lyr.setFocus(b,bubble,type);
	}
};

DynLayer.prototype.setFocus = function(b,bubble,type){
	var i,topchild;
	//var d=this.design;
	bubble=(bubble==null)? true:bubble;
	if(b!=='auto' && !this.parent) return;
	if(b=='auto' && !this._hasFocusEvents) {
		if(type!='hover') type='click';
		this._focusType=type;
		this._focusBubble=bubble;
		this._hasFocusEvents=true;
		this.addEventListener(DynLayer.FocusEvent);
	}
	else if (b && !this._focused) {
		topchild=this.parent._topMostChild;
		//i = this.parent.children.length;
		if(topchild && topchild!=this) topchild.setFocus(false,bubble);
		if(this._hasTabManager) this.updateTabManager();
		this.setZIndex({topmost:true});
		this.parent._topMostChild=this;
		this._focused=true;
		this.invokeEvent('focus');
		var o=this.parent;
		if(bubble) while (o && o!=dynapi.document) {
			o.setFocus(b,bubble);
			o=o.parent;
		};
	}else if(!b && this._focused){
		topchild=this.parent._topMostChild;
		if (topchild) this.setZIndex({below:topchild});
		else this.setZIndex(thiz.z-1);
		this._focused=false;
		this.invokeEvent('blur');
		var o=this.parent;
		var ch=this.children;
		// blur children with focus
		for(var i=0;i<ch.length;i++) if(ch[i]._focused) ch[i].setFocus(false,bubble);
		if(o && o!=dynapi.document) o.setFocus(false,bubble);
	}
};

//DynLayer.prototype.setTabIndex = function(n){
//};

DynLayer.FocusEvent = {
	onclick : function(e){
		var o=e.getSource();
		if(o._focusType=='click') {
			o.setFocus(true,o._focusBubble);
		}
	},
	onmouseover : function(e){
		var o=e.getSource();
		if(o._focusType=='hover') {
			o.setFocus(true,o._focusBubble);
		}
	}
};
