/*
	DynAPI Distribution
	DataSource Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

	requires: dynapi.util.IOElement
*/

DataSource = function(url,method,ioelement){
	
	this.EventObject=EventObject;
	this.EventObject();
	
	this.clsid=dynapi.functions.getGUID();
	DataSource.all[this.clsid]=this;
	
	this.src=null;	
	this.dataobjects={};
	
	this._resetProperties();

	this.setSource(url,method,ioelement);
};

/* Prototype */
var p = dynapi.setPrototype('DataSource','EventObject');

// Private Methods
p._boundObject = function(o,f){
	if(!f || !o) return;
	if(!o._clsid) o._clsid=DataSource.increment();
	this.dataobjects[o._clsid]=f;
	o.__iDataSource=this;
	DataSource.allDataObjects[o._clsid]=o;
};
p._fieldManager = function(mode,fld,value){
	var i,rt,con,fldname;
	// set or get field values from local recordset or bound object
	if(mode=='GET' && !this._modRec && this.record) return this.record[fld];
	else {
		if(mode=='SET' && this.record) this.record[fld]=value;	
		for(i in this.dataobjects){
			if (!fld||fld==this.dataobjects[i]){
				fldname=this.dataobjects[i];
				con=DataSource.allDataObjects[i];
				if(con) {
					if(mode=='SET' && con._setDSValue) {
						con._setDSValue(value,fldname);
					}else if(mode=='GET' && con._getDSValue) {
						return con._getDSValue();
					}

				}
			}
		}	
	}
};
p._resetProperties=function(){
	this.record=null;
	this.recordSet=[];
	this.rowCount=0;			// total records
	this.rowIndex=-1;			// current record index(0 to rowCount)
	this.pageSize=1;			// number of recordSet per page
	this.pageCount=0;			// total pages
	this.pageNumber=0;			// current page number (1 to pageCount)
	this.pageRIS=-1;			// starting index for a page
	this.pageRIE=-1;			// ending index for a page
	this.isConnected=false;
};
p._send = function(act,data,params){
	var r,fn,cargo={id:this.clsid,action:act,data:data};;
	params =(params)? params:{};
	if(!this.src||!this.isConnected) {
		this.invokeEvent('alert',null,'DataSource: Connection failed.');
		return;
	}
	this.invokeEvent('request');
	if(this.webservice && !this.wsSync) {
		// Web Service - Async
		fn=DataSource.fnSODAResponse;
		if(this._ticket) this.ioelement.cancel(this._ticket); // cancel any previous requests
		if(act=='fetchpage') this._ticket=this.webservice.call(act,[this.pageNumber,this.pageSize,params.pageType],fn,cargo);
		else this._ticket=this.webservice.call(act,[this.rowIndex,data],fn,cargo);
	}
	else if(this.webservice && this.wsSync) {
		// Web Service - Sync
		if(act=='fetchpage') r=this.webservice.call(act,[this.pageNumber,this.pageSize,params.pageType],false);
		else r=this.webservice.call(act,[this.rowIndex,data],false);
		if(r.error) this.invokeEvent('alert',null,'DataSource: '+r.error.text);
		else {
			data=r.value;
			if(!data) return;
			DataSource.fnProcessResponse(cargo,data);
		}
	}
	else {
		// HTTP GET & POST - Async
		fn=DataSource.fnGETPOSTResponse;		
		data=(data)? data:{};
		data.dataAction = act;
		if(act!='fetchpage') data.dataRowIndex=this.rowIndex;
		else {
			data.pageSize = this.pageSize;
			data.pageNumber = this.pageNumber;
			data.pageType=params.pageType;
		}
		if(this._ticket) this.ioelement.cancel(this._ticket); // cancel any previous requests
		if(this.method=='get') this._ticket=this.ioelement.get(this.src,data,fn,cargo);
		else this._ticket=this.ioelement.post(this.src,data,fn,cargo);
	}
};
p._unboundObject = function(o){
	if(!o._clsid) return;
	delete this.dataobjects[o._clsid];
	delete DataSource.allDataObjects[o._clsid];
};


// Public Methods -------------------------------

