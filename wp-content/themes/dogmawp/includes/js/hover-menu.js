function initmenytype () {
 jQuery(".nav-inner nav li").on("mouseenter", function() {
        jQuery(this).find("ul").stop().slideDown();
        jQuery(".nav-inner").addClass("menhov");
    });
    jQuery(".nav-inner nav li").on("mouseleave", function() {
        jQuery(this).find("ul").stop().slideUp();
        jQuery(".nav-inner").removeClass("menhov");
    });
}