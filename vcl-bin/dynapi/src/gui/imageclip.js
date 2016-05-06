/*	
	DynAPI Distribution
	ImageClip Widget Class by Raymond Irving (http://dyntools.shorturl.com)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	requires: DynLayer
*/

function ImageClip(clipImage,x,y,w,h,color,cols,rows,speed) {

	if (clipImage && clipImage.constructor==Object){
		var args=clipImage; // dictionary input
		clipImage = args.clipImage;
		x = args.x;
		y = args.y;
		w = args.w;
		h = args.h;
		color = args.color;
		cols = args.cols;
		rows = args.rows;
		speed = args.speed;
	}

	this.DynLayer=DynLayer;
	this.DynLayer(null,x,y,w,h,color);

	this.cols=(cols||0);
	this.rows=(rows||0);
	this.speed=(speed||100);
	this.playing==false;
	this.internalLoop=false;

	// create child layer for image
	this.addChild(new DynLayer(null,0,0,this.w*this.cols,this.h*this.rows),'lyrCanvas');

	this.setClipImage(clipImage,cols,rows);
	this.addEventListener(ImageClip.events);
	this.setOverflow('hidden');
};
var p = dynapi.setPrototype('ImageClip','DynLayer');
p.addImage = function(img,col,row) {
	if(!img) return;
	if(!this._imgFrames) this._imgFrames = [''];
	index = ((col*row)>=0)? col*row:this._imgFrames.length;
	this._imgFrames[index] = img;
	if(!this._clipImage && index==1) this.setFrame(1);
};
p.getFrame = function(){
	return this._frame;
};
p.setClipImage=function(clipImage,cols,rows){
	if(!clipImage) return;
	this._clipImage=clipImage;
	clipImage = (clipImage.getHTML)? clipImage.getHTML():'<img height='+this.lyrCanvas.h+' width='+this.lyrCanvas.w+' border=0 src="'+((clipImage.src)? clipImage.src:clipImage)+'">';
	this.setupFrames(cols,rows);
	this.lyrCanvas.setHTML(clipImage);
};
p.setupFrames=function(cols,rows){
	this.cols=cols||this.cols;
	this.rows=rows||this.rows;
	this.lyrCanvas.setSize(this.w*this.cols,this.h*this.rows);
};
p.setSpeed=function(sp){
	this.speed=(sp||this.speed);
};
p.setFrame=function(fn){
	var img,imgs = this._imgFrames;
	if (isNaN(fn)==true) return;
	var icol=Math.floor((fn-1)/this.rows);
	var irow=((fn-1)-(icol*this.rows));
	if (fn<=(this.cols*this.rows) && fn>0){
		this._frame=fn;
		img=(imgs && imgs[fn])? imgs[fn]:null;
		if(img){
			img=(img.getHTML)? img.getHTML():'<img height='+this.lyrCanvas.h+' width='+this.lyrCanvas.w+' border=0 src="'+((img.src)? img.src:img)+'">';
			this.lyrCanvas.setHTML(img);
			this.lyrCanvas.setLocation(0,0);
		}
		else {
			icol=icol*-1;
			irow=irow*-1;
			this.lyrCanvas.setLocation(this.w*icol,this.h*irow);
		}
		this.invokeEvent("framechange");
	}
};
p.setFrameMartix=function(col,row){
	this.setFrame(col*row);
};
p.playAnimation=function(loop,sequence){
	if (this.playing==true) return;
	if (this.internalLoop!=true) {
		if(!sequence) sequence = '1>'+this.cols;
		this.aniseq=sequence.split(',');
		this.doloop=loop;
	}
	this.ls=0;
	this.internalLoop=false;
	this.playing=true;
	this.timerSEQ=0;
	this.playSEQ();
	this.invokeEvent("frameplay");
};
p.stopAnimation=function(){
	if (this.timerSEQ>=0) window.clearTimeout(this.timerSEQ);
	this.playing=false;
	this.invokeEvent("framestop");
};
p.nextSEQ=function() {
	if (this.playing==false) return;
	this.ls++;
	if (this.ls<this.aniseq.length) {
		this.playSEQ();
	}else{
		this.playing=false;
		if (this.doloop) {
			this.internalLoop=true;
			this.playAnimation();
		}
	}
};
p.playSEQ=function(inx) {
	var st,ar,sq;
	if (this.playing==false) return;
	sq=this.aniseq[this.ls];
	//forward
	st=sq.indexOf('>');
	if (st>0) {
		ar=sq.split(">");
		if (inx!=null) inx++;
		else inx=parseInt(ar[0]);
		this.setFrame(inx);
		if (inx>parseInt(ar[1])){
			this.nextSEQ();
			return;
		}else{
			this.timerSEQ=window.setTimeout(this+'.playSEQ('+inx+')',this.speed);
			return;
		}
	}
	//reverse
	st=sq.indexOf("<");
	if (st>0) {
		ar=sq.split("<");
		if (inx!=null) inx--;
		else inx=parseInt(ar[1]);
		this.setFrame(inx);
		if (inx<=parseInt(ar[0])){
			this.nextSEQ();
			return;
		}else{
			this.timerSEQ=window.setTimeout(this+'.playSEQ('+inx+')',this.speed);
			return;
		}
	}
	// sleep
	st=sq.indexOf("p");
	if (st==0) {
		sq=sq.replace("p","");
		this.timerSEQ=window.setTimeout(this+'.nextSEQ();',parseInt(sq));
		return;
	}
	// display single frame
	if (isNaN(sq)==false) {
		if ((sq)>0) this.setFrame(sq);
		this.timerSEQ=window.setTimeout(this+'.nextSEQ();',this.speed);
	}

};

