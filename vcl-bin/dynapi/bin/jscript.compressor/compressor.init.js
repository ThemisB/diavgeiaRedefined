/*
	DynAPI Compiler Beta 1
	Written 2002 by Raymond Irving

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
*/



var jsCLevel='high';
var jsCExclude='';
var jsCLastFile = '';
var jsCLastFileName = '';
var jsCDebug=false;		//@IF:DEBUG directive
var jsCNS4=true;			//@IF:NS4 directive
var jsFileIndex = -1;

var jsCLastUnCompressedSize = 0;
var jsCLastCompressedSize = 0;

// Compiles or Compresses the select dynapi source folder
// When check==true compressor will check dynapi files in source folder for missing semi-colons
function compress(check) {

	var f=document.frmcompressor;
	var source=f.txtsource.value;
	var target=f.txttarget.value;
	
	jsFileIndex = -1;
	jsCCheck = check;
	jsCLevel = (jsCCheck)? 'low':f.cbolevel.value;
	jsCDebug = f.chkdebug.checked;	
	jsCNS4 = f.chkns4.checked;	

	jsCLastUnCompressedSize = 0;
	jsCLastCompressedSize = 0;

	// build exclude list
	jsCExclude='';
	if(f.chkcvs.checked) jsCExclude='CVS';	
	for(var i=0;i<f.chk.length;i++){
		if(!f.chk[i].checked){			
			jsCExclude+=((jsCExclude)? ',':'')+f.chk[i].value;
		}
	}
	
	// check for valid source and target path
	if(!CheckFolder(source)) {
		alert('Invalid Source Path "'+source+'"');
		return;
	}else if(!CheckFolder(target)) {
		alert('Invalid Destination Path "'+target+'"');
		return;
	}
	
	// store javascript files in an array and copy non-javascript files into target
	BuildFileSturcure(source,target,jsCExclude);	

	document.images['bar'].style.width='0%';
	document.images['bar'].style.visibility='visible';
	f.txtstatus.value='Compiling....';
	f.txtsizestatus.value='';
	document.images['bar'].style.width="1%";
	CompressNextFile();
	showScreen(jsCCheck);
};

// CompressNextFile: Compresses one file at a time using the crunch() function (compressor.js)
function CompressNextFile(state,strText){

	var f=document.frmcompressor;
	var i,a,p,srcFile,tarFile,content;
	var totalFiles;

	if(state=='status'){
	
		// Display status from Crunch() functions
		f.txtstatus.value='Compiling ['+jsCLastFileName+'] - '+strText;	
		
	}
	else{
		if (jsCCheck && state=="complete"){
			// Check file for semi-colon errors
			// a much better error checking system is needed here
			var t='',l,exclude='{},;';
			var ar = strText.split('\n');
			for(var i=0;i<ar.length;i++){				
				l=strTrim(ar[i]);
				if (l && l.length){
					ok=false;
					ch=l.substr(l.length-1,1);
					if(ar[i]!='}' && exclude.indexOf(ch)>=0) ok=true					
					if(!ok){
						l=l.replace(/</g,'&lt;');
						l=l.replace(/>/g,'&gt;');
						t+=' Line: '+(i+1)+':   '+l+'<br>'
						+' File: '+jsCLastFile+'<br><br>';					
					}
				}
			}
			if(t){
				var dv=document.all['dvscreen'];
				dv.innerHTML=dv.innerHTML+t+"<hr>";
			}
		}
		if(state=="complete"){
			// Save compressed data
			if(jsCLevel!='none' && (jsCLastFileName+'').toLowerCase()=='dynapi.js') {
				strText='// The DynAPI Distribution is distributed under the terms of the GNU LGPL license.\n'
				+strText;
			}
			jsCLastCompressedSize+=strText.length;
			SaveFile(jsCLastFile,strText);
			f.txtsizestatus.value=' Last size in bytes: Before = '+jsCLastUnCompressedSize+' / After = '+jsCLastCompressedSize+' / '
			+' Diff = '+(jsCLastUnCompressedSize-jsCLastCompressedSize);
		}
		
		// Move to next file
		jsFileIndex+=1;
		totalFiles=GetTotalFiles();
		if(jsFileIndex<=totalFiles){	
		
			// get target and source file
			srcFile=GetSRCFile(jsFileIndex);
			tarFile=jsCLastFile=GetTARFile(jsFileIndex);

			// update status
			p=((jsFileIndex+1)/(totalFiles+1))*100;
			a=jsCLastFile.split('\\');		
			jsCLastFileName=a[a.length-1];
			f.txtstatus.value='Compiling ['+jsCLastFileName+']....';
			document.images['bar'].style.width=p+"%";

			// get file content
			content=OpenFile(srcFile)+'';
			jsCLastUnCompressedSize+=content.length;
			if(content.indexOf('\n')<0) content=content.split("\r"); // MAC
			else content=content.split("\n"); // PC, UNIX			
			content=content.join('<$Link/>');
			if(!jsCDebug){
				// Remove Debug conditional code blocks
				content = RemoveCondition('DEBUG',content);
				content=content.replace(/dynapi\.debug\.print\(/g,'dPrint\(');
			}
			if(!jsCNS4) {
				// Remove NS4 conditinal code blocks   
				content = RemoveCondition('NS4',content);
			}
			content=content.replace(/\<\$Link\/\>/g,'\n');
			
			// Compress the file content 
			Crunch(content,jsCLevel,CompressNextFile);		

		}
		else {
		
			// finished compressing js files
			f.txtstatus.value="Ready";
			document.images['bar'].style.visibility='hidden';
		}
	}
};

// jsCheckFileState: Used by fsobject to check if the file should be copied or compressed
function jsCheckFileState(f,pth){
	var state=0,ignore=false;
	var a,copy=2, compress=1;

	f=f+'';	a=f.split(".");
	
	// check if file is a part of the debug library
	ignore=(!jsCDebug && f.indexOf('debug')==0)
	
	// check if file is a part of the NS4 library
	ignore=(ignore || (!jsCNS4 && f.indexOf('ns4')==0))

	if(!ignore){
		// if .js file the compress otherwise copy the file
		if(a[a.length-1]=="js") state=compress; 
		else state=copy;
	}

	return state;
};

// Remove conditional statements
function RemoveCondition(tag,content) {
	var lines = content.split('//]:'+tag);
	var t = [''];

	// loop through conditional staments
	for (i=0;i<lines.length;i++) {
		if(lines[i].indexOf('//@IF:'+tag+'[')<0) t[t.length] = lines[i];
		else{
			if(tag=='NS4') t[t.length] = lines[i].replace(/\/\/\@IF:NS4\[(.*)$/g,'');
			else if(tag=='DEBUG') t[t.length] = lines[i].replace(/\/\/\@IF:DEBUG\[(.*)$/g,'');
		}
	}
	return t.join('');
}


// Misc functions

function showScreen(b){
	var dv=document.all['dvscreen'];
	dv.innerHTML='';
	dv=document.all['dvscreenrow'];
	if(b) dv.style.display='block';
	else dv.style.display='none';
	
}

function showHideAbout() {
	var dv=document.all['dvabout'];
	if(dv.style.display=='block') dv.style.display='none';
	else dv.style.display='block';
}

function strTrim(s,dir){
	if(!s) return;
	else s+=''; // make sure s is a string
	dir=(dir)? dir:'<>';
	if(dir=='<'||dir=='<>') s=s.replace(/^(\s+)/g,'');
	if(dir=='>'||dir=='<>') s=s.replace(/(\s+)$/g,'');
	return s;
	
};