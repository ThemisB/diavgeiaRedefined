/*
	DynAPI Distribution
	ExplorerBlockStyle

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: StyleManager, Explorer, ExplorerStyle
*/

function ExplorerBlockStyle(){
	var style = ExplorerStyle(); // inherits or extends ExplorerStyle object
	style.styleName='ExplorerBlockStyle';
	style.loadImages = function(){
		// load default images
		if(!this.imageFile) this.imageFile = Styles.getImage('tvw_file.gif',16,16);
		if(!this.imageFoldOpen) this.imageFoldOpen = Styles.getImage('tvw_foldopen.gif',16,16);
		if(!this.imageFoldClose) this.imageFoldClose = Styles.getImage('tvw_foldclose.gif',16,16);
		if(!this.imageWhite) this.imageWhite = Styles.getImage('tvw_white.gif',15,18);
		if(!this.imageExpand) this.imageExpand = Styles.getImage('tvw_expand.gif',15,18);
		if(!this.imageCollapse) this.imageCollapse= Styles.getImage('tvw_collapse.gif',15,18);
	};
	style._buildHTML = function(leave,level,last,lD) {
		var niv = level||0;
		var listaD = lD || new Array();	
		
		var tree = leave.tree;
		var iFL = tree.getStyleAttribute('imageFile');
		var iFOp = tree.getStyleAttribute('imageFoldOpen');
		var iFCl = tree.getStyleAttribute('imageFoldClose');
		var iWht = tree.getStyleAttribute('imageWhite');
		var iEx = tree.getStyleAttribute('imageExpand');
		var iCx = tree.getStyleAttribute('imageCollapse');

		var csLV = tree.getStyleAttribute('cssLeave')||'';
		var csRLV = tree.getStyleAttribute('cssRootLeave')||'';
		var csCLV = tree.getStyleAttribute('cssCurrentLeave')||'';

		var ret = '<tr><td><img src="'+iWht.src+'" height="1" width="5"></td><td valign="top">';
		ret+='<table border="0" cellspacing="0" cellpadding="0"><tr><td valign="top">';
		if((niv-1)>=1)ret += '<img src="'+iWht.src+'" width="'+(15*(niv-1))+'" height="18" align=top>';
		if(niv == 0) ret += '';
		else if (leave.children.length==0) ret += '<img src="'+iWht.src+'" width="15" height="18" align="top">';
		else {
			if(leave.open) ret += '<a href="javascript:;" onclick="return '+leave.tree+'.fold(\''+leave.id+'\')"><img border=0 src="'+iCx.src+'" width="15" height="18" align=top></a>';
			else ret += '<a href="javascript:;" onclick="return '+leave.tree+'.unfold(\''+leave.id+'\')"><img border="0" src="'+iEx.src+'" width="15" height="18" align=top></a>';
		}

		if(niv!=0) {
			var icon = leave.icon||iFCl;
			var icon_sel = leave.icon_sel||iFOp;
			if (leave.open||leave.id == leave.tree.currentPos) ret += '<img src="'+(icon_sel.src)+'" width="16" height="16" align="top">';
			else ret += '<img src="'+(icon.src)+'" width="16" height="16" align="top">';
		} 
		ret += '</td><td valign="top" nowrap><a class="'+(niv==0 ? csRLV: (leave.id == tree.currentPos ? (leave.cssSel||csCLV) : (leave.css||csLV))) + '" href="javascript:;" onclick="return '+leave.tree+'.setCurrent(\''+ leave.id +'\')">';

		if(niv!=0) ret += '&nbsp;';
		ret += leave.text+'</a></td></tr></table>'
		ret+='</td><td><img src="'+iWht.src+'" height="1" width="25"></td></tr>';

		var q=0;
		listaD[niv-1] = last;
		if((leave.open || niv==0) && leave.children.length!=0) {
			for(var i in leave.children) { 
				q++;
				ret += this._buildHTML(leave.children[i],niv+1,q==leave.count,listaD);
			}
		}		
		return ret;
	};
	
	return style;
};

// Creates the style once it has been loaded
Styles.addStyle('ExplorerBlock',ExplorerBlockStyle);