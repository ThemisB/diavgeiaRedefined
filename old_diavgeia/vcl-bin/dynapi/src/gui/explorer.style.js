/*
	DynAPI Distribution
	ExplorerStyle (Default)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: StyleManager, Explorer
*/

function ExplorerStyle(){
	var style = new Style(); // create basic style object
	style.styleName='ExplorerStyle';
	style.cssLeave = 'ExplorerLeave';
	style.cssRootLeave = 'ExplorerRootLeave';
	style.cssCurrentLeave = 'ExplorerCurrentLeave';	
	style.loadImages = function(){
		// load default images
		if(!this.imageFile) this.imageFile = Styles.getImage('tvw_file.gif',16,16);
		if(!this.imageFoldOpen) this.imageFoldOpen = Styles.getImage('tvw_foldopen.gif',16,16);
		if(!this.imageFoldClose) this.imageFoldClose = Styles.getImage('tvw_foldclose.gif',16,16);
		if(!this.imageLine) this.imageLine = Styles.getImage('tvw_line.gif',15,18);
		if(!this.imageWhite) this.imageWhite = Styles.getImage('tvw_white.gif',15,18);
		if(!this.imageOpen) this.imageOpen = Styles.getImage('tvw_open.gif',15,18);
		if(!this.imageOpenlast) this.imageOpenlast = Styles.getImage('tvw_openlast.gif',15,18);
		if(!this.imageClose) this.imageClose = Styles.getImage('tvw_close.gif',15,18);
		if(!this.imageCloselast) this.imageCloselast = Styles.getImage('tvw_closelast.gif',15,18);
		if(!this.imageNoChildren) this.imageNoChildren = Styles.getImage('tvw_nochildren.gif',15,18);
		if(!this.imageNoChildrenlast) this.imageNoChildrenlast = Styles.getImage('tvw_nochildrenlast.gif',15,18);
	};
	style._adjustSize = function(){
		if(!dynapi.ua.dom) this._OldAdjustSize();
		else if(this._created){
			var w,h,tb;
			tb = document.getElementById(this.id+'Explorer');
			if(tb){
				w = (this._aSzW)? tb.offsetWidth:null;
				h = (this._aSzH)? tb.offsetHeight:null;
				this.setSize(w,h);
			}
		}
	};
	style._buildHTML = function(leave,level,last,lD) {
		var niv = level||0;
		var listaD = lD || new Array();	
		
		//if(leave['_html'+leave.open] && !leave.tree._hTree[leave.id]) return leave['_html'+leave.open];
		
		var tree = leave.tree;
		var iFL = tree.getStyleAttribute('imageFile');
		var iFOp = tree.getStyleAttribute('imageFoldOpen');
		var iFCl = tree.getStyleAttribute('imageFoldClose');
		var iLn = tree.getStyleAttribute('imageLine');
		var iWht = tree.getStyleAttribute('imageWhite');
		var iOp = tree.getStyleAttribute('imageOpen');
		var iOpl = tree.getStyleAttribute('imageOpenlast');
		var iC = tree.getStyleAttribute('imageClose');
		var iCL = tree.getStyleAttribute('imageCloselast');
		var iNC = tree.getStyleAttribute('imageNoChildren');
		var iNCL = tree.getStyleAttribute('imageNoChildrenlast');
		
		var csRLV = tree.getStyleAttribute('cssRootLeave')||'';
		var csCLV = tree.getStyleAttribute('cssCurrentLeave')||'';
		var csLV = tree.getStyleAttribute('cssLeave')||'';
				
		var ret = '<tr><td><img src="'+iWht.src+'" height="1" width="5"></td><td valign="top">';
		for(var i=0;i<(niv-1);i++) ret += '<img src="'+(listaD[i]? iWht.src:iLn.src)+'" width="15" height="18" align=top>';
		if(niv == 0) ret += '';
		else if (leave.children.length==0) ret += '<img src="'+(last? iNCL.src:iNC.src)+'" width="15" height="18" align="top">';
		else {
			if(leave.open) ret += '<a href="javascript:;" onclick="return '+leave.tree+'.fold(\''+leave.id+'\')"><img border=0 src="'+(last? iCL.src:iC.src)+'" width="15" height="18" align=top></a>';
			else ret += '<a href="javascript:;" onclick="return '+leave.tree+'.unfold(\''+leave.id+'\')"><img border="0" src="'+(last? iOpl.src:iOp.src)+'" width="15" height="18" align=top></a>';
		}

		if(niv!=0) {
			var icon = leave.icon||iFCl;
			var icon_sel = leave.icon_sel||iFOp;
			if (leave.open||leave.id == leave.tree.currentPos) ret += '<img src="'+(icon_sel.src)+'" width="16" height="16" align="top">';
			else ret += '<img src="'+(icon.src)+'" width="16" height="16" align="top">';
		} 

		ret += '<a class="'+(niv==0 ? csRLV: (leave.id == tree.currentPos ? (leave.cssSel||csCLV) : (leave.css||csLV))) + '" href="javascript:;" onclick="return '+leave.tree+'.setCurrent(\''+ leave.id +'\')">';

		//while(leave.text.indexOf(' ')>=0) leave.text = leave.text.replace(/\s/,'&nbsp;');
		leave.text = leave.text.replace(/\s/g,'&nbsp;');
		if(niv!=0) ret += '&nbsp;';
		ret += leave.text+'</a></td><td><img src="'+iWht.src+'" height="1" width="25"></td></tr>';

		var q=0;
		listaD[niv-1] = last;
		if((leave.open || niv==0) && leave.children.length!=0) {
			for(var i in leave.children) { 
				q++;
				ret += this._buildHTML(leave.children[i],niv+1,q==leave.count,listaD);
			}
		}

		//leave['_html'+leave.open] = ret;
		return ret;
	};
	// initStyle will act as a function of the DynLayer object
	style.initStyle = function(){
		this._OldAdjustSize = this._adjustSize;
		this._adjustSize = this.style._adjustSize;
		this.setAutoSize(this.w||true,this.h||true);
		if(this._created) this.renderStyle();		
	};	
	// renderStyle will act as a function of the DynLayer object
	style.renderStyle = function(act){
		if(this._created){
			var html = this.style._buildHTML(this.root);
			this.setHTML('<table id="'+this.id+'Explorer" border="0" cellpadding="0" cellspacing="0">'+html+'</table>');
		}
	};
	// removeStyle will act as a function of the DynLayer object
	style.removeStyle = function(){
		this._adjustSize = this._OldAdjustSize;
		this._OldAdjustSize = null;
	};
	
	return style;
};


// Write Default CSS
dynapi.document.writeStyle({
	ExplorerRootLeave		:'font-family: Arial, Helvetica, sans-serif; font-size: 9pt; font-weight: normal; color: #09478C; text-decoration: none;',
	ExplorerCurrentLeave	:'font-family: Arial, Helvetica, sans-serif; font-size: 9pt; font-weight: bold; color: #09478C; text-decoration: none;',
	ExplorerLeave			:'font-family: Arial, Helvetica, sans-serif; font-size: 9pt; font-weight: normal; color: #09478C; text-decoration: none;',
	'ExplorerLeave:hover'	:'font-family: Arial, Helvetica, sans-serif; font-size: 9pt; font-weight: normal; color: #FF0000; text-decoration: none;'
});

// Creates the style once it has been loaded
Styles.addStyle('Explorer',ExplorerStyle);