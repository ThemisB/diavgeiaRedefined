/*
        DynAPI Distribution
        HTMLMenu Class - based on Cascading Menu script from The JavaScript Source!! (http://javascript.internet.com)

        The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

        Requires: HTMLComponent
*/


function HTMLMenu(css,orientation){
        this.HTMLComponent = HTMLComponent;
        this.HTMLComponent(css);
        this._menu = [];                        // store menu items
        this._menuLink = [];    // store menu link ids
        this._mnuTmr = 0;
        this._litNow = [];
        this._vertOrient = (orientation && orientation=='vert')? true:false;
        this.onCreate(this._assignElm); // necessary as menus needs to be created after page loads
};
HTMLMenu._addItem = function(css,text,linkId,callback,length,spacing,backCol,selBgCol,cssText){
        var itm = {};
        var len = this._src._menu[this._mnuid].length;
        itm.id = this.id+len;
        itm.lid = linkId;
        if(typeof(text)!='object') {
                itm.text = text||'';
                itm.image = null;
                itm.contMode = (dynapi.ua.def)? true:false;
        }
        else {
                itm.image=text.image;
                itm.text=text.text||'';
                itm.contMode = text.contMode; // container mode
        };
        itm.callback = (!callback && linkId)? false:callback;
        itm.length = length||this.height||this._src.mnuItmHeight;
        itm.cssName = css||this._src.cssMenuItem;
        itm.cssTextName = cssText||this._src.cssMenuText;
        itm.spacing = spacing||0;
        if (backCol=='')
        {
                itm.backCol=backCol;
        }
        else
        {
                itm.backCol = backCol||this._src.backCol;
        }
        itm.selBgCol = selBgCol||this._src.selBgCol;
        this._src._menu[this._mnuid][len] = itm;
        return itm.id;
};
var p = dynapi.setPrototype('HTMLMenu','HTMLComponent');
// Design Properties
p.backCol = '#003366';
p.selBgCol = '#336699';
p.cssMenuItem = 'HCMNUItm';
p.cssMenuText = 'HCMNUItmText';
p.mnuItmWidth = 40;
p.mnuItmHeight = 20;
p.mnuArrow = dynapi.functions.getImage(dynapi.library.path+'gui/images/menuarrow.gif',8,9).getHTML();
// Methods
p._assignElm = function(elm){
        var i,c,id,lyr,plyr;
        var mnu,itmName;
        if(!this._created) return;
        for (i = 0; i < this._menu.length; i++) {
                id = this.id+'Mnu' + i + 'Div';
                if(i==0){
                        // assign root menu css
                        plyr = this.HC.getLayerById(id,this.parent.doc);
                        if(!plyr) {
                                this._created = false; // not yet created
                                return;
                        }
                        plyr.setVisible(true);
                        mnu = this._menu[i][0];
                        mnu.elm = plyr;
                        mnu.css = (dynapi.ua.ns4)? plyr:plyr.style;
                        this.elm = plyr;
                        this.css = (dynapi.ua.ns4)? plyr:plyr.style;
                        this.doc = plyr.document;
                }
                else {
                        // create other menu items inside document
                        if(this['Menu'+i+'Embedded']) plyr = this['Menu'+i+'Embedded'];
                        else {
                                plyr = this._buildMenu(i);
                                mnu = this._menu[i][0];
                                mnu.elm = plyr;
                                mnu.css = (dynapi.ua.ns4)? plyr:plyr.style;
                                this['Menu'+i+'Embedded'] = plyr; // menu item now exist inside the document
                        }
                }
                // setup menu items
                for (c = 1; c < this._menu[i].length; c++) {
                        itmName = this.id+'Mnu' + i  + 'Itm' + c;
                        lyr = this.HC.getLayerById(itmName,plyr.document);
                        this._menu[i][c].elm =lyr;
                        this._menu[i][c].css = (!dynapi.ua.ns4)? lyr.style:plyr.document[itmName];
                }
        }
        //this._showOnly(0);
};
p._buildMenu = function(currMenu){
        var mnuImage,mnuImgAlg;
        var targetMenu;
        var w,h,itemID,mnu = this._menu[currMenu];
        var str = '', itemX = 0, itemY = 0;

        if(!mnu) return '';
        if(currMenu>0) mnu[0].css=null; // reset css to force _assignElm during TM generate

        // Items start from 1 in the array (0 is menu object itself, above).
        // Also use properties of each item nested in the other with() for construction.
        for (var currItem = 1; currItem < mnu.length; currItem++) with (mnu[currItem]) {
                itemID = this.id + 'Mnu' + currMenu + 'Itm' + currItem;

                // The width and height of the menu item - dependent on orientation!
                w = (!mnu[0].isRoot ? mnu[0].width : length);
                h = (!mnu[0].isRoot ? length : mnu[0].width);

                // In IE4 width must be a miniumum of 3 pixels.
                if (dynapi.ua.def) {
                        str += '<div id="' + itemID + '" onclick="return '+this+'._e(\'click\','+currMenu+','+currItem+')" style="position: absolute; left: ' + itemX + 'px; top: ' + itemY + 'px; width: ' + w + 'px; height: ' + h + 'px; visibility: inherit; ';
                        if (backCol) str += 'background: ' + backCol + '; ';
                        str += '" ';
                }else if (dynapi.ua.ns4) {
                        str += '<layer id="' + itemID + '" left="' + itemX + '" top="' + itemY + '" width="' +  w + '" height="' + h + '" visibility="inherit" ';
                        if (backCol) str += 'bgcolor="' + backCol + '" ';
                }
                if (cssName) str += 'class="' + cssName + '" ';

                // Add mouseover handlers and finish div/layer.
                str += 'onmouseover="'+this+'._e(\'mouseover\',' + currMenu + ',' + currItem + ')" onmouseout="'+this+'._e(\'mouseout\',' + currMenu + ',' + currItem + ')">';

                // Setup menu image
                var imgParams
                if(!image) mnuImage ='';
                else {
                        imgParams = image.params;
                        mnuImgAlg =  (imgParams && imgParams.align)? imgParams.align:'absmiddle';
                        mnuImage = '<img name="'+this.id+id+'" src="'+image.src+'" width="'+image.w+'" height="'+image.h+'" border="0" align="'+mnuImgAlg+'">'
                }

                // Setup Image Text Direction
                dir = (imgParams && imgParams.textdir)? imgParams.textdir:'W';
                dir = (dir+'').toUpperCase();
                if(dir=='E') text = text+mnuImage;
                if(dir=='N') text = mnuImage+'<br>'+text;
                if(dir=='S') text = text+'<br>'+mnuImage;
                else text = mnuImage+text;

                // In IE/NS6+, add padding if there's a border to emulate NS4's layer padding.
                str += '<table width="' + (w - 8) + '" border="0" cellspacing="0" cellpadding="' + ((!dynapi.ua.ns4 && cssName)? mnu[0].padding : 0) + '"><tr><td align="left" height="' + (h - 7) + '" class="' + cssTextName + '">'
                + (contMode? text:'<a class="' + cssTextName + '" href="javascript:;" onclick="'+((!dynapi.ua.ns4)? 'this.blur(); return false;':'return '+this+'._e(\'click\','+currMenu+','+currItem+');')+'">' + text + '</a>')
                +'</td>';
                if(lid && this._menuLink[lid]) {
                        // Set target's parents to this menu item.
                        linkMnu=this._menuLink[lid];
                        this._menu[linkMnu][0].parentMnu = currMenu;
                        this._menu[linkMnu][0].parentItm = currItem;

                        // Add popout indicator.
                        if(currMenu!=0) str += '<td class="' + cssTextName + '" align="right">'+this.mnuArrow+'</td>';
                }
                str += '</tr></table>' + (dynapi.ua.ns4 ? '</layer>' : '</div>');
                if (!mnu[0].isRoot) itemY += length + spacing;
                else itemX += length + spacing;
        }

        var id = this.id+'Mnu' + currMenu + 'Div';
        if(currMenu==0){
                // first menu must be relatively positioned
                var attr;
                if(dynapi.ua.ns4) str = '<ilayer id="'+id+'" visibility="inherit" height="'+(h+3)+'">'+str+'</ilayer>';
                else str = '<div id="'+id+'" style="position:relative; visibility: inherit; height:'+(h+mnu[0].padding)+'px;">'+str+'</div>';
                return str;
        }
        else if(this._created){
                // add all other menus inside the document object
                var lyr;
                if (dynapi.ua.ie||dynapi.ua.opera) {
                        document.body.insertAdjacentHTML('beforeEnd', '<div id="' + id + '" style="position: absolute; top: -100px; visibility: hidden; z-index:10000">' + str + '</div>');
                        lyr = document.all[id];
                        lyr.style.visibility = "hidden";
                }
                else if (dynapi.ua.dom) {
                        var ptxt,r = document.body.ownerDocument.createRange();
                        r.setStartBefore(document.body);
                        ptxt = r.createContextualFragment('<div id="' + id + '" style="position: absolute; top: -100px; visibility: hidden; z-index:10000">' + str + '</div>');
                        document.body.appendChild(ptxt);
                        lyr = document.body.lastChild;
                }
                else if (dynapi.ua.ns4) {
                        lyr = new Layer(0);
                        lyr.document.write(str);
                        lyr.document.close();
                        lyr.zIndex = 10000;
                        lyr.top = -100;
                        lyr.visibility="hide";
                }
                return lyr;
        }
};
p._e = function(evt,mnuNum,itmNum){
        var mnu = this._menu[mnuNum];
        var index = mnu[0].id+itmNum;
        this._ePlaySnd(evt); // plays ordinary sound events: click, over & out
        if(evt=='click'){
                this._evtResponse = this._defEvtResponse;
                if(mnu[itmNum] && mnu[itmNum].callback) {
                        if(typeof(mnu[itmNum].callback)=='function') mnu[itmNum].callback(index);
                        else eval(mnu[itmNum].callback);
                }
                if (mnu[itmNum].callback!=false) this._showOnly(0);
        }
        else if(evt=='mouseover'){
                window.clearTimeout(this._mnuTmr);
                if(!mnu[itmNum].elm) return;
                lid=mnu[itmNum].lid;
                if(this._created && mnu[0].css==null) this._assignElm();
                this._showOnly(mnuNum);
                this._litNow = this._getHierarchy(mnuNum, itmNum);
                mnu[0].lastItem = itmNum; // set last item
                this._changeCol(this._litNow, true);
                targetNum = this._menuLink[lid];
                if (targetNum > 0) {
                        if(mnuNum==0) {
                                thisX = (dynapi.ua.ns4)? mnu[0].elm.pageX:parseInt(mnu[0].elm.offsetLeft||0);
                                thisY = (dynapi.ua.ns4)? mnu[0].elm.pageY:parseInt(mnu[0].elm.offsetTop||0);
                                if(!dynapi.ua.ns4){
                                        thisX+=this.parent.getPageX();
                                        thisY+=this.parent.getPageY();
                                }
                        }else {
                                thisX = parseInt(mnu[0].css.left||0);
                                thisY = parseInt(mnu[0].css.top||0);
                        }
                        if(dynapi.ua.ns4){
                                if(!mnu[0].isRoot) thisX+=parseInt(mnu[itmNum].css.clip.width||0)
                                else thisY+=parseInt(mnu[itmNum].css.clip.height||0)
                        }
                        else{
                                if(!mnu[0].isRoot) thisX+=parseInt(mnu[itmNum].css.width||0) + mnu[0].subMnuOffset;
                                else thisY+=parseInt(mnu[itmNum].css.height||0) + mnu[0].subMnuOffset;
                        }
                        thisX += parseInt(mnu[itmNum].css.left||0);
                        thisY += parseInt(mnu[itmNum].css.top||0);
                        
                        // auto-fold sub-menus
                        var tarMnu = this._menu[targetNum];
                        if((thisX+tarMnu[0].width)>dynapi.document.getWidth()) {
                                if(mnu[0]._mnuid) thisX-=(mnu[0].width+tarMnu[0].width);
                                else {
                                        thisX=dynapi.document.getWidth()-tarMnu[0].width;
                                }
                                // remove subMenuOffset when sub-menus are folded inward
                                if(!mnu[0].isRoot) thisX-=mnu[0].subMnuOffset;
                        }
                        if((thisY+(tarMnu[0].height*(tarMnu.length-1)))>dynapi.document.getHeight()) {
                                if(mnu[0].isRoot && !mnu[0]._mnuid) thisY-=(tarMnu[0].height*tarMnu.length);
                                else {
                                        thisY = dynapi.document.getHeight() - (tarMnu[0].height*(tarMnu.length-1));
                                }
                        }
                        
                        with (tarMnu[0].css) {
                                left = thisX + (dynapi.ua.def ? 'px':'');
                                top = thisY + (dynapi.ua.def ? 'px':'');
                                visibility = (dynapi.ua.ns4)? 'show':'visible';
                        }
                        
                        // plays special pop-up sound event
                        if(this._lTargetNum!=targetNum) this._ePlaySnd('menuopen');
                        this._lTargetNum=targetNum;
           }else this._lTargetNum = mnu[0]._mnuid;
        }
        else if(evt=='mouseout'){
                if ((mnuNum == 0) && !mnu[itmNum].lid) this._showOnly(0);
                else this._mnuTmr = window.setTimeout(this+'._showOnly(0)', 500);
        }
        
        // invoke event
        this.invokeEvent(evt,null,index);
        return this._evtResponse;
};
p._getHierarchy = function(mnuNum, itmNum) {
        var mnu;
        var itmArray = [this._menu.length];
        while(1) {
                itmArray[mnuNum] = itmNum;
                if (mnuNum == 0) return itmArray;
                mnu = this._menu[mnuNum][0];
                itmNum = mnu.parentItm;
                mnuNum = mnu.parentMnu;         
        }
};
p._changeCol = function(changeArray, isOver) {
        var mnu,lmnu;
        var lastItem,newCol;
        var i,menu = this._menu;
        for (i = 0; i < changeArray.length; i++) {
                if(changeArray[i]) {
                        lastItem = menu[i][0].lastItem;
                        lmnu = menu[i][lastItem];
                        mnu = menu[i][changeArray[i]];
                        // Change the image of the menu
                        if(lmnu.image) {
                                img = lmnu.image;
                                src = (img )? img.src:'';
                                oversrc = (img && img.params && img.params.oversrc)? img.params.oversrc:src;
                                newImg = isOver ? oversrc:src;
                                img = (dynapi.ua.ns4)? mnu.elm.document.images[this.id+mnu.id]:document.images[this.id+mnu.id];
                                img.src = newImg;
                        }
                        
                        // Change the colours of the div/layer background.
                        newCol = isOver ? menu[i][lastItem].selBgCol:menu[i][lastItem].backCol;
                        with (mnu.css) {
                                if (dynapi.ua.ns4) bgColor = newCol;
                                else backgroundColor = newCol;
                 }
                }
   }
};
p._showOnly = function(mnuNum) {
        var opnMnu = this._getHierarchy(mnuNum, 1);
        for (count = 0; count < this._menu.length; count++) {
                if (!opnMnu[count]) with(this._menu[count][0].css){
                        visibility = (dynapi.ua.ns4)? 'hide':'hidden';
                        left = -100;
                        top = -100;
                }
        }
        this._changeCol(this._litNow, false);
};
p.createMenuBar = function(id,itmWidth,itmHeight,subMnuOffset,padding){
        var mnu = {};
        var len = this._menu.length;
        mnu.id = id;
        mnu._mnuid = len;       //menu id;
        mnu.isRoot = (!this._vertOrient && this._menu.length==0)? true:false;
        mnu.width = itmWidth||this.mnuItmWidth;
        mnu.height = itmHeight||this.mnuItmHeight;
        mnu.subMnuOffset = (subMnuOffset==null)? 0:subMnuOffset;
        mnu.addItem = HTMLMenu._addItem;
        mnu.padding = (padding==null)? 3:padding;
        mnu._src=this;
        if(mnu.isRoot)  {
                // swap width & height if horizontal
                var tmp = mnu.width;
                mnu.width=mnu.height;
                mnu.height = tmp;
        }
        this._menu[len]=[mnu];
        this._menuLink[id] = len;
        return mnu;
};
p.getInnerHTML = function(){
        this.html = this._buildMenu(0);
        return this.html;
};

// Write Style to browser
HTMLComponent.writeStyle({
        HCMNUItm:               'border: 1px solid #002851',
        HCMNUItmText:   'cursor: default; text-decoration: none; color: #FFFFFF; font: 12px Arial, Helvetica'
});