p.addRecord = function(){
	this._modRec=true;
	this._oldRowIndex=this.rowIndex;
	this._send('addrow');
};
p.cancelAction = function(norefresh){
	if (this._cancelAct=='waiting') this._cancelAct=true; // cancel submit()
	else {
		// cancel either editRecord() or addRecord() operation
		this._cancelAct=true;
		if (this._modRec && this._oldRowIndex!=this.rowIndex) this.rowIndex=this._oldRowIndex;
		this._oldRowIndex=null;
		this._modRec=false;
		if(!norefresh) this.refresh();
	}
};
p.connect = function(fn,useWebService,useSync,uid,pwd){ // connects to the data source using the SODA web service
	this.ws_uid=uid; this.ws_pwd=pwd;
	this.wsSync=useSync;
	this._resetProperties();
	if(!useWebService) {
		if(typeof(fn)!='function') return;
		this.isConnected=true;
		fn(this,true);
	}else if(IOElement.SODA){
		this._callback=fn;
		if(typeof(useWebService)=='string') {			
			// use an existing web service
			var s,et;
			this.webservice=this.ioelement[useWebService];
			if (this.webservice && this.webservice.isConnected) {
				this.isConnected=true;
				s=true; et='';
			}else{
				this.webservice=null;
				s=false; et='Service not found';
			}
			this._callback(this,s,et);
		}else{
			// create a new web service
			var me=this;		
			var cbFn=function(ws,s,et){
				if(s==true) {
					me.webservice=ws;
					me.isConnected=true;
				}
				// notify caller of connection
				me._callback(me,s,et);
			}
			this.ioelement.createWebService(this.clsid,this.src,cbFn,useSync,uid,pwd,this.method);
		}
	}
};
p.deleteRecord=function(){
	this._send('deleterow');
};
p.editRecord = function(){
	if(this._modRec) return;
	this._modRec=true;
	this._oldRowIndex=this.rowIndex;
};
p.getField = function(fld){return this._fieldManager('GET',fld)};
p.getAbsolutePage = function() {return this.pageNumber};
p.getRecordPosition = function(){return this.rowIndex};
p.getPageCount = function() {return this.pageCount};
p.getPageSize = function() {return this.pageSize};
p.getPageStart = function(){return this.pageRIS};
p.getPageEnd = function(){return this.pageRIE};
p.getRecordCount = function(){return this.rowCount};
p.getRecord = function(n){
	var i, data={};
	if(!this._modRec || (n!=null && n!=this.rowIndex)) data=(n==null)?this.record:this.recordSet[n];
	else {
		for (i in this.dataobjects){
			f=this.dataobjects[i];
			con=DataSource.allDataObjects[i];
			data[f]=con._getDSValue();
		}
	}
	return data;
};
p.isEditMode = function(){return this._modRec};
p.moveFirst = function(){
	if(this._modRec) this.cancelAction(true);
	if(this.pageSize<=1) this._send('movefirst');
	else{
		var r,cp=this.pageNumber; //current page
		var fetch=(cp!=1 || !this.recordSet.length);
		this.rowIndex=0;		
		this.pageNumber=1;
		if (fetch) this._send('fetchpage',null,{pageType:'firstpage'});
		else {
			r=this.recordSet[0];
			this.setRecord(r);
		}
	}
};
p.moveLast = function(){
	if(this._modRec) this.cancelAction(true);
	if(this.pageSize<=1) this._send('movelast');
	else{
		var cp=this.pageNumber;		//current page
		var lp=this.pageCount;	// last page
		var fetch=(lp!=cp || !this.recordSet.length);
		this.pageNumber=lp;
		this.rowIndex=this.rowCount-1;
		if (fetch) {
			this.rowIndex=-2;	// force rowIndex to be set to pageRIE
			this._send('fetchpage',null,{pageType:'lastpage'});
		}else {
			r=this.recordSet[this.rowIndex];
			this.setRecord(r);
		}
	}
};
p.moveNext = function(){
	if(this._modRec) this.cancelAction(true);
	this._modRec=false;
	if(this.pageSize<=1) this._send('movenext');
	else{
		var ps,cp,np,fetch;
		var r=(this.rowIndex+1);
		ps=this.pageSize;
		cp=this.pageNumber; //current page
		if(r<1) np=1;		// new page
		else np=this.pageNumber=parseInt(r/ps)+1; 
		fetch=(np!=cp || np>this.pageCount || !this.recordSet.length);
		if(r>=this.rowCount) {r=this.rowCount-1; fetch=true;}
		this.rowIndex=r;
		if (fetch) this._send('fetchpage',null,{pageType:'normalpage'});
		else {
			r=this.recordSet[r];
			this.setRecord(r);
		}
	}
};
p.movePrev = function(){
	if(this._modRec) this.cancelAction(true);
	if(this.pageSize<=1) this._send('moveprev');
	else{
		var ps,cp,np,fetch;
		var r=(this.rowIndex-1);
		ps=this.pageSize;
		cp=this.pageNumber; //current page
		if(r<1) np=1;	// new page
		else np=this.pageNumber=parseInt(r/ps)+1;
		fetch=(np!=cp || np<1 || !this.recordSet.length);
		if(r<0) {r=0; fetch=true;}
		this.rowIndex=r;
		if (fetch) this._send('fetchpage',null,{pageType:'normalpage'});
		else {
			r=this.recordSet[r];
			this.setRecord(r);
		}
	}
};
p.retry = function() {
	if(this._ticket) this.ioelement.retry(this._ticket);
	else if(!this.isConnected) this.ioelement.retry();
};
p.refresh = function(fld){
	var record=this.record;
	if(!fld||!record) this.setRecordPosition(this.rowIndex);
	else if(record){ 
		// refresh field from local cached data record
		this._fieldManager('SET',fld,record[fld]);
	}
};
p.setAbsolutePage = function(n) {
	var cp=this.pageNumber;
	var np=parseInt(n);	
	if(np>0 && np!=cp) {
		this.rowIndex=-1; // force rowIndex to be set on the new page
		this.pageNumber=np;
		this._send('fetchpage');
	}
};
p.setField = function(fld,value){
	this._fieldManager('SET',fld,value);
};
p.setPageSize = function(n) {
	this.pageSize=parseInt(n);
	if(this.pageSize<1) this.pageSize=1;
	this.pageNumber=0; // this will force moveFirst() to reload page
	this.moveFirst();
};
p.setRecord = function(data){
	var vl,con,i,fld;
	if(!data) return;
	this.recordSet[this.rowIndex] = this.record = data;
	for(i in this.dataobjects){
		fld=this.dataobjects[i];
		con=DataSource.allDataObjects[i];
		if(con){
			vl=data[fld];
			con._setDSValue(vl);
		}
	};
	this.invokeEvent('recordchange');
};
p.setRecordPosition = function(n) {
	this.rowIndex=parseInt(n);
	if(this._modRec) this.cancelAction(true);
	if(this.pageSize<=1) this._send('moveto');
	else {
		var ps,cp,np,fetch;
		var r=this.rowIndex;
		ps=this.pageSize;
		cp=this.pageNumber; //current page
		if(r<1) np=1;		// new page
		else np=this.pageNumber=parseInt(r/ps)+1; 
		fetch=(np!=cp || np>this.pageCount || !this.recordSet.length);
		if(r>=this.rowCount) {r=this.rowCount-1; fetch=true;}
		this.rowIndex=r;
		if (fetch) this._send('fetchpage',null,{pageType:'normalpage'});
		else {
			r=this.recordSet[r];
			this.setRecord(r);
		}
	}
};
p.setSource = function(url,method,ioelement){
	this.src=url; 
	if(method) method=(method+'').toLowerCase();
	if(method || !this.method) this.method=(method=='post'||method=='get')? method:'post';
	if(ioelement) this.ioelement=ioelement;
	else if(!this.ioelement) this.ioelement=IOElement.getSharedIO();		
};
p.submit = function(){
	if (!this._modRec) this.invokeEvent('alert',null,'DataSource: Submit action canceled');
	else {
		var data = this.getRecord();
		this._cancelAct='waiting';
		this.invokeEvent('validate',null,data);
		if(this._cancelAct==true) return;
		this._cancelAct=false;
		this._send('submitrow',data);
	}
};


