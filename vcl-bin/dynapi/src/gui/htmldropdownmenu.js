/*
	DynAPI Distribution
	HTMLDropDownMenu Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: HTMLListbox
*/

function HTMLDropDownMenu(css,items,title,elmName){
	this.HTMLListbox = HTMLListbox;
	this.HTMLListbox(css,items,null,false,title);
	
	this._elmId = elmName||(this.id+'DDM');
	this._defEvtResponse = true;

};
var p = dynapi.setPrototype('HTMLDropDownMenu','HTMLListbox');
// Methods
p.getInnerHTML = function(){
	var evt;
	evt = this._generateInlineEvents(this);
	return '<select class="'+this._class+'" id="'+this._elmId+'" name="'+this._elmId+'" size="1"'
	+evt+' title="'+this._title+'">'+this._buildOptions()+'</select>';
};
