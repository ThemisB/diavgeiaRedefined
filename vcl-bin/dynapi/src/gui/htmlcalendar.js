/*
	DynAPI Distribution
	HTMLCalendar Class - based on Basic Calendar script from The JavaScript Source!! (http://javascript.internet.com)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: HTMLContainer
*/

// to-do: add floating drop down menu to the month and year fields
function HTMLCalendar(css,date){
	this.HTMLContainer = HTMLContainer;
	this.HTMLContainer(css,null,240,206);	

	this._date = date;
};
var p = dynapi.setPrototype('HTMLCalendar','HTMLContainer');
// Design Properties
p.borCol = '#BBBBBB';
p.titleBgCol ='#CCCCCC';
p.titleFgCol ='#000000';
p.wkDayBgCol ='#FFFFFF';
p.wkDayFgCol = '#000000';
p.selBorCol = '#CCCCCC';
p.selBgCol = '#DEDEFF';
p.selFgCol = '#000000';
p.selTDayBgCol = '#EEEEEE';
p.selTDayFgCol = '#000000';
p.imgDn = dynapi.functions.getImage(dynapi.library.path+'gui/images/arr_down.gif',10,10);
p.imgToday = dynapi.functions.getImage(dynapi.library.path+'gui/images/today.gif',18,18);
// Methods
p._oldHConGetInnerHTML = HTMLContainer.prototype.getInnerHTML;
p._getDSValue = function(){return this._date}; // DataSource functions
p._setDSValue = function(d){this._build(d)};
p._build = function(dt,state,ns4Tmr){
	var tmp,ua=dynapi.ua;
	// ns4 will crash if you try to replace the content of a layer by clicking on a link inside the layer
	if(ua.ns4 && !ns4Tmr && this.elm) {
		window.setTimeout(this+'._build("'+(dt||'')+'","'+(state||'')+'",true)',200);
		return;
	}
	var idate=((dt)? dt:this._date)||new Date();
	idate = new Date(idate.toString())
	if(isNaN(idate)) {
		alert('Invalid date: '+(dt||''));
		return;
	}
	this._date = idate;
	var Calendar = new Date(idate.toString());
	var day_of_week = new Array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
	var month_of_year = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
	var year = Calendar.getFullYear(),month = Calendar.getMonth();
	var today = (new Date()).getDate();
	var todayMonth = (new Date()).getMonth();
	var todayYear = (new Date()).getFullYear();
	var selectedDay = Calendar.getDate(),weekday = Calendar.getDay();
	var DAYS_OF_WEEK = 7,DAYS_OF_MONTH = 31;
	var TR_start = '<tr>',TR_end = '</tr>';
	
	tmp = '<td><table callpadding="0" cellspacing="0" bgcolor="@1" @2><tr><td width="18"><center><font face="arial" size="2" color="@3"><b>';
	var highlight_today = tmp.replace(/@1/,this.backCol).replace(/@2/,'background="'+this.imgToday.src+'"').replace(/@3/,this.selTDayFgCol);
	var highlight_start = tmp.replace(/@1/,this.selBgCol).replace(/@2/,((ua.ns4)? 'border="1"':'style="border:2px solid '+this.selBorCol+'"')).replace(/@3/,this.selFgCol);
	var highlight_end   = '</b></font></center></td></tr></table></td>';
	
	tmp = '<td @0 width="30" height="26"><center><font face="arial" size="2" color="@1">';	
	var TD_wkDayStart = tmp.replace(/@0/,'bgcolor="'+this.wkDayBgCol+'"').replace(/@1/,this.wkDayFgCol);
	var TD_start = tmp.replace(/@0/,'').replace(/@1/,this.foreCol);
	var TD_end = '</font></center></td>';

	tmp = (ua.ns4)? 'border="1"':'style="border:1px solid '+this.borCol+'"';
	var cal='<table '+tmp+' width="240" height="206" bgcolor="'+this.backCol+'" cellspacing="0" cellpadding="0"><tr><td valign="top">';
	cal+='<table border="0" cellspacing="0" cellpadding="2">' + TR_start;
	cal+='<td colspan="' + DAYS_OF_WEEK + '" bgcolor="'+this.titleBgCol+'"><center><font face="arial" size="2" color="'+this.titleFgCol+'"><b>';	
	idate=(month+1)+"/"+selectedDay+"/"+year;	
	cal+='<a style="text-decoration:none;color:'+this.titleFgCol+'" href="javascript:;" onclick="return '+this+'._showMonths(\''+idate+'\');">'+ month_of_year[month] + '&nbsp;'+this.imgDn.getHTML()+'</a> &nbsp;&nbsp;';
	cal+='<a style="text-decoration:none;color:'+this.titleFgCol+'" href="javascript:;" onclick="return '+this+'._showYears(\''+idate+'\');">'+ year +'&nbsp;'+this.imgDn.getHTML()+'</a></b>' + TD_end + TR_end;

	// build days-of-week
	cal+=TR_start;
	Calendar.setDate(1);
	Calendar.setMonth(month);
	for(index=0; index < DAYS_OF_WEEK; index++){
		tmp = day_of_week[index];
		if(weekday == index) tmp = '<b>' + day_of_week[index] + '</b>';
		cal+= TD_wkDayStart + tmp + TD_end;
	}
	cal+= TR_end;

	// build days-of-month
	if(Calendar.getDay()>0){
		cal+= TR_start;
		for(index=0; index < Calendar.getDay(); index++){
			cal+= TD_start + '&nbsp;' + TD_end;
		}
	}
	for(index=0; index < DAYS_OF_MONTH; index++){
		if( Calendar.getDate() > index ){
			week_day =Calendar.getDay();
			if(week_day == 0) cal+=TR_start;
			if(week_day != DAYS_OF_WEEK){
				var day  = Calendar.getDate();
				if(selectedDay==Calendar.getDate()){
					cal+= highlight_start + day + highlight_end;
				}else{
					idate=year+"/"+(month+1)+"/"+day;
					click='onclick="'+this+'._build(\''+idate+'\');return false;"';
					click = '<a '+click+' style="text-decoration:none;color:@0" href="javascript:;">'+ day + '</a>';
					if(today==Calendar.getDate() && todayMonth==month && todayYear==year){
						click=click.replace(/@0/,this.selTDayFgCol);
						cal+= highlight_today + click + highlight_end;
					}
					else {
						click=click.replace(/@0/,this.foreCol);
						cal+= TD_start +click+TD_end;
					}
					
				}
			}
			if(week_day == (DAYS_OF_WEEK-1)) cal+= TR_end;
		}
		Calendar.setDate(Calendar.getDate()+1);
	}
	if(week_day != (DAYS_OF_WEEK-1)) cal+= TR_end;
	cal+= '</table></td></tr></table>';
	
	if(!ua.ns4){
		var v,attrib;
		// display today legend
		attrib = 'style="left:160px;top:180px;visibility:inherit;position:absolute"';	
		cal+=HTMLComponent.buildLayer(this.id+'LEG',attrib,'<img src="'+this.imgToday.src+'" border="0" align="top" /><font face="arial" size="2">&nbsp;Today</font>');

		attrib = 'onmouseover="'+this+'._showMenu()" onmouseout="'+this+'._hideMenu()" style="left:70px;top:18px;visibility:inherit;position:absolute"';	
		// display months
		if(state=="sm"){
			tmp='<table width="70" bgcolor="'+this.backCol+'" border="'+((ua.ns4)? 1:0)+'" style="border:1px black solid"><tr><td><font face="arial" size="1" color="'+this.foreCol+'">';
			for(i=0;i<month_of_year.length;i++) {
				day=selectedDay;			
				if(i==1 && day>28) day=28; //feb
				if((i==3||i==5||i==8||i==10) && day>30) day=30; // apr,june,sept,nov
				idate=year+"/"+(i+1)+"/"+day;
				v=month_of_year[i];
				if(i==month) v='<u>'+v+'</u>';
				click='onclick="'+this+'._build(\''+idate+'\');return false;"';
				tmp+='<a '+click+' style="text-decoration:none;color:'+this.foreCol+'" href="javascript:;">'+v+'</a><br>';
			}
			tmp+='</font></td></tr></table>';
			cal+=HTMLComponent.buildLayer(this.id+'MNU',attrib,tmp);
		}	
		// display years
		if(state=="sy"){
			var c,m;
			tmp='<table width="'+((ua.ns4)? 170:165)+'" bgcolor="'+this.backCol+'" border="'+((ua.ns4)? 1:0)+'" style="border:1px black solid"><tr><td align="right"><font face="arial" size="1" color="'+this.foreCol+'">';
			// prev
			idate=(year-12)+"/"+(month+1)+"/"+selectedDay
			click='onclick="'+this+'._build(\''+idate+'\',\'sy\');return false;"';
			tmp+='<a '+click+' style="text-decoration:none;color:'+this.foreCol+'" href="javascript:;">&lt;&lt;Prev</a> | ';
			// manual
			idate=(month+1)+"/"+selectedDay+"/"+year;
			click='onclick="return '+this+'._showInput(\''+idate+'\');"';
			tmp+='<a '+click+' style="text-decoration:none;color:'+this.foreCol+'" href="javascript:;">Manual</a> | ';		
			// next
			idate=(year+12)+"/"+(month+1)+"/"+selectedDay
			click='onclick="'+this+'._build(\''+idate+'\',\'sy\');return false;"';
			tmp+='<a '+click+' style="text-decoration:none;color:'+this.foreCol+'" href="javascript:;">Next&gt;&gt;</a><br>';
			// years
			for(i=0;i<6;i++) {
				for(c=0;c<5;c++){
					m=((c*6)-12);
					idate=(year+m+i)+"/"+(month+1)+"/"+selectedDay
					v=(year+m+i);
					if(v==year) v='<u>'+v+'</u>';
					click='onclick="'+this+'._build(\''+idate+'\');return false;"';
					tmp+='<a '+click+' style="text-decoration:none;color:'+this.foreCol+'" href="javascript:;">'+v+'</a>';
					if(c<4) tmp+=' <font color="#eeeeee">|</font> ';
				}
				tmp+='<br>';
			}
			tmp+='</font></td></tr></table>'
			cal+=HTMLComponent.buildLayer(this.id+'MNU',attrib,tmp);
		};
		clearTimeout(this._mnuTmr);
		if(state=='sy'||state=='sm') this._mnuTmr = setTimeout(this+'._hideMenu(true)',2500);
	}
	
	this.setHTML(cal);
	this.invokeEvent('change');
	this._ePlaySnd('change');
};
p._hideMenu = function(b){
	if(b) this._build();
	else this._mnuTmr = setTimeout(this+'._hideMenu(true)',500);
}
p._showMenu = function(){
	clearTimeout(this._mnuTmr);
}
p._showInput = function(dt){
	var r = window.prompt('Please enter a valid year (yyyy) or date (mm/dd/yyyy):',dt||'');
	if(r && r.length==4) r=dt.substr(0,dt.length-4)+r;
	this._build(r);
};
p._showMonths = function(dt){
	if(dynapi.ua.ns4) this._showInput(dt);
	else this._build(null,'sm');
	return false;
};
p._showYears = function(dt){
	if(dynapi.ua.ns4) this._showInput(dt);
	else this._build(null,'sy');
	return false;
};
p.getInnerHTML = function(){
	this._build();
	return this._oldHConGetInnerHTML();
};
p.getDate  = function(dt){return this._date};
p.setDate  = function(dt){
	this._build(dt);
};
