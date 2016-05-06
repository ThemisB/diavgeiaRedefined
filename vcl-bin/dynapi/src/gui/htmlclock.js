/*
        DynAPI Distribution
        HTMLClock Class - based on Scrolling Clock script from The JavaScript Source!! (http://javascript.internet.com)
                  
        The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
        
        Requires: HTMLContainer
*/

function HTMLClock(css){
        this.HTMLContainer = HTMLContainer;
        this.HTMLContainer(css,null,90,90);

        this._Ypos =44;
        this._Xpos =44;
        this._Ybase = 8;
        this._Xbase = 8;
        this._dots = 12;
        this._hLn = 4; // # dots for hours
        this._mLn = 5; // # dots for minutes
        this._sLn = 6; // # dots for seoncds

        this._showTime();
};
var p = dynapi.setPrototype('HTMLClock','HTMLContainer');
// Design Properties
p.digitCol = '000000';  //digit colour.
p.secCol = 'ff0000';  //seconds colour.
p.minCol = '000000';  //minutes colour.
p.hourCol = '000000';  //hours colour.
// Methods
p._oldHCLKGetInnerHTML = HTMLContainer.prototype.getInnerHTML;
p._getDSValue = function(){return this._date}; // DataSource functions
p._setDSValue = dynapi.functions.Null;
p._build = function(){
        var html='';
        var attr,attrB;

        if(dynapi.ua.ns4) {
                attr = 'top=0 left=0 height=30 width=30';
                attrB = 'top=0 left=0 bgcolor=@0 clip="0,0,2,2"';
                for (i = 0; i < this._dots; i++) html+=this.HC.buildLayer(this.id+i+'Digits"',attr,'<center><font face=Arial,Verdana size=1 color='+this.digitCol+'>'+(i+1)+'</font></center>');
        }
        else {
                attr ='style="visibility:hidden;position:absolute;left:0px;top:0px;width:30px;height:30px;font-family:Arial,Verdana;font-size:10px;color:'+this.digitCol+';text-align:center;padding-top:10px"';
                attrB = 'style="visibility:hidden;position:absolute;left:0px;top:0px;width:2px;height:2px;font-size:2px;background-color:@0"';
                for (i = 0; i < this._dots; i++) html+=this.HC.buildLayer(this.id+i+'Digits',attr,(i+1));
        }

        for (i = 0; i < this._mLn; i++) html+=this.HC.buildLayer(this.id+i+'Y',attrB.replace(/@0/,this.minCol),'');
        for (i = 0; i < this._hLn; i++) html+=this.HC.buildLayer(this.id+i+'Z',attrB.replace(/@0/,this.hourCol),'');
        for (i = 0; i < this._sLn; i++) html+=this.HC.buildLayer(this.id+i+'X',attrB.replace(/@0/,this.secCol),'');
        html='<table border=0 cellspacing=0 width=90 height=90><tr><td>'+html+'</td></tr></table>';
        this.html=html;
};
p._showTime = function() {
        var x,y,lyr;
        var time = new Date ();
        var secs = time.getSeconds();
        var sec = -1.57 + Math.PI * secs/30;
        var mins = time.getMinutes();
        var min = -1.57 + Math.PI * mins/30;
        var hr = time.getHours();
        var hrs = -1.57 + Math.PI * hr/6 + Math.PI*parseInt(time.getMinutes())/360;

        if (this.getElm()) {
                for (i = 0; i < this._dots; ++i){
                        lyr = this.HC.getLayerById(this.id+i+'Digits',this.doc);
                        y = this._Ypos - ((dynapi.ua.ns4)? 5:15) + 40 * Math.sin(-0.49+this._dots+i/1.9);
                        x = this._Xpos - ((dynapi.ua.ns4)? 15:14) + 40 * Math.cos(-0.49+this._dots+i/1.9);
                        lyr.setLocation(x,y);
                        lyr.setVisible(true);
                }
                for (i = 0; i < this._sLn; i++){
                        lyr = this.HC.getLayerById(this.id+i+'X',this.doc);
                        y = this._Ypos + i * this._Ybase * Math.sin(sec);
                        x = this._Xpos + i * this._Xbase * Math.cos(sec);
                        lyr.setLocation(x,y);
                        lyr.setVisible(true);
                }
                for (i = 0; i < this._mLn; i++){
                        lyr = this.HC.getLayerById(this.id+i+'Y',this.doc);
                        y = this._Ypos + i * this._Ybase * Math.sin(min);
                        x = this._Xpos + i * this._Xbase * Math.cos(min);
                        lyr.setLocation(x,y);
                        lyr.setVisible(true);
                }
                for (i = 0; i < this._hLn; i++){
                        lyr = this.HC.getLayerById(this.id+i+'Z',this.doc);
                        y = this._Ypos + i * this._Ybase * Math.sin(hrs);
                        x = this._Xpos + i * this._Xbase * Math.cos(hrs);
                        lyr.setLocation(x,y);
                        lyr.setVisible(true);
                }
                //check alarm
                if(this._alarm){
                        var a = new Date(this._alarm);
                        if (a && (
                                a.getHours()==time.getHours() &&
                                a.getMinutes()==time.getMinutes() &&
                                a.getSeconds()==time.getSeconds()
                        )) {
                                this._alarm=null;
                                this.invokeEvent('alarm');
                                this._ePlaySnd('alarm');
                        }
                                
                }
        }       
        // loop
        window.setTimeout(this+'._showTime()', 50);
};
p.getInnerHTML = function(){
        this._build();
        return this._oldHCLKGetInnerHTML();
};
// Time format: [Date object] or Hours:Minutes:Seconds
p.setAlarm = function(dt){
        if(typeof(dt)!='string') {
                dt = new Date(dt);
                if(!isNaN(dt)) this._alarm = dt;
        }
        else {
                var d=new Date();
                dt=(dt+'').split(':');
                if(!isNaN(dt[0])) d.setHours(dt[0]||0);
                if(!isNaN(dt[1])) d.setMinutes(dt[1]||0);
                if(!isNaN(dt[2])) d.setSeconds(dt[2]||0);
                this._alarm = d;
        }
};
