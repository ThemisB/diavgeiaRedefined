// 2D Graphics Package
// Drawing routines for DynLayer
// Copyright (C) 2000-2001 Dan Steinman, Guoyi Chao, Rob Breeds

// Guoyi Chao: drawing routines for line, circle, ellipse
// Dan Steinman: DynAPI2 support, object wrappers, VML support, improved routines for line, rect, and fills()
// Rob Breeds: improve performance on ellipse and circle algorithms, and added line thicknesses support

// Distributed under the terms of the GNU Library General Public License

function Graphics(dlyr) {
	this._dlyr = dlyr;
	this._s = "yellow";
	this._w = 1;
	this._f = "white";
};
Graphics.prototype.setStrokeColor = function(v) {this._s = v};
Graphics.prototype.setStrokeWeight = function(v) {this._w = v};
Graphics.prototype.setFillColor = function(v) {this._f = v};
Graphics.prototype.drawPixel = function(x,y) {
	drawPixel(x,y,this._s,this._w,this);
};
Graphics.prototype.drawLine = function(x1,y1,x2,y2) {
	var shape;
	if (Graphics.useVML) {
		shape = new VML_Line(x1,y1,x2,y2,this._w,this._s);
		this._dlyr.elm.appendChild(shape.elm);
	}
	else {
		shape = new Line(x1,y1,x2,y2,this._w,this._s);
		this._dlyr.addChild(shape);
	}
	return shape;
};
Graphics.prototype.drawCircle = function(x,y,radius) {
	var shape;
	if (Graphics.useVML) {
		// bug in IE, always fills anyway
		shape = new VML_Oval(x,y,2*radius,2*radius,this._w,this._s, dynapi.ua.ie5?this._dlyr.bgColor:false);
		this._dlyr.elm.appendChild(shape.elm);
	}
	else {
		shape = new Circle(x,y,radius,this._w,this._s);
		this._dlyr.addChild(shape);
	}
	return shape;
};
Graphics.prototype.fillCircle = function(x,y,r) {
	fillCircle(x+r,y+r,r,this._f,this._dlyr);
};
Graphics.prototype.drawEllipse = function(x,y,w,h) {
	drawEllipse(x+w/2,y+h/2,w,h,this._s,false,this._w,this._dlyr);
};
Graphics.prototype.drawOval = Graphics.prototype.drawEllipse;
Graphics.prototype.fillEllipse = function(x,y,w,h) {
	drawEllipse(x+w/2,y+h/2,w,h,this._f,true,this._w,this._dlyr);
};
Graphics.prototype.fillOval = Graphics.prototype.fillEllipse;
Graphics.prototype.drawRect = function(x,y,w,h) {
	drawRect(x,y,w,h,this._s,this._w,this._dlyr);
};
Graphics.prototype.fillRect = function(x,y,w,h) {
	fillRect(x,y,w,h,this._f,this._dlyr);
};
Graphics.prototype.clear = function() {
	this.deleteAllChildren();
	this.setHTML('');
};

Graphics.useVML = false;
if (dynapi.ua.ie && dynapi.ua.v>=5) {  // include active-x component for IE5+
	Graphics.useVML = true;
	var str = '<xml:namespace ns="urn:schemas-microsoft-com:vml" prefix="v"/>'+
		'<object id="VMLRender" codebase="vgx.dll" classid="CLSID:10072CEC-8CC1-11D1-986E-00A0C955B42E"></object>'+
		'<style>'+
		'<!--'+
		'v\\:* { behavior: url(#VMLRender); }'+
		'-->'+
		'</style>';

	if (dynapi.loaded) {
		dynapi.frame.document.body.appendChild('beforeEnd',str);
	}
	else {
		document.write(str);
	}
};

// Drawing Routines

function Pixel(x,y,color,t) {	// not really needed
	this.DynLayer = DynLayer;
	this.DynLayer();
	this.setLocation(x,y);
	this.setSize(t||1,t||1);
	this.setBgColor(color||"black");
};
Pixel.prototype = new DynLayer();

function drawPixel(x,y,color,t,lyr) {
	lyr.addChild( new DynLayer('',Math.round(x),Math.round(y),t,t,color) );
};

