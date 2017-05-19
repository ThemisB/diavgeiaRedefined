/*
	DynAPI Distribution
	BorderManager Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

	Requires: Highlighter
*/

BorderManager = {};

// usage: BorderManager.enableBorder(border_width,border_color,border_type,lyr1,lyr2,...lyrN);
BorderManager.enableBorder=function(w,c,style){
	var lyr,arg=arguments;
	for (var i=3;i<arg.length;i++){
		lyr=arg[i];
		if(lyr) lyr.setBorder(w,c,style);
	}
};

var p = DynLayer.prototype;
/*
Border
	style:	inner, css-styles (solid, dotted, inset, outset,groove, etc)
			ns4 will use layers for both inner and css-styles (only solid supported)
*/
p.setBorder = function(w,c,style){
	var oldW = w,defW = 0;
	var defCol = '#000000';
	var defStyle = 'solid';
	var tc,rc,bc,lc;
	var ts,rs,bs,ls;
	var tw=0,rw=0,bw=0,lw=0;
	if(style=='inner') this.setInnerBorder(oldW,c);
	else {
		// handle width
		if (w==null) w = defW;
		else if(typeof(w)=='object') {
			tw=w.top||w.light;
			rw=w.right||w.dark;
			bw=w.bottom||w.dark;
			lw=w.left||w.light;
			w=defW;
		};
		this._needBoxFix = true;
		this._fixBoxModel = false;
		this._fixBw = (lw+rw)||(w*2);
		this._fixBh = (tw+bw)||(w*2);
		this._fixBwp = this._fixBhp = 0;
		if(dynapi.ua.ns4) this.setInnerBorder(oldW,c);
		else {
			// handle color
			if (c==null) c = defCol;
			else if(typeof(c)=='object') {
				tc=c.top||c.light;
				rc=c.right||c.dark;
				bc=c.bottom||c.dark;
				lc=c.left||c.light;
				c=defCol;
			};
			// Style
			if (style==null) style = defStyle;
			else if(typeof(style)=='object') {
				ts=style.top||style.light;
				rs=style.right||style.dark;
				bs=style.bottom||style.dark;
				ls=style.left||style.light;
				style=defStyle;
			};
			// Setup CSS
			this._cssBorTop = (tw||w)+'px '+(ts||style)+' '+(tc||c);
			this._cssBorRight = (rw||w)+'px '+(rs||style)+' '+(rc||c);
			this._cssBorBottom = (bw||w)+'px '+(bs||style)+' '+(bc||c);
			this._cssBorLeft = (lw||w)+'px '+(ls||style)+' '+(lc||c);
			if(this.elm){
				var css = this.css;
				css.borderTop = this._cssBorTop;
				css.borderRight = this._cssBorRight;
				css.borderBottom = this._cssBorBottom;
				css.borderLeft = this._cssBorLeft;
				BorderManager.FixBoxModel(this);
			}
			else {
				this._cssBorder = ' border-top:'+this._cssBorTop +
					'; border-right:'+this._cssBorRight +
					'; border-bottom:'+this._cssBorBottom +
					'; border-left:'+this._cssBorLeft+'; '
			}
		}
	}
};

/*
Inner Border Only.
useage: setInnerBorder(N,'#000000')
        setInnerBorder(N,{top:'white',bottom:'black'});
        setInnerBorder(N,{light:'white',dark:'silver'});
        setInnerBorder({top:2,bottom:1},'#000000');
*/
p.setInnerBorder = function(w,c){
	var _bor_tp={top:0,left:0,right:0-this._fixBw};
	var _bor_rt={top:0,right:0-this._fixBw,bottom:0-this._fixBh};
	var _bor_bm={bottom:0-this._fixBh,left:0,right:0-this._fixBw};
	var _bor_lt={top:0,left:0,bottom:0-this._fixBh};
	var tc,rc,bc,lc;
	var tw=0,rw=0,bw=0,lw=0;
	// handle width
	if (w==null) w = 0;
	else if(typeof(w)=='object') {
		tw=w.top||w.light;
		rw=w.right||w.dark;
		bw=w.bottom||w.dark;
		lw=w.left||w.light;
		w = 0;
	};
	// handle color
	if (c==null) c='#000000';
	else if(typeof(c)=="object") {
			tc=c.top||c.light;
			rc=c.right||c.dark;
			bc=c.bottom||c.dark;
			lc=c.left||c.light;
			c=null;
	};
	if(!this._borTp){
		// create border layers
		this.addChild(new Highlighter(),'_borTp');//top
		this.addChild(new Highlighter(),'_borRt');//right         
		this.addChild(new Highlighter(),'_borBm');//bottom
		this.addChild(new Highlighter(),'_borLt'); //left
		// setup anchors
		this._borTp.setAnchor(_bor_tp);
		this._borRt.setAnchor(_bor_rt);
		this._borBm.setAnchor(_bor_bm);
		this._borLt.setAnchor(_bor_lt);
		// z-index
		this._borTp.setZIndex(10000);
		this._borRt.setZIndex(10000);
		this._borBm.setZIndex(10000);
		this._borLt.setZIndex(10000);
	}

	// width
	this._borTp.setHeight(tw||w);
	this._borRt.setWidth(rw||w);
	this._borBm.setHeight(bw||w);
	this._borLt.setWidth(lw||w);
	// color
	this._borTp.setBgColor(tc||c);
	this._borRt.setBgColor(rc||c);
	this._borBm.setBgColor(bc||c);
	this._borLt.setBgColor(lc||c);
	// update anchors
	if (this._updateAnchors) this._updateAnchors();
};

// Fix Box Model
BorderManager.FixBoxModel = function(lyr,force){
	if(!this.compatCheck) {
		var compat = document.compatMode;
		this.compatCheck = true;
		this.compatMode = (typeof compat=="string"&&compat!="BackCompat");
	}
	
	if (!dynapi.ua.opera && this.compatMode) return;
	else if(!force && (!lyr||!lyr.css||lyr._fixBoxModel)) return;

	var fixed,css = lyr.css;
	var p = this.FixBoxModelParseInt;
	var cWidth = lyr.w||p(css.width), cHeight = lyr.h||p(css.height);
	var wBorder = lyr._fixBw;//||(p(css.borderLeftWidth) + p(css.borderRightWidth));
	var hBorder = lyr._fixBh;//||(p(css.borderTopWidth) + p(css.borderBottomWidth));
	var wPadding = lyr._fixBwp;//||(p(css.paddingLeft) + p(css.paddingRight));
	var hPadding = lyr._fixBhp;//||(p(css.paddingTop) + p(css.paddingBottom));
	if(wBorder>0||wPadding>0) {
		fixed = true;
		cWidth = cWidth + wBorder + wPadding;
		if(!dynapi.ua.gecko) lyr.css.width = cWidth;
	}
	if(hBorder>0||hPadding>0) {
		fixed = true;
		cHeight = cHeight + hBorder + hPadding;
		if(dynapi.ua.ie) lyr.css.height = cHeight;
	}
	if(fixed){
		lyr.css.clip = 'rect(0px,'+(cWidth)+'px,'+(cHeight)+'px,0px)';
		lyr._fixBoxModel = true;
		lyr._fixBw = wBorder;
		lyr._fixBh = hBorder;
		lyr._fixBwp = wPadding;
		lyr._fixBhp = hPadding;
	}
};
BorderManager.FixBoxModelParseInt = function(s){
	return parseInt(s,10)||0;
};
