	var arvlbFPPL = {
	/** Variables */
	fbinit 			: false,
	launched		: false,
	  
	/**
	 * Initiliaze Facebook the proper way
	 */
	initFB 			: function(){
		if ((typeof(FB)!= 'undefined')) {
	    FB.init({
    		xfbml: true,    
	  		status : true, // check login status
      		cookie : true // enable cookies to allow the server to access the session
    		});
		}
      arvlbFPPL.fbinit   = true;

	},

	/*
	 * Init the plugin, and set the correct parameters
	 * to launch the lightbox
	 */
	initCode 		: function(){
		arvlbFPPL.initFB();
		if (!arvlbFPPL.checkForLaunch())
			return false;

		window.setTimeout(arvlbFPPL.showFaceBox, lb_l_ret.delay);
	},

	/**
	 * Check if we may launch it, according to the option set in
	 * the admin views
	 */
	checkForLaunch 	: function(){
		if ( (lb_l_ret.show_once>0) && (arvlbFPPL.readCookie('arevico_lb')==1) )
			return !(arvlbFPPL.launched=true);
		return true;
	},

	/**
	 * Finally, render the lightbox
	 */
	showFaceBox 	: function(){
		if (arvlbFPPL.launched==true)
			return;

		arvlbFPPL.launched =true;

	  	if (lb_l_ret.show_once>0)
			arvlbFPPL.createCookie("arevico_lb", "1", lb_l_ret.show_once);
		

		jQuery.arvfl(
    	  jQuery('#arvlbdata'),{
    	  	type: 			'html',
        	namespace:    	'ArevicoModal',
        	persist:      	true,
        	closeOnClick:   (lb_l_ret.coc == 1) ? 'background' : false,
        	closeIcon:    	'&nbsp;',
      	    beforeClose:    arvlbFPPL.close,
            beforeOpen:     arvlbFPPL.styleSettings

	     });
	},
  /**
   * Apply some last minute style settings
   */
  styleSettings:  function(){
    jQuery('html').addClass('arvnoscroll');
  },

  close:        function(){
    jQuery('html').removeClass('arvnoscroll');
  },


	/**
	 * Create a cookie
	 * @param string 	name 	The cookie's name
	 * @param string 	value  	The cookies value (browser restriction may vary)
	 * @param int 		days 	The amount of days in which the cookie will expire (may be earlier)
	 */
	createCookie 	: function(name, value, days){
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	},

	/**
	 * Read a cookie
	 * @param string name The name of the cookie
	 */
	readCookie 		: function(name){
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	},

  /**
   * Poll for the readyness of the Facebook API when all else fails
   */
   asyncReady:  function(){
    if ( typeof(FB) == 'undefined') {
        window.setTimeout(arguments.callee, 500);
     } else if (!arvlbFPPL.fbinit){
        arvlbFPPL.initCode();
    }    
  }

}

window.fbAsyncInit = arvlbFPPL.initCode;

jQuery(document).ready(function() {
    jQuery('body').append('<div id="fb-root"></div>');
	
	  window.setTimeout(arvlbFPPL.asyncReady,1);

      if (lb_l_ret.performance == 2)
        return; 

      jQuery.getScript('//connect.facebook.net/en_US/all.js#xfbml=1&status=1&cookie=1',
          function(script, textStatus, jqXHR) {
              window.setTimeout(arvlbFPPL.initCode, 200);
          });


});