/* Non-Prototype */
DataSource._cnt=0;
DataSource.all={};
DataSource.allDataObjects={};
DataSource.increment = function(){return 'dsObject'+(this._cnt++)};
DataSource._getFORMInput = function(){return this.value};
DataSource._setFORMInput = function(d){this.value=d};
DataSource._getFORMImage = function(){return this.src};
DataSource._setFORMImage = function(d){if(this.src) this.src=d;};
DataSource._getFORMSelect = function(){
	var i,d=[];
	for(i=0;i<this.options.length;i++) {
		if(this.options[i].selected) d[d.length]=this.options[i].value;
	};
	return d.join(',');
};
DataSource._setFORMSelect = function(d){
	var i,a,o,ov={};
	if (typeof(d)=='object'){
		// clear <select> menu and display name/value pairs
		while(this.length>0) this.remove(0);
		for(i in d){
			this.add(new Option(i,d[i]));
		}
	}else {
		// select values from <select> menu
		a=(d+'').split(',');
		for(i=0;i<a.length;i++) ov[a[i]]=true;
		for(i=0;i<this.options.length;i++) {
			o=this.options[i];
			if(ov[o.value]) o.selected=true;
			else  o.selected=false;
		};
	}
};
DataSource._getFORMCheckBox = function(){
	if (!this.length) {
		if(this.checked) return this.value;
	}else {
		var i,chkv=[];
		for(i=0;i<this.length;i++) {
			if(this[i].checked) chkv[chkv.length]=this[i].value;
		};	
		return chkv.join(',');
	}
};
DataSource._setFORMCheckBox = function(d){
	if (!this.length) {
		if(d==this.value) this.checked=true;
		else this.checked=false;
	}else {
		var i,chk,chkv={};
		var a=(d+'').split(',');
		for(i=0;i<a.length;i++) chkv[a[i]]=true;
		for(i=0;i<this.length;i++) {
			chk=this[i];
			if(chkv[chk.value]) chk.checked=true;
			else  chk.checked=false;
		};	
	}
};
DataSource._getFORMRadio= function(){
	if (!this.length) {
		if(this.checked) return this.value;
	}else {
		for(var i=0;i<this.length;i++) {
			if(this[i].checked) return this[i].value;
		};	
	}
};
DataSource._setFORMRadio= function(d){
	if (!this.length) {
		if(d==this.value) this.checked=true;
		else this.checked=false;
	}else{
		var i,rb;
		for(i=0;i<this.length;i++) {		
			rb=this[i];
			if(d==rb.value) rb.checked=true;
			else rb.checked=false;
		};	
	}
};
DataSource._GetDataSource = function(){ return this.__iDataSource};
DataSource._SetDataSource = function(ds,field){
	if(ds && ds._boundObject) ds._boundObject(this,field);
};
DataSource.IsFormElm=function(o){
	var ot,type=(o && o.type)? o.type+'':'';
	ot=type.replace(/hidden|textarea|text|button|submit|image|select|checkbox|radio/,'');
	if(type && ot!=type) return true;
	else return false;
};
DataSource.createBoundObject = function(o,getfn,setfn){
	if (typeof(o)=='object'){
		if(!getfn && !setfn && this.IsFormElm(o)){	// check if form element			
			var tp=(o.type+'').toLowerCase();
			if(tp=='image') {
				getfn=this._getFORMImage;
				setfn=this._setFORMImage;
			}else if(tp.indexOf('select')==0) {
				getfn=this._getFORMSelect;
				setfn=this._setFORMSelect;
			}else if(tp=='checkbox') {
				getfn=this._getFORMCheckBox;
				setfn=this._setFORMCheckBox;
			}else if(tp=='radio') {
				getfn=this._getFORMRadio;
				setfn=this._setFORMRadio;			
			}else if (tp=='text'||tp=='textarea'||tp=='hidden'||tp=='button'||tp=='submit'){
				getfn=this._getFORMInput;
				setfn=this._setFORMInput;
			}
		}else if(o.src && !getfn && !setfn) { // check if image object
			getfn=this._getFORMImage;
			setfn=this._setFORMImage;
		}
		if(getfn && setfn){
			o._getDSValue = getfn;
			o._setDSValue = setfn;
			o.getDataSource = DataSource._GetDataSource;
			o.setDataSource = DataSource._SetDataSource;
		}
	}
	return o;
};
DataSource.boundFormElements = function(frm,ds){
	var i,elm,elmName,elmType,il={};
	for (i=0;i<frm.elements.length;i++){
		elm=frm.elements[i];
		elmName=elm.name;
		elmType=elm.type;
		if(!il[elmName]){			
			fld=(elm.fieldname)? elm.fieldname:elmName;
			if(frm[elmName].length && (elmType=='radio'||elmType=='checkbox')) {
				il[elmName]=true;
				elm=frm[elmName];
				if(!elm.type) elm.type=elmType;
			}
			elm=DataSource.createBoundObject(elm);
			elm.setDataSource(ds,fld);
		}
	}
};

