/*
	DynAPI Distribution
	FileReader Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

	requires: IOElementSync
*/

function FileReader(fn){
	var me =this;
	this._fn = fn;
	this.io = new IOElement(1);
	this.io.activateSyncMode(function(){
		me._fn(me);
	});
};
var p = FileReader.prototype;
p.read = function(url,data){
	var rt = this.io.get(url,data,false);
	return (rt)? rt.value:null;
};