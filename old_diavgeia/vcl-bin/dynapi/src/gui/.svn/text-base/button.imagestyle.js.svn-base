/*
	DynAPI Distribution
	ButtonImageStyle

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: StyleManager, Button
*/

function ButtonImageStyle(){
	var style = new Style(); // create basic style object
	style.styleName='ImageButtonStyle';
	style._coverAnchor ={left:0,right:0,top:0,bottom:0};
	style.fontSize=2;
	style.imageOvr = null;
	style.loadImages = function(){
		// load default images
		if(!this.imageOff) this.imageOff = Styles.getImage('btn_off.gif',22,22);
		if(!this.imageOn) this.imageOn = Styles.getImage('btn_on.gif',22,22);
	};
	style._events = {
		onmouseout:function(e){
			var o=e.getSource();
			o.invokeEvent('mouseup',null,true);
		},
		onmouseover:function(e){
			var o=e.getSource();
			if(o._disabled) return null;
			var img=o.getStyleAttribute('imageOvr');
			if(!img) return;
			if(!dynapi.ua.ie) o.setBgImage(img.src);
			else o.lyrImage.setHTML(img.getHTML());
		},
		onmouseup:function(e,args){
			var o=e.getSource();
			var bs = (dynapi.ua.ns4)? o._blkBoardElm:o._blkBoardElm.style;
			bs.left="0"; bs.top="0";
			var img=o.getStyleAttribute('imageOff');
			if(!img) return;
			if(!dynapi.ua.ie) o.setBgImage(img.src);
			else o.lyrImage.setHTML(img.getHTML());
			if(!args) o.invokeEvent('buttonclick'); // this gives better clicking resolutions in IE. See "Mouse Click Speed Test" - Trouble Shooting
		},
		onmousedown:function(e){
			var o=e.getSource();
			if(o._disabled) return null;
			var bs = (dynapi.ua.ns4)? o._blkBoardElm:o._blkBoardElm.style;
			if(!bs.position) bs.position = 'absolute';
			bs.left="1"; bs.top="1";
			var img=o.getStyleAttribute('imageOn');
			if(!img) return;
			if(!dynapi.ua.ie) o.setBgImage(img.src);
			else o.lyrImage.setHTML(img.getHTML());
		}
	};
	style._setImage = function(ximg,state){
		if (state=='on') state='imageOn';
		else if (state=='ovr') state='imageOvr';
		else state='imageOff';
		this.setLocalStyleAttribute(state,ximg);
		if(!this._isToggled && state=='imageOff') {
			if(!dynapi.ua.ie) o.setBgImage(img.src);
			else o.lyrImage.setHTML(img.getHTML());
		}
	};

	// initStyle will act as a function of the DynLayer object
	style.initStyle = function(){
		var style = this.style;
		var img=this.getStyleAttribute('imageOff');
		this.enableBlackboard();
		this.setTextSelectable(false);
		this.setCursor('hand');
		this.setBgColor(null); // remove bgcolor
		this.setImage = style._setImage;
		if(!dynapi.ua.ie) this.setBgImage(img.src);
		else{
			this.addChild(new DynLayer(img.getHTML(),0,0,img.width,img.height),'lyrImage');
			this.lyrImage.setZIndex(-1);
		}
		this.setMinimumSize(img.width,img.height);
		this.setMaximumSize(img.width,img.height);
		if(dynapi.ua.ns4) {
			this.addChild(new DynLayer(),'lyrCover');
			this.lyrCover.setAnchor(this.style._coverAnchor);
			this.lyrCover.captureMouseEvents();
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
	};

	// removeStyle will act as a function of the DynLayer object
	style.removeStyle = function(){
		if(dynapi.ua.ns4) this.lyrCover.deleteFromParent();
		if(!dynapi.ua.ie) this.setBgImage(null);
		else this.lyrImage.deleteFromParent();
		this.removeEventListener(this.style._events);
	};

	return style;
};

// Creates the style once it has been loaded
Styles.addStyle('ButtonImage',ButtonImageStyle);
