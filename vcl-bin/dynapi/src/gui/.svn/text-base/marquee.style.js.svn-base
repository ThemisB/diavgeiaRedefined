/*
	DynAPI Distribution
	MarqueeStyle (Default)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: StyleManager, Marquee
*/

function MarqueeStyle (){
	var style = new Style(); // create basic style object
	style.styleName='MarqueeStyle';
	style.backColor = '#FFFFFF';
	// initStyle will act as a function of the DynLayer object
	style.initStyle = function(){
		this.renderStyle();
		if(this._action=='start') this._animate();
	};	
	// renderStyle will act as a function of the DynLayer object
	style.renderStyle = function(act){
		var all=!act;
		this.lyrCanvas.setHTML(this._cvhtml);
		if((all||act=='html') && this._created) {
			this.lyrCanvas.setSize(0,0);
			var w = this.getContentWidth();
			var h = this.getContentHeight();
			this.lyrCanvas.setSize(100,100);
		}
		if(all) {  // set other attributes if rendering all areas
			this.setBgColor(this.getStyleAttribute('backColor'));
		}

	};	
	return style;
};

StyleManager.addStyle('Marquee',MarqueeStyle);