// CallBack Functions 
DataSource.fnProcessResponse = function(cargo,data){
	var ds=DataSource.all[cargo.id];	
	if(!ds) return;
	ds._ticket=null;
	if(cargo.action=='submitrow'){
		// data should be set to true if all went well
		if(data) ds.recordSet[ds.rowIndex]=cargo.data;
		ds.invokeEvent('submit',null,data);
		ds.invokeEvent('response');
	}else if(cargo.action=='fetchpage'){
		var rowStart=data.dataRowIndex;
		var fieldnames=data.fieldnames;
		var fieldvalues=data.fieldvalues;
		if(!fieldnames||!fieldvalues) return;
		ds.pageCount=0;
		ds.pageRIS=rowStart;
		ds.pageRIE=rowStart+(ds.pageSize-1);
		ds.pageNumber=parseInt(ds.pageRIS/ds.pageSize)+1;
		ds.rowCount=data.dataRowCount;
		if(ds.pageRIE>=ds.rowCount) ds.pageRIE=ds.rowCount-1;
		if(ds.rowCount==null) ds.rowCount=0;
		if(ds.rowCount>0) ds.pageCount=parseInt((ds.rowCount-1)/ds.pageSize)+1;
		if(ds.rowIndex==-2) ds.rowIndex=ds.pageRIE; // set rowIndex to RIS if -2 or to RIE if <0 or >=rowCount
		else if(ds.rowIndex<0||ds.rowIndex>=data.dataRowCount) ds.rowIndex=ds.pageRIS;
		var r,c,record;
		for(r=0;r<fieldvalues.length;r++){
			if(fieldvalues[r]){
				record={}
				for(c=0;c<fieldnames.length;c++){
					record[fieldnames[c]]=fieldvalues[r][c];
				}
				ds.recordSet[r+rowStart]=record;
			}
		}
		ds.setRecord(ds.recordSet[ds.rowIndex]);
		ds.invokeEvent('response');
	}else {
		// after a deleterow reload the current page 
		if(cargo.action=='deleterow' && ds.pageSize>1) ds._send('fetchpage');
		else{
			ds.rowCount = ds.pageCount = data.dataRowCount;
			ds.rowIndex = ds.pageRIS = ds.pageRIE = data.dataRowIndex;
			if(ds.rowCount==null) ds.rowCount=-1;
			ds.setRecord(data);
			ds.invokeEvent('response');
		}
	}
};
DataSource.fnGETPOSTResponse = function(e,s){
	var ds,data,cargo;
	var o=e.getSource();
	if(!s){
		cargo=o.getCargo(true);
		ds=DataSource.all[cargo.id];	
		ds.invokeEvent('alert',null,'DataSource: Server Timeout');
		return; 		
	}
	cargo=o.getCargo();
	data = o.getVariable('record');
	if(!data) return;
	DataSource.fnProcessResponse(cargo,data);
};
DataSource.fnSODAResponse = function(e){
	var ds,data,cargo;
	var o=e.getSource();
	var r=o.getResponse();
	if (r.error) {
		cargo=o.getCargo(true);
		ds=DataSource.all[cargo.id];	
		ds.invokeEvent('alert',null,'DataSource: Server Timeout - '+r.error.text);
		return;
	}
	cargo=o.getCargo();
	data=r.value;
	if(!data) return;
	DataSource.fnProcessResponse(cargo,data);
};

// Data source functions for DynElement
DynElement.prototype._getDSValue = function(){
	return (this.getHTML)? this.getHTML():null;
};
DynElement.prototype._setDSValue = function(d){
	if(this.setHTML) this.setHTML(d);
};
DynElement.prototype.getDataSource = DataSource._GetDataSource;
DynElement.prototype.setDataSource = function(ds,field){
	if(ds && ds._boundObject) {
		this._clsid=this.id;
		ds._boundObject(this,field);
	}
};
