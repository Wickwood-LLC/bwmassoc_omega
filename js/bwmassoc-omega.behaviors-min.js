!function($){Drupal.theme.prototype.bwmassocOmegaExampleButton=function(e,a){return $('<a href="'+e+'" title="'+a+'">'+a+"</a>")},Drupal.behaviors.bwmassocOmegaExampleBehavior={attach:function(e,a){$(".some-selector",e).once("foo",function(){var e=Drupal.theme("bwmassocOmegaExampleButton",a.myExampleLinkPath,a.myExampleLinkTitle);e.appendTo(this)});var t=document.documentElement;t.setAttribute("data-useragent",navigator.userAgent),t.setAttribute("data-platform",navigator.platform),t.className+="ontouchstart"in window||"onmsgesturechange"in window?" touch":"",$("html").hasClass("touch")&&$(".tabs--primary li a.active").has(".secondary-tabs")&&($(".tabs--primary li a.active").removeAttr("href"),$(".tabs--primary li a.active").on("click",function(){console.log("clicked!"),$(".tabs--primary li a.active .secondary-tabs a").css("color","green")}))}},Drupal.behaviors.collapseBlock={attach:function(e,a){$(".panelizer-view-mode.node-embedded-to-profile>h3").off("click"),$(".panelizer-view-mode.node-embedded-to-profile>h3").on("click",function(){var e=$(this);e.parents(".panelizer-view-mode.node-embedded-to-profile").find(".panel-display").first().slideToggle(),e.toggleClass("open")})}}}(jQuery);