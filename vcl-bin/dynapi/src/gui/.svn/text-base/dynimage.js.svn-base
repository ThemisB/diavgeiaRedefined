/*
	DynAPI Distribution
	DynImage Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
*/

function DynImage(img,id,alt) {
	this.img = img;
	this.id = id;
	this.alt = alt;
};
DynImage.prototype.toString = function() { 
	return "<img src=\""+this.img.src+"\""+
		(this.id?" id=\""+this.id+"\"":"")+
		(this.img.width?" width=\""+this.img.width+"\"":"")+
		(this.img.height?" height=\""+this.img.height+"\"":"")+
		(this.alt?" alt=\""+this.alt+"\"":"")+">"; 
};
DynImage.image = [];
DynImage.getImage = function(src,w,h) {
	for (var i=0;i<DynImage.image.length;i++) {
		if (DynImage.image[i].img.src==src) return DynImage.image[i].img;
	}
	var index = DynImage.image.length;
	DynImage.image[index] = {};
	if (w&&h) {
		DynImage.image[index].img = new Image(w,h);
		DynImage.image[index].img.w = w;
		DynImage.image[index].img.h = h;
	}
	else DynImage.image[index].img = new Image();
	DynImage.image[index].img.src = src;
	if (!DynImage.timerId) DynImage.timerId=setTimeout('DynImage.loadercheck()',50);
	return DynImage.image[index].img;
};

DynImage.loadercheck=function() {
	DynImage.ItemsDone=0;
	var max = DynImage.image.length;
	var dimg = null;
	for (var i=0; i<max; i++) {
		dimg = DynImage.image[i];
		if (dimg.img.complete) {
			DynImage.ItemsDone+=1;
			if (dimg.img.w) dimg.img.width = dimg.img.w;
			if (dimg.img.h) dimg.img.height = dimg.img.h;
		}
	}
	if (DynImage.ItemsDone<max) DynImage.timerId=setTimeout('DynImage.loadercheck()',25);
	else DynImage.timerId=null;
};
dynapi.onLoad(DynImage.loaderStart);

