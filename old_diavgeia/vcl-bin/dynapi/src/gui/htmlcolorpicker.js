/*
	DynAPI Distribution
	HTMLColorPicker Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: HTMLMenu
*/

function HTMLColorPicker(css,text,w,h){
	this.HTMLMenu = HTMLMenu;
	this.HTMLMenu(null);

	this._defEvtResponse = true;
	this._mBar = this.createMenuBar('cpMain',w||30,h||20);
	this._mBar.addItem(css,text,'cpCol');
		w = 240;
		h = (dynapi.ua.ns4)? 50:121;
		this._mBarCol = this.createMenuBar('cpCol',w,h,0,0);
		this._mBarCol.addItem(css||'HCCPick',{contMode:true,text:this._getColorTable()},null,null,null,null,'#EFEBD7','#EFEBD7');
};
var p = dynapi.setPrototype('HTMLColorPicker','HTMLMenu');
// Design Properties
p.backCol = '#EFEBD7';
// Methods
p._chngCol = function(c){
	var mnu = this._menu[0][1];
	mnu.backCol = mnu.selBgCol = c;
	mnu = this._menu[1][1];
	this._col = mnu.backCol = mnu.selBgCol = c;
	if(dynapi.ua.ns4) this._showOnly(0);
	return false;
}
p._getColorTable = function(){
	var color;
	var red,reds=(dynapi.ua.ns4)?['00','66','CC','FF']:['00','22','33','66','77','88','99','BB','CC','DD','EE','FF'];
	var green,greens=['00','66','CC','FF'];
	var blue,blues=['00','66','CC','FF'];
	var table=['<table border="0" bgcolor="#000000" cellspacing="1" cellpadding="1">\n'];
	// Loop through reds
	for (var red=0;red<reds.length;red++){
		table[table.length]='<tr>\n';
		// Loop through greens
		for(green=0;green<greens.length;green++){
			// Loop through blues
			for(blue=0;blue<blues.length;blue++){
				color = "#" + reds[red] + greens[green] + blues[blue]
				table[table.length]='<td bgcolor="' + color + '"><a href="javascript:;" onclick="return '+this+'._chngCol(\''+color+'\');"><font face="arial" size="2" color="'+color+'">##</font></a></td>\n';
			}
		}
		table[table.length]='</tr>\n';
	}
	table[table.length]='</table>\n';	
	table = table.join('');
	if(dynapi.ua.ns4) table ='<table bgcolor="#000000" cellspacing="0" cellpadding="0" border="0" ><tr><td>'+table+'</td></tr></table>';
	return table
};
p.getColor = function(){
	return this._col; 
};
p.setColor = function(c){
	this._chngCol(c);
};

// Write Style to browser
HTMLComponent.writeStyle({
	HCCPick: 		'border: 1px solid #C0C0C0'
});
