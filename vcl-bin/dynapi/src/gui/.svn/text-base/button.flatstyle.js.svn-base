/*
	DynAPI Distribution
	ButtonFlatStyle

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: StyleManager, BorderManager, Button
*/

function ButtonFlatStyle(){

	var style = new Style(); // create basic style object
	style.styleName='FlatButtonStyle';	
	// setup mouse over and down color, mouse out will use backColor and foreColor
	style.mOverBackColor = style.selBackColor;
	style.mDownBackColor = '#FFCC00';
	//style.mOverForeColor = style.mDownForeColor = style.selForeColor;
	style.fontSize=2;
	style._coverAnchor ={left:0,right:0,top:0,bottom:0};
	style._events = {
		onmouseout:function(e){
			var o=e.getSource();
			o.setInnerBorder(0);
			o.setBgColor(o.getStyleAttribute('backColor'));
			o.invokeEvent('mouseup',null,true);
		},
		onmouseover:function(e){
			var o=e.getSource();
			if(o._disabled) return null;
			o.setInnerBorder(1,o.getStyleAttribute('borderColor'));
			o.setBgColor(o.getStyleAttribute('mOverBackColor'));
		},
		onmousedown:function(e){
			var o=e.getSource();
			if(o._disabled) return null;
			var bs = (dynapi.ua.ns4)? o._blkBoardElm:o._blkBoardElm.style;
			if(!bs.position) bs.position = 'absolute';
			bs.left="1";
			bs.top="1";
			o.setBgColor(o.getStyleAttribute('mDownBackColor'));
		},
		onmouseup:function(e,args){
			var o=e.getSource();
			if(o._disabled) return null;
			var bs = (dynapi.ua.ns4)? o._blkBoardElm:o._blkBoardElm.style;
			bs.left="0";
			bs.top="0";
			if(!args) {
				o.setBgColor(o.getStyleAttribute('mOverBackColor'));
				o.invokeEvent('buttonclick'); // this gives better clicking resolutions in IE. See "Mouse Click Speed Test" - Trouble Shooting
			}
		}
	};

	// initStyle will act as a function of the DynLayer object
	style.initStyle = function(){
		var style = this.style;
		this.enableBlackboard();
		this.setTextSelectable(false);
		this.setCursor('hand');
		if(dynapi.ua.ns4) {
			this.addChild(new DynLayer(),'lyrCover');
			this.lyrCover.setAnchor(this.style._coverAnchor);
			//this.lyrCover.captureMouseEvents();
		}
		this.addEventListener(style._events);
		this.renderStyle();
	};

	// renderStyle will act as a function of the DynLayer object
	style.renderStyle = function(act){
		var all =!act;

		// caption & resize
		if(all||act=='caption'||act=='resize'){
			this.setHTML(this._getCapHTML());
		}
		// set other attributes if rendering all areas
		if(all){
			this.setBgColor(this.getStyleAttribute('backColor'));
		}
	};

	// removeStyle will act as a function of the DynLayer object
	style.removeStyle = function(){
		this.setInnerBorder(0);
		if(dynapi.ua.ns4) this.lyrCover.deleteFromParent();
		this.removeEventListener(this.style._events);
	};

	return style;
};

// Creates the style once it has been loaded
Styles.addStyle('ButtonFlat',ButtonFlatStyle);
