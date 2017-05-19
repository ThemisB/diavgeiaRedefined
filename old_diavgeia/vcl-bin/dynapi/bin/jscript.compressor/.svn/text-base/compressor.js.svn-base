//*****************************************************************************
// Do not remove this notice.
//
// Copyright 2001 by Mike Hall.
// See http://www.brainjar.com for terms of use.
//*****************************************************************************


// Modified to support DynAPI Compressor 20-Nov-2002

var literalStrings;  // For temporary storage of literal strings.

function Crunch(jsCode,level,callback) {
	var i, jsTextOut;

	Crunch._level = level;
	Crunch._textOut = jsCode;
	Crunch._callBack = callback;
	Crunch._startCruncher();

};

Crunch._textOut='';
Crunch._textIn='';
Crunch._startCruncher=function(){	
	this._setStatus('Replacing literal strings... ');
	if(this._level=='none') window.setTimeout('Crunch._makeCallBack()',100);
	else {
		window.setTimeout('Crunch._replaceLiteralStrings()',100);  
  	}
};
Crunch._makeCallBack = function(){
	if(this._callBack) this._callBack('complete',this._textOut);
};
Crunch._setStatus=function(t){
	if(this._callBack) this._callBack('status',t);
};
Crunch._replaceLiteralStrings = function() {
	var s=this._textOut;
	var i, c, t, lines, escaped, quoteChar, inQuote, literal;

	literalStrings = new Array();
	t = "";

	// Split script into individual lines.
	lines = s.split("\n");
	
	for (i = 0; i < lines.length; i++) {
		j = 0;
		inQuote = false;
		while (j <= lines[i].length) {
			c = lines[i].charAt(j);

			// If not already in a string, look for the start of one.
			if (!inQuote) {
				if (c == '"' || c == "'") {
					inQuote = true;
					escaped = false;
					quoteChar = c;
					literal = c;
				} else {
					t += c;
				}
			}
			// Already in a string, look for end and copy characters.
			else {
				if (c == quoteChar && !escaped) {
					inQuote = false;
					literal += quoteChar;
					t += "__" + literalStrings.length + "__";
					literalStrings[literalStrings.length] = literal;
				} else if (c == "\\" && !escaped) {
					escaped = true;
				} else {
          			escaped = false;
          		}
				literal += c;
			}
			j++;
		}
		t += "\n";
	}

	// Save text and run next function
	this._textOut=t;
	this._setStatus('Removing comments...');
	window.setTimeout('Crunch._removeComments()',100);
}

Crunch._removeComments = function() {
	var s=this._textOut;
	var lines, i, t;

	// Remove '//' comments from each line.
	lines = s.split("\n");
	t = [''];
	for (i = 0; i < lines.length; i++){
		if(lines[i].indexOf('//')<0) t[t.length] = lines[i];
		else{
			t[t.length] = lines[i].replace(/([^\x2f]*)\x2f\x2f.*$/, "$1");
		}
	}

	t=(this._level=='low')? t.join('<$Link/>'):t.join('');

	// Replace newline characters with spaces.
	//t = t.replace(/(.*)\n(.*)/g, "$1 $2");

	// Remove '/* ... */' comments.
	lines = t.split("*/");
	t = [''];
	for (i = 0; i < lines.length; i++) {
		if(lines[i].indexOf('/*')<0) t[t.length] = lines[i];
		else{
			t[t.length] = lines[i].replace(/(.*)\x2f\x2a(.*)$/g, "$1 ");
		}
	}
	
	t=t.join('');
	if (this._level=='low') t=t.replace(/\<\$Link\/\>/g,'\n');
	
	// Save text and run next function
	this._textOut=t;
	if(this._level=='low'){
		this._setStatus('Combining literal strings...');
		window.setTimeout('Crunch._combineLiteralStrings()',100);	
	}else {
		this._setStatus('Compressing white space...');
		window.setTimeout('Crunch._compressWhiteSpace()',100);	
	}

};
Crunch._compressWhiteSpace = function() {
	var s=this._textOut;
	
	// Condense white space.
	s = s.replace(/\s+/g, " ");
	s = s.replace(/^\s(.*)/, "$1");
	s = s.replace(/(.*)\s$/, "$1");

	// Remove uneccessary white space around operators, braces and parentices.
	s = s.replace(/\s([\x21\x25\x26\x28\x29\x2a\x2b\x2c\x2d\x2f\x3a\x3b\x3c\x3d\x3e\x3f\x5b\x5d\x5c\x7b\x7c\x7d\x7e])/g, "$1");
	s = s.replace(/([\x21\x25\x26\x28\x29\x2a\x2b\x2c\x2d\x2f\x3a\x3b\x3c\x3d\x3e\x3f\x5b\x5d\x5c\x7b\x7c\x7d\x7e])\s/g, "$1");

	// Save text and run next function
	this._textOut=s;
	this._setStatus('Combining literal strings...');
	window.setTimeout('Crunch._combineLiteralStrings()',100);
    	
};
Crunch._combineLiteralStrings = function() {
	var s=this._textOut;
	var i;
	s = s.replace(/"\+"/g, "");
	s = s.replace(/'\+'/g, "");

	// Save text and run next function
	this._textOut=s;
	this._setStatus('Restoring literal strings...');
    window.setTimeout('Crunch._restoreLiteralStrings()',100);

};
Crunch._restoreLiteralStrings = function() {
	var s=this._textOut;
	
	// modified: replace new RegExp("__" + i + "__") with "__" + i + "__"
	var i;
	for (i = 0; i < literalStrings.length; i++) {
		s = s.replace("__" + i + "__", literalStrings[i]);
	}
	
	// Save text and run next function
	this._textOut=s;
	this._setStatus('done.');
    window.setTimeout('Crunch._makeCallBack()',100);
};