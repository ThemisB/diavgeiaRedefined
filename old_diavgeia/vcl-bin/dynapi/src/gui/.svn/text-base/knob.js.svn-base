/*
   DynAPI Distribution
   Knob Component by Raymond Irving (http://dyntools.shorturl.com)

   The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

   Requires: StyleManager, KnobStyle (Optional)
*/

function Knob(x,y,w,h,style){
	this.DynLayer = DynLayer;
	this.DynLayer(null,x,y,w,h);
	
	DragEvent.enableDragEvents(this);
	DragEvent.setDragBoundary(this);
	
	this.setTextSelectable(false);
	this.setStyle(style||'Knob');
};
p = dynapi.setPrototype('Knob','DynLayer');
// Private
p.KnbOldSetSize = DynLayer.prototype.setSize;
// Public
p.setSize = function(w,h){
	this.KnbOldSetSize(w,h);
	this.renderStyle('resize');
};
