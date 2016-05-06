/*
	DynAPI Distribution
	ProgressBarStyle (Default)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: StyleManager, ProgressBar
*/

function ProgressBarStyle (){
	var style = new Style(); // create basic style object
	style.styleName='ProgressBarStyle';
	style.barColor = 'navy';
	style.imageBar = null;
	// initStyle will act as a function of the DynLayer object
	style.initStyle = function(){
		var a
		if(this._orient=='H') a={left:1,top:1,bottom:1};
		else a={left:1,right:1,bottom:1};
		this.lyrBar.setAnchor(a);
		this.setInnerBorder(1,this.style.getStyleAttribute('borderColor'));
		this.renderStyle();
	};	
	// renderStyle will act as a function of the DynLayer object
	style.renderStyle = function(act){
		var all=!act;
		if(all||act=='resize') {
			var l;
			l=(this._orient=='H')? this.w:this.h;
			l=l-2;
			l=l*(this._value/this._max);
			if(l<1) l=0; else l=parseInt(l);
			if(this._orient=='H') this.lyrBar.setWidth(l);
			else this.lyrBar.setHeight(l);
		}
		if(all) {  // set other attributes if rendering all areas
			var bg = this.getStyleAttribute('imageBar');			
			this.setBgColor(this.getStyleAttribute('backColor'));
			if(bg) this.lyrBar.setBgImage(bg.src);
			else this.lyrBar.setBgColor(this.getStyleAttribute('barColor'));
		}

	};
	return style;
};

StyleManager.addStyle('ProgressBar',ProgressBarStyle);


