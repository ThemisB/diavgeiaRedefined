jQuery.fn.accessNews = function(settings) {
    settings = jQuery.extend({
        newsHeadline: "Top Stories",
        newsSpeed: "normal"
    }, settings);
    return this.each(function(i) {
        aNewsSlider.itemWidth = parseInt(jQuery(".item:eq(" + i + ")",".news_slider").css("width")) + parseInt(jQuery(".item:eq(" + i + ")",".news_slider").css("margin-right"));
        aNewsSlider.init(settings,this);
        jQuery(".view_all > a", this).click(function() {
            aNewsSlider.vAll(settings,this);
            return false;
        });
    });
};
var aNewsSlider = {
    itemWidth: 0,
    init: function(s,p) {
        jQuery(".messaging",p).css("display","none");
        itemLength = jQuery(".item",p).length;
        if (jQuery(".view_all",p).width() == null) {
            jQuery(".news_items",p).prepend("<p class='view_all'>" + s.newsHeadline + " [ " + itemLength + " total ] &nbsp;-&nbsp; <a href='#'>View All</a></p>");
        }

        if (!isNaN(aNewsSlider.itemWidth))
        {
          newsContainerWidth = itemLength * aNewsSlider.itemWidth;
          jQuery(".container",p).css("width",newsContainerWidth + "px");
          jQuery(".next",p).css("display","block");
          animating = false;
        }
        jQuery(".next",p).click(function() {
            if (animating == false) {
                animating = true;
                animateLeft = parseInt(jQuery(".container",p).css("left")) - (aNewsSlider.itemWidth * 2);
                if (animateLeft + parseInt(jQuery(".container",p).css("width")) > 0) {
                    jQuery(".prev",p).css("display","block");
                    jQuery(".container",p).animate({left: animateLeft}, s.newsSpeed, function() {
                        jQuery(this).css("left",animateLeft);
                        if (parseInt(jQuery(".container",p).css("left")) + parseInt(jQuery(".container",p).css("width")) <= aNewsSlider.itemWidth * 2) {
                            jQuery(".next",p).css("display","none");
                        }
                        animating = false;
                    });
                } else {
                    animating = false;
                }
            }
            return false;
        });
        jQuery(".prev",p).click(function() {
            if (animating == false) {
                animating = true;
                animateLeft = parseInt(jQuery(".container",p).css("left")) + (aNewsSlider.itemWidth * 2);
                if ((animateLeft + parseInt(jQuery(".container",p).css("width"))) <= parseInt(jQuery(".container",p).css("width"))) {
                    jQuery(".next",p).css("display","block");
                    jQuery(".container",p).animate({left: animateLeft}, s.newsSpeed, function() {
                        jQuery(this).css("left",animateLeft);
                        if (parseInt(jQuery(".container",p).css("left")) == 0) {
                            jQuery(".prev",p).css("display","none");
                        }
                        animating = false;
                    });
                } else {
                    animating = false;
                }
                return false;
            }
        });
    },
    vAll: function(s,p) {
        var o = p;
        while (p) {
            p = p.parentNode;
            if (jQuery(p).attr("class") != undefined && jQuery(p).attr("class").indexOf("news_slider") != -1) {
                break;
            }
        }
        if (jQuery(o).text().indexOf("View All") != -1) {
            jQuery(".next",p).css("display","none");
            jQuery(".prev",p).css("display","none");
            jQuery(o).text("View Less");
            jQuery(".container",p).css("left","0px").css("width",aNewsSlider.itemWidth * 2 + "px");
        } else {
            jQuery(o).text("View All");
            aNewsSlider.init(s,p);
        }
    }
};
