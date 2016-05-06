/*
	DynAPI Distribution
	ListBoxStyle (Default)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: StyleManager, ListBox
*/

function ListBoxStyle (){
	var style = new Style(); // create basic style object
	style.styleName='ListBoxStyle';
	style.mOverColor = style.selBackColor;
	style.firstRowColor = '#FFFFFF';
	style.altRowColor = '#FFFFFF';
	style.loadImages = function(){
		if(!this.imageOn) this.imageOn = Styles.getImage('check_on.gif',13,13);
		if(!this.imageOff) this.imageOff = Styles.getImage('check_off.gif',13,13);
	};
	// initStyle will act as a function of the DynLayer object
	style.initStyle = function(){	
		this.vscBar.setAnchor({top:1,right:1,bottom:1});
		this.renderStyle();
	};
	// renderStyle will act as a function of the DynLayer object
	style.renderStyle = function(act){
		var all=!act;
	
		//if(all||act=='resize') this.vscBar.setLength(this.h-2);
		if(all){ // set other attributes if rendering all areas
			this.lyrItms.setBgColor(this.getStyleAttribute('firstRowColor'));
			this.setBgColor(this.getStyleAttribute('backColor'));
			if(this._created) this._modItemsLayout(); //setup items
		}
	};
	
	return style;
}

Styles.addStyle('ListBox',ListBoxStyle);

