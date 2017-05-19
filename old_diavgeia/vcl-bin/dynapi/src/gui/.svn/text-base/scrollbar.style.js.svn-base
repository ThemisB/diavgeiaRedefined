/*
	DynAPI Distribution
	ScrollBarStyle (Default)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: StyleManager, ScrollBar
*/

function ScrollBarStyle(){
	var style = new Style(); // create basic style object
	style.styleName='ScrollBarStyle';
	style.backColor = '#EEEEEE';
	style.imageTrack = null;
	style.loadImages = function(){
		if(!this.imageUp) this.imageUp = Styles.getImage('arr_up.gif',9,9);
		if(!this.imageDown) this.imageDown = Styles.getImage('arr_down.gif',9,9);
		if(!this.imageLeft) this.imageLeft = Styles.getImage('arr_left.gif',9,9);
		if(!this.imageRight) this.imageRight = Styles.getImage('arr_right.gif',9,9);
	};
	// initStyle will act as a function of the DynLayer object
	style.initStyle = function(){	
		var style = this.style;
		var up=this.btnUp;
		var dn=this.btnDown;
		var knob=this.knob;

		knob.setLocalStyleAttribute('borderColor',this.getStyleAttribute('backColor')); //??

		if (this._bartype=='V'){
			knob.setAnchor({left:0,right:0});
			DragEvent.setDragBoundary(knob,{left:0,right:0,top:16,bottom:16});
			up.setAnchor({left:0,right:0,bottom:0,stretchV:16});
			dn.setAnchor({left:0,right:0,top:0,stretchV:16});
			this.lyrTrack.setAnchor({left:0,right:0,top:16,bottom:16});
		}else{
			knob.setAnchor({top:0,bottom:0});
			DragEvent.setDragBoundary(knob,{left:16,right:16,top:0,bottom:0});	
			up.setAnchor({right:0,top:0,bottom:0,stretchH:16});
			dn.setAnchor({left:0,bottom:0,top:0,stretchH:16});
			this.lyrTrack.setAnchor({top:0,bottom:0,left:16,right:16});
		}
		this._adjustKnob();
		this.renderStyle();
	};
	// renderStyle will act as a function of the DynLayer object
	style.renderStyle = function(act){
		var all=!act;
	
		if(all){ // set other attributes if rendering all areas
			var imgTrack = this.getStyleAttribute('imageTrack');
			var up = (this._bartype=='V')? this.getStyleAttribute('imageDown'):this.getStyleAttribute('imageRight');
			var dn = (this._bartype=='V')? this.getStyleAttribute('imageUp'):this.getStyleAttribute('imageLeft');
			this.btnUp.setCaption(up.getHTML());
			this.btnDown.setCaption(dn.getHTML());
			if(!imgTrack) this.lyrTrack.setBgColor(this.getStyleAttribute('backColor'));	
			else this.lyrTrack.setBgImage(imgTrack.src);
		}
	};
	// removeStyle will act as a function of the DynLayer object
	// style.removeStyle = function(){};
	return style;
}

StyleManager.addStyle('ScrollBar',ScrollBarStyle);