function Shape() {
	this.DynLayer = DynLayer;
	this.DynLayer();

	this.setStrokeColor("black");
	this.setStrokeWeight(1);
};
Shape.prototype = new DynLayer();
Shape.prototype.setStrokeColor = function(v) {this._s = v};
Shape.prototype.setStrokeWeight = function(v) {this._w = v};

function Line(x1,y1,x2,y2,w,s) {
	this.Shape = Shape;
	this.Shape();
	this.setStrokeWeight(w);
	this.setStrokeColor(s);

	var dx = Math.min(x1,x2);
	var dy = Math.min(y1,y2);
	var width = Math.abs(x2-x1);
	var height = Math.abs(y2-y1);
	this.setLocation(dx, dy);

	if(x1==x2||y1==y2) {  // straight line
		this.setBgColor(s);
		if(x1==x2) this.setSize(w,height); // vertical
		else this.setSize(width,w);  //horizontal
	}
	else {  // diagonal
		this.setSize(width,height);
		var nx1 = x1-dx;
		var ny1 = y1-dy;
		var nx2 = x2-dx;
		var ny2 = y2-dy;
		drawLine(nx1,ny1,nx2,ny2,s,w,this);
	}
};
Line.prototype = new Shape();

function VMLElement() {
	this.elm = null;
};
VMLElement.prototype.createShape = function(type) {
	this.elm = document.createElement('v:'+type);
};
VMLElement.prototype.setLocation = function() {};

function VML_Line(x1,y1,x2,y2,w,s) {
	this.VMLElement = VMLElement;
	this.VMLElement();

	this.createShape("line");
	this.elm.from = x1+'px ,'+y1+'px';
	this.elm.to = x2+'px ,'+y2+'px';
	this.elm.strokeColor = s;
	this.elm.innerHTML = '<v:stroke weight="'+w+'px">';

	//this.elm.innerHTML = '<v:stroke weight="'+this.thickness+'px" color="'+this.color+'">';
	//"<v:line id='line" + nnode + "' from=" + x1 + "," + y1 +"' to='" + x2 + "," + y2 +"'><v:stroke weight='2px' color='black'/></v:line>";
};
VML_Line.prototype = new VMLElement();

function VML_Oval(x,y,width,height,w,s,fc) {
	this.VMLElement = VMLElement;
	this.VMLElement();

	this.elm = document.createElement('v:oval');
	this.elm.style.position = "absolute";
	this.elm.style.left = x+"px";
	this.elm.style.top = y+"px";
	this.elm.style.width = width+"px";
	this.elm.style.height = height+"px";

	this.elm.strokeColor = s;

	if (fc) {
		this.elm.fillColor = fc;
		this.elm.fill = true;
	}
	else this.elm.fill = false;

	this.elm.innerHTML = '<v:stroke weight="'+w+'px">';
};
VML_Oval.prototype = new VMLElement();

function drawLine(x1,y1,x2,y2,color,t,lyr) {
	var flag = (Math.abs(y2-y1) > Math.abs(x2-x1));
	var dx,dy,x,y,e,xstep,ystep;
	if (flag) dx=Math.abs(y2-y1),dy=Math.abs(x2-x1),x=y1,y=x1;
	else dx=Math.abs(x2-x1),dy=Math.abs(y2-y1),x=x1,y=y1;
	xstep=x1>x2?-1:1;
	ystep=y1>y2?-1:1;
	if(x1==x2||y1==y2) {
		if(x1==x2) {
			var ny1 = Math.min(y1,y2);
			var ny2 = Math.max(y1,y2);
			lyr.addChild( new DynLayer('',x1,ny1,t,(ny2-ny1)*t,color) );
			return;
		}
		else {
			var nx1 = Math.min(x1,x2);
			var nx2 = Math.max(x1,x2);
			lyr.addChild( new DynLayer('',nx1,y1,(nx2-nx1)*t,t,color) );
			return;
		}
	}
	// Bresenham Method Begin
	var e=-dx;
	for(var count=0;count<=dx;count++) {
		if (flag) drawPixel(y,x,color,t,lyr);
		else drawPixel(x,y,color,t,lyr);
		if (flag) x+=ystep;
		else x+=xstep;
		e+=dy<<1;
		if(e>=0) {
			if(flag) y+=xstep;
			else y+=ystep;
			e-=dx<<1;
		}
	}
	return;
};
function Circle(x,y,radius,w,s) {
	this.Shape = Shape;
	this.Shape();
	this.setStrokeWeight(w);
	this.setStrokeColor(s);

	this.setLocation(x,y);
	this.setSize(2*radius, 2*radius);

	drawCircle(0+radius,0+radius,radius-1,this._s,this._w,this);
};

