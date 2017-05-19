/*
	DynAPI Distribution
	ViewPaneStyle (Default)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: StyleManager, ViewPane
*/

function ViewPaneStyle (){
	var style = new Style(); // create basic style object
	style.styleName='ViewPaneStyle';
	style.contentBackColor = '#FFFFFF';
	style.borderColor = style.backColor;
	style.imageCorner = null; // optional corner image
	// initStyle will act as a function of the DynLayer object
	style.initStyle = function(){
		this.hscBar.setSmallChange(5);
		this.hscBar.setLargeChange(20);

		this.vscBar.setSmallChange(5);
		this.vscBar.setLargeChange(20);
		this.setInnerBorder(1,this.getStyleAttribute('borderColor'));
		if(this._created) this.renderStyle();
	};
	// renderStyle will act as a function of the DynLayer object
	style.renderStyle = function(act){
		var all=!act;
		var c = this.lyrContent;
		var ic =this.getStyleAttribute('imageCorner');
		
		if(!this._created) return;
		
		if(all||act=='resize'){
			// adjust scrollbars
			var w = c.getWidth();
			var h = c.getHeight();
			if(this._showVBar && h>this.getHeight()) this.vscBar.setVisible(true);
			else this.vscBar.setVisible(false);
			if(this._showHBar && w>this.getWidth()) this.hscBar.setVisible(true);
			else this.hscBar.setVisible(false);
			this.hscBar.setRange(0,w-this.w+(this.vscBar.getVisible()? this.vscBar.getWidth():0));
			this.vscBar.setRange(0,h-this.h+(this.hscBar.getVisible()? this.hscBar.getHeight():0));
			this.vscBar.setAnchor({
				top:1,
				right:1,
				bottom:(this.hscBar.getVisible()? this.hscBar.getHeight():1)
			});
			this.hscBar.setAnchor({
				bottom:1,
				left:1,
				right:(this.vscBar.getVisible()? this.vscBar.getWidth():1)
			});
			// show corner layer
			if(!(this.hscBar.getVisible() && this.vscBar.getVisible())) this.lyrCorner.setVisible(false); 
			else {
				this.lyrCorner.setVisible(true);
				this.lyrCorner.setAnchor({
					left:this.hscBar.getWidth(),
					right:1,
					top:this.vscBar.getHeight(),
					bottom:1
				});
			}	
		}

		if(all){ // set other attributes if rendering all areas
			this.setBgColor(this.getStyleAttribute('contentBackColor'));
			c.setBgColor(this.getStyleAttribute('contentBackColor'));
			if(!ic)	this.lyrCorner.setBgColor(this.getStyleAttribute('backColor'));
			else this.lyrCorner.setHTML(ic.getHTML())
		}
	};
	
	return style;
}

Styles.addStyle('ViewPane',ViewPaneStyle);

