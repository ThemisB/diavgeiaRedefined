/*
	DynAPI Distribution
	Stacker Class
	
	Created by Daniel Tiru (http://www.tiru.se)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
*/

function Stacker(){
	this.objects=[];
	this.intSpace=5;
	this.alignment='v';
};
var p = Stacker.prototype;

p.add=function(src){
	this.objects[this.objects.length]=src;
	me = this;
	src.addEventListener({
		onresize:function(e){
			me.generate();
		}
	});
	this.generate();
};

p.toString=function() {
	return this.objects;
};

p.remove=function(src){
	var i;
	for (i = 0; i < this.objects.length; i++) {
		if (src == this.objects[i]) {
			this.objects.splice(i,1);
			if (this.objects.length>0) {
				this.firstObject=this.objects[0];
			}
			else {
				this.firstObject=null;
			}
		}
	}
};

p.setSpace = function(inint) {
	this.intSpace = inint;
};

p.getSpace = function() {
	return this.intSpace;
};

p.setAlignment = function(instr) {
	if (instr=='h') {
		this.alignment='h';
	}
	else {
		this.alignment='v';
	}
};

p.setPosition = function(x,y) {
	if (x!=null &&y!=null) {
		this.x=x;
		this.y=y;
		if (!this.firstObject&&this.objects.length!=0) {
			this.firstObject=this.objects[0];
			this.firstObject.setX(this.x);
			this.firstObject.setY(this.y);
		}
	}
};

p.getX = function() {
	return this.x;
};

p.getY = function() {
	return this.y;
};

p.getFirstObject = function() {
	return this.firstObject;
};

p.move = function(src,pos) {
	var i;
	if (src!=null&&pos!=null) {
		for (i = 0; i < this.objects.length; i++) {
			if (src == this.objects[i]) {
				tmpPosFrom = i;
				tmpPosDest = tmpPosFrom+pos;
			}
		}
		if (tmpPosDest!=null) {
			if (tmpPosDest>=0&&tmpPosDest<=this.objects.length) {
				this.objects[tmpPosFrom] = this.objects[tmpPosDest];
				this.objects[tmpPosDest] = src;
				if (this.objects.length!=0&&this.y!=null&&this.x!=null) {
					this.firstObject=this.objects[0];
					this.firstObject.setX(this.x);
					this.firstObject.setY(this.y);
				}
			}
		}
	}
};

p.generate = function() {
	var i;
	if (!this.firstObject&&this.objects.length!=0&&this.y!=null&&this.x!=null) {
			this.firstObject=this.objects[0];
			this.firstObject.setX(this.x);
			this.firstObject.setY(this.y);
	}
	if (this.alignment=='v') {
		for (i = 1; i < this.objects.length; i++)
		{
			this.objects[i].setY(this.objects[i-1].getY()+this.objects[i-1].getHeight()+this.intSpace);
			this.objects[i].setX(this.objects[i-1].getX());
		}
	}
	else {
		for (i = 1; i < this.objects.length; i++)
		{
			this.objects[i].setX(this.objects[i-1].getX()+this.objects[i-1].getWidth()+this.intSpace);
			this.objects[i].setY(this.objects[i-1].getY());
		}
	}
};