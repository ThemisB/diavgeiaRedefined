/*
	DynAPI Distribution
	KnobStyle (Default)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: StyleManager, Knob
*/

function KnobStyle(){
	var style = new Style(); // create basic style object
	style.styleName='KnobStyle';
	// initStyle will act as a function of the DynLayer object
	style.initStyle = function(){
		this.renderStyle();
	};
	// renderStyle will act as a function of the DynLayer object
	style.renderStyle = function(act){
		var all=!act;
		var o = this;
		if(all||act=='resize') {
			this.setHTML(
				Styles.createPanel(1,this.w,this.h,
					o.getStyleAttribute('borderColor'),
					o.getStyleAttribute('lightColor'),
					o.getStyleAttribute('darkColor'),
					o.getStyleAttribute('backColor')
				)
			);
		};
	};

	// removeStyle will act as a function of the DynLayer object
	// style.removeStyle = function(){};
	return style;
};

// Creates the style once it has been loaded
Styles.addStyle('Knob',KnobStyle);