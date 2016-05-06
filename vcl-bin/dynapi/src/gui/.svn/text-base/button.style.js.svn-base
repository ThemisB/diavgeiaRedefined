/*
	DynAPI Distribution
	ButtonStyle (Default)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: StyleManager, BorderManager, Button
*/

function ButtonStyle(){
	var style = new Style(); // create basic style object
	style.styleName='ButtonStyle';	
	style.fontSize=2;
	style._coverAnchor ={left:0,right:0,top:0,bottom:0};
	style._bor_tp={top:1,left:1,right:1};
	style._bor_rt={top:1,right:1,bottom:1};
	style._bor_bm={bottom:1,left:1,right:1};
	style._bor_lt={top:1,left:1,bottom:1};
	style._events = {
		onmouseout:function(e){
			var o=e.getSource();
			if(o._mouseDn) o.invokeEvent('mouseup',null,true);
		},
		onmouseup:function(e,args){
			var o=e.getSource();
			var bs = (dynapi.ua.ns4)? o._blkBoardElm:o._blkBoardElm.style;
			bs.left="0"; bs.top="0";
			o._mouseDn = false;
			o.setInnerBorder(1,{
				light:o.style.getStyleAttribute('lightColor'),
				dark:o.style.getStyleAttribute('darkColor')
			});
			if(!args) o.invokeEvent('buttonclick'); // this gives better clicking resolutions in IE. See "Mouse Click Speed Test" - Trouble Shooting
		},
		onmousedown:function(e){
			var o=e.getSource();
			if(o._disabled) return null;
			var bs = (dynapi.ua.ns4)? o._blkBoardElm:o._blkBoardElm.style;
			if(!bs.position) bs.position = 'absolute';
			bs.left="1"; bs.top="1";
			o._mouseDn = true;
			o.setInnerBorder(1,{
				light:o.style.getStyleAttribute('darkColor'),
				dark:o.style.getStyleAttribute('lightColor')
			});
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
			this.lyrCover.captureMouseEvents();
		}
		this.addEventListener(style._events);
		this.setInnerBorder(1,{
			light:this.style.getStyleAttribute('lightColor'),
			dark:this.style.getStyleAttribute('darkColor')
		});
		
		// adjust borders 
		this._borTp.setAnchor(style._bor_tp);
        this._borRt.setAnchor(style._bor_rt);
        this._borBm.setAnchor(style._bor_bm);
        this._borLt.setAnchor(style._bor_lt);
 
 		this.renderStyle();
	};
	// renderStyle will act as a function of the DynLayer object
	style.renderStyle = function(act){
		var all=!act;
		
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
		this.deleteAllChildren();
		this._borTp=this._borRt=this._borBm=this._borLt=null;
	};

	return style;
};

// Creates the style once it has been loaded
Styles.addStyle('Button',ButtonStyle);