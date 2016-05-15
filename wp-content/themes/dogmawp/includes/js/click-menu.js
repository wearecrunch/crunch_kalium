function initmenytype () {
jQuery(".nav-inner nav ul >li.menu-item-has-children > a").each(function(i){
				   jQuery(this).addClass('sub-nav-toggle');
				   jQuery(this).removeClass('ajax');
				});
				
				jQuery(".nav-inner nav ul li.menu-item-has-children ul li.menu-item-has-children > a").each(function(i){
				   jQuery(this).removeClass('sub-nav-toggle');
				   jQuery(this).addClass('sub-sub-nav-toggle');
				   jQuery(this).removeClass('ajax');
				});
				
				jQuery(".sub-menu").each(function(i){
				   jQuery(this).addClass('sub-nav hidden');
				});
				
				jQuery(".nav-inner nav ul li ul.sub-menu li ul").each(function(i){
				   jQuery(this).removeClass('sub-nav');
				   jQuery(this).addClass('sub-sub-nav');
				});

jQuery('.sub-nav-toggle').on('click', function(e){
            e.preventDefault();
            var jQuerysubNav = jQuery(this).next('.sub-nav');
						var jQueryothernav = jQuery(this).parents().find('.sub-nav');
            if(jQuerysubNav.hasClass('hidden')){
								jQueryothernav.slideUp(420, function(){
									jQuery(this).addClass('hidden');
								});
                jQuerysubNav.hide().removeClass('hidden').stop().slideDown(420);
            }else{
                jQuerysubNav.stop().slideUp(420, function(){
                    jQuery(this).addClass('hidden');
                });
            }
        });
		
		jQuery('.sub-sub-nav-toggle').on('click', function(e){
            e.preventDefault();
            var jQuerysubNav = jQuery(this).next('.sub-sub-nav');
						var jQueryothernav = jQuery(this).parents().find('.sub-sub-nav');
            if(jQuerysubNav.hasClass('hidden')){
								jQueryothernav.slideUp(420, function(){
									jQuery(this).addClass('hidden');
								});
                jQuerysubNav.hide().removeClass('hidden').stop().slideDown(420);
            }else{
                jQuerysubNav.stop().slideUp(420, function(){
                    jQuery(this).addClass('hidden');
                });
            }
        });
}