Circle.prototype = new Shape();

function drawCircle(centerX,centerY,radius,color,t,lyr) {
	var x = centerX;
	var y = centerY;
	var cx = 0;
	var cy = radius;
	var df = 1 - radius;
	var d_e = 3;
	var d_se = -(radius<<1) + 5;
	do {
		drawPixel(x+cx, y+cy, color,t,lyr);
		if (cx) drawPixel(x-cx, y+cy, color,t,lyr);
      if (cy) 	drawPixel(x+cx, y-cy, color,t,lyr);
      if ((cx) && (cy)) drawPixel(x-cx, y-cy, color,t,lyr) ;
      if (cx != cy) {
			drawPixel(x+cy, y+cx, color,t,lyr);
			if (cx) drawPixel(x+cy, y-cx, color,t,lyr);
			if (cy) drawPixel(x-cy, y+cx, color,t,lyr);
			if (cx && cy) drawPixel(x-cy, y-cx, color,t,lyr);
      }
      if (df < 0)  {
			df += d_e;
			d_e += 2;
			d_se += 2;
      }
      else {
			df += d_se;
			d_e += 2;
			d_se += 4;
			cy--;
		}
		cx++;
   } while (cx <= cy);
};

function fillCircle(x,y,radius,color,lyr) {
	var cx = 0;
	var cy = radius;
	var df = 1 - radius;
	var d_e = 3;
	var d_se = -(radius<<1) + 5;
	do {
		fillRect(x-cy, y-cx, cy<<1, cx<<1, color,lyr);
	    if (df < 0)  {
			df += d_e;
			d_e += 2;
			d_se += 2;
		}
		else {
			if (cx != cy) fillRect(x-cx, y-cy, cx<<1, cy<<1, color,lyr);
			df += d_se;
			d_e += 2;
			d_se += 4;
			cy--;
		}
		cx++;
	} while (cx <= cy);
}

function drawEllipse(cx,cy,rx,ry,color,filled,t,lyr) {
	var x,y,a2,b2, S, T;
	a2 = rx*rx;
	b2 = ry*ry;
	x = 0;
	y = ry;
	S = a2*(1-2*ry) + 2*b2;
	T = b2 - 2*a2*(2*ry-1);
	symmPaint(cx,cy,x,y,color,filled,t,lyr);
	do {
		if (S<0) {
			S += 2*b2*(2*x+3);
			T += 4*b2*(x+1);
			x++;
		} else if (T<0) {
			S += 2*b2*(2*x+3) - 4*a2*(y-1);
			T += 4*b2*(x+1) - 2*a2*(2*y-3);
			x++;
			y--;
		} else {
			S -= 4*a2*(y-1);
			T -= 2*a2*(2*y-3);
 			y--;
		}
		symmPaint(cx,cy,x,y,color,filled,t,lyr);
	} while (y>0);
}

//Bresenham's algorithm for ellipses
function symmPaint(cx,cy, x, y, color, filled, t, lyr){
	if (filled) {
		fillRect ( cx-x, cy-y, x<<1, y<<1, color, lyr );
	} else {
		drawPixel ( cx-x, cy-y, color, t,lyr );
		drawPixel ( cx+x, cy-y, color, t,lyr );
		drawPixel ( cx-x, cy+y, color, t,lyr );
		drawPixel ( cx+x, cy+y, color, t,lyr );
	}
}

function drawRect(x,y,w,h,color,t,lyr) {
	lyr.addChild( new DynLayer('',x,y,w,t,color) );
	lyr.addChild( new DynLayer('',x,y,t,h,color) );
	lyr.addChild( new DynLayer('',x+w-t,y,t,h,color) );
	lyr.addChild( new DynLayer('',x,y+h-t,w,t,color) );
}

function fillRect(x,y,w,h,color,lyr) {
	lyr.addChild( new DynLayer('',x,y,w,h,color) );
}
