jQuery( document ).ready(function( $ ) {

	/**
	 * ArevicoSimpleTab
	 */
if (typeof window.ArevicoSimpleTab === 'undefined'){
	window.ArevicoSimpleTab = {
		/**
		 *
		 */
		showTab: function(event){
			var tabContainer = $(this).closest('.tab-container');

			/* Remove all current active classes*/
			$('a', tabContainer).removeClass('a-active nav-tab-active');
			$('li', tabContainer).removeClass('li-active');

			var re 	= /(?:^| )tab-(.*)($|\s)/
			var qNR = ($(this).attr('class').match(re)[1]);

			$('.tab', tabContainer).hide().removeClass('tab-active nav-tab-active').addClass('tab-inactive nav-tab-inactive');
			$('#' + qNR, tabContainer).addClass('tab-active nav-tab-active').removeClass('tab-inactive nav-tab-inactive');
		
			/* Add active class to the selected tab and header item*/
			$(this).addClass('a-active nav-tab-active');
			$(this).parent('li').addClass('li-active').removeClass('li-inactive');
	
			/* finaly, show the tab */
			console.log(qNR);
			$('#' + qNR, tabContainer).show();
		},
		/**
		 * Show and hide elements based on which opttion is selected
		 * @param string select_box	The selector for the html select object
		 * @param array mapping		(optional) The mapping 
		 */
		mapChangeSelect: function(select_box,mapping){
			$(select_box).bind('change click onblur keyup', 
				function(){
					var t = this;
					var topic = $(t).closest('select').val();

					if (typeof mapping === 'undefined') { mapping = [$(t).attr('id')]; }

					jQuery.each(mapping, function( index, value ) {
						$( '.' + value ).removeClass('topic-active').addClass('topic-inactive').hide();
						$( '#' + value + '-' + topic ).show().removeClass('topic-inactive').addClass('topic-active');
					});

			});

			$(select_box).trigger('click');
		},

		/**
		 * Greys out or make a target invible if a checkbox is set
		 *
		 */
		conditionalCheck: 	function(check, target,how){
			$(check).bind('change click onblur keyup', function(){
				var checked = $(this).closest('input').is(':checked');
				if (checked){
					$(target).show();
				} else {
					$(target).hide();
				}

			});
			$(check).trigger('click'); //let's freshen up
		},

		/**
		 * Bind jQuery Sorting
		 
		 */
		sortBind: function(target, sortee){
			$(target).sortable({ 
            	helper: 'clone'
	        });

		},
		sortItems: function(sortee){
	        jQuery(sortee).each(function(index,elem){
    			jQuery(elem).val('' + (index + 1));	
	    	});

	    	return true;
		}
	}

	/* Bind if not yet bound */
	$('.tab-header a').bind('click',ArevicoSimpleTab.showTab);
	
}

});