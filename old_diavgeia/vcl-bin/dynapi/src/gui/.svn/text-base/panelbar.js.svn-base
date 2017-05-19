/*	
	DynAPI Distribution
	PanelBar Widget Class by Daniel Tiru (http://www.tiru.se)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	requires: DynLayer
*/

function PanelBar(menu,content,menuheight,x,y,w,h,minimized) {
	this.DynLayer = DynLayer;
	this.DynLayer(null,x,y,w,h,null);
	
	this.x = x;
	this.y = y;
	this.w = w;
	this.h = h;
	this._h = h;
	this._mnuheight = menuheight;
    
    if (typeof(menu)=='string') {
        this._lyrmnu = new DynLayer(menu);
    } else {
        this._lyrmnu = menu;
    }
    if (typeof(content)=='string') {
        this._lyrcnt = new DynLayer(content);
    } else {
        this._lyrcnt = content;
    }

	this._minimized = minimized;
	this._steps = 5;
	this._tmpsteps = 10;
	this._tmpcnt=0;

	
	this.onPreCreate(PanelBar.PreCreateEvent);
}

var p = dynapi.setPrototype('PanelBar','DynLayer');

p.minimize = function() {
	if(this._tmpcnt <= this._tmpsteps-1){
		this._tmpcnt++;
		if (this.h-((this.h/this._tmpsteps)*this._tmpcnt) > this._mnuheight) {
			this.setHeight(this.h-((this.h/this._tmpsteps)*this._tmpcnt));
			window.setTimeout(this+'.minimize()', 20);
		}
		else {
			this.setHeight(this._mnuheight);
			this._tmpcnt=0;
		}
	}
	this.menu.setHTML(this._mnuhtml.replace('{@min}',this._mnuhtmlmax));
	this._minimized=true;
}

p.maximize = function() {
	if(this._tmpcnt <= this._tmpsteps-1){
		this._tmpcnt++;
		if ((this._h/this._tmpsteps)*this._tmpcnt>this._mnuheight) {
			this.setHeight((this._h/this._tmpsteps)*this._tmpcnt);
		}
		window.setTimeout(this+'.maximize()', 20);
	}
	else {
		this._tmpcnt=0;
	}
	this.menu.setHTML(this._mnuhtml.replace('{@min}',this._mnuhtmlmin));
	this._minimized=false;
}

p.setDraging = function(bol) {
	if (bol) {
		DragEvent.enableDragEvents(this);
		this.content.addEventListener({
			onmousedown:function(e){
				e.preventBubble();
			}
		});
	}
	else {
		DragEvent.disableDragEvents(this);
	}
}

p.setMinMaxImg = function(imgmin,imgmax) {
    
	if (imgmin!=null&&imgmax!=null) {
		this._mnuhtmlmin = replacestr='<a style=\'cursor:hand;\' onclick=\''+this+'.minimize();\'>'+imgmin.getHTML()+'</a>';
		this._mnuhtmlmax = replacestr='<a style=\'cursor:hand;\' onclick=\''+this+'.maximize();\'>'+imgmax.getHTML()+'</a>';
		if (this.menu) {
    		if (this._minimized) {
    			this.menu.setHTML(this._mnuhtml.replace('{@min}',this._mnuhtmlmax));
    		}
    		else {
    			this.menu.setHTML(this._mnuhtml.replace('{@min}',this._mnuhtmlmin));
    		}
    	}
	}
}

p.getMenuLayer = function() {
    return this._lyrmnu || this.menu;
}

p.getContentLayer = function() {
    return this._lyrcnt || this.content;
}

PanelBar.PreCreateEvent = function(e) {

	this.menu = this.addChild(this._lyrmnu);
	this.menu.setX(0);
	this.menu.setY(0);
	this.menu.setWidth(this.w);
	this.menu.setHeight(this._mnuheight);

	if (!this._mnuhtml) {
	    this._mnuhtml = this.menu.getHTML();
	}
	if (!this._mnuhtmlmin || !this._mnuhtmlmax) {
	    this._mnuhtmlmin = replacestr='<a style=\'cursor:hand;\' onclick=\''+this+'.minimize();\'>min</a>';
    	this._mnuhtmlmax = replacestr='<a style=\'cursor:hand;\' onclick=\''+this+'.maximize();\'>max</a>';
	}
  	this.menu.setHTML(this._mnuhtml.replace('{@min}',this._mnuhtmlmin));
	
	this.content = this.addChild(this._lyrcnt);
	this.content.setX(0);
	this.content.setY(this._mnuheight);
	this.content.setWidth(this.w);
	this.content.setHeight(this.h-this._mnuheight);
	if (this._minimized) {
		this.setHeight(this._mnuheight);
		this.menu.setHTML(this._mnuhtml.replace('{@min}',this._mnuhtmlmax));
	}

};
