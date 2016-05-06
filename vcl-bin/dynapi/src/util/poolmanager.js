/*
	DynAPI Distribution
	PoolManager Class by Raymond Irving (http://dyntools.shorturl.com)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Note: pObj (Parent Object) must implement _CreatePoolObject() and _ResetPoolObject() functions
	
*/

function PoolManager(pObj){
	this._pool={};
	this._cnt=0;
	this._pobj=pObj;
};
var p = PoolManager.prototype;
p.getObject=function(){
	var o,ob;
	// check pool for free object
	for(o in this._pool) {
		ob=this._pool[o];
		this._pool[o] = null;
		delete this._pool[o];
		return ob;
	}
	// call parent object to create new object
	if(this._pobj._CreatePoolObject){
		return this._pobj._CreatePoolObject();
	}
};
p.storeObject=function(o){
	this._cnt++;
	// reset object via _ResetPoolObject
	o=this._pobj._ResetPoolObject(o);
	this._pool['S'+this._cnt]=o;
};
