/*
	DynAPI Distribution
	StringBuffer Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

*/

function StringBuffer(){
	this.buffer=[];
};
var p = StringBuffer.prototype;
p.add=function(src){
	this.buffer[this.buffer.length]=src;
};
p.flush=function(){
	this.buffer.length=0;
};
p.getLength=function(){
	return this.buffer.join('').length;
};
p.toString=function(delim){
	return this.buffer.join(delim||'');
};

// More features can be added such as indexOf(), charAt(), etc
