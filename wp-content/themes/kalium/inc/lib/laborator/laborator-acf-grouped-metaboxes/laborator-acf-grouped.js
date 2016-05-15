;( function( $, window, undefined ) {
	"use strict";
	
	$( document ).ready( function() {
		
		if ( typeof lab_acf_metaboxes == 'object' ) {
			
			var initial_tab   	= 0,
				$wp_mb			= $( '.postbox-container #lab-acf-grouping-metabox' ),
				$container      = $( '.laborator-acf-grouped-container' ),
				$tabs           = $container.find( '.lab-acf-grouped-tabs' ),
				$tabs_container = $container.find( '.lab-acf-grouped-tabs-container' );
			
			for ( var i in lab_acf_metaboxes ) {
				var metabox        = lab_acf_metaboxes[ i ],
					browseby 	   = $( '#acf_' + metabox.slug ).length ? 'slug' : 'id',
					metabox_dom_id = '#acf_' + ( browseby == 'slug' ? metabox.slug : metabox.id ),
					$metabox       = $( metabox_dom_id );
				
				if ( $metabox.length == 1 ) {
					metabox.domId = metabox_dom_id;
					metabox.$metabox = $metabox;
					
					// Create Tab ID
					var $tab_id    	  = $( '<li><a></a></li>' ),
						$tab_icon	  = $( '<i class="fa"></i>' ),
						$tab_link     = $tab_id.find( 'a' ),
						tab_id        = browseby == 'slug' ? metabox.slug : metabox.id,
						tab_title     = $metabox.find( '> h2 > span, > h3 > span' ).html();
					
					$tab_link.html( tab_title.replace( /\(.*/, '' ) ).attr( {
						href: '#acf_' + tab_id,
						title: tab_title
					} );
					
					if ( metabox.icon ) {
						$tab_icon.addClass( 'fa-' + metabox.icon ).prependTo( $tab_link );
					}
					
					// Initialize Data on DOM
					$tab_id.data( 'metabox', metabox );
					
					if ( $metabox.hasClass( 'acf-hidden' ) == false ) {
						$tab_id.addClass( 'visible' );
					}
					
					$tabs.append( $tab_id );
					
					// Assign Tab ID
					metabox.$tabId = $tab_id;
					
					// Append Metabox
					$metabox.appendTo( $tabs_container );
				}
			}
			
			
			// API
			var setActiveTab = function( active_metabox ) {
				
				if ( typeof active_metabox == 'object' ) {
					
					for ( var i in lab_acf_metaboxes ) {
						var metabox = lab_acf_metaboxes[ i ];
						
						if ( metabox.$metabox.is( ':visible' ) ) {
							metabox.$metabox.removeClass( 'lab-acf-visible' );
						}
					}
					
					$tabs.find( 'li' ).removeClass( 'active' );
					
					active_metabox.$metabox.addClass( 'lab-acf-visible' );
					active_metabox.$tabId.addClass( 'active' );
				}
			}
			
			var checkAvailableTabs = function() {
				for ( var i in lab_acf_metaboxes ) {
					var metabox = lab_acf_metaboxes[ i ];
					
					if ( ! metabox.$metabox ) {
						continue;
					}
					
					if ( metabox.$metabox.hasClass( 'acf-hidden' ) == false ) {						
						// Show Metabox Tab
						if ( metabox.$tabId.hasClass( 'visible') == false ) {
							metabox.$tabId.addClass( 'visible' );
						}
					} else { 
						// Hide Metabox Tab
						if ( metabox.$tabId.hasClass( 'visible') == true ) {							
							metabox.$metabox.removeClass( 'lab-acf-visible' );
							metabox.$tabId.removeClass( 'visible' );
						}
					}
				}
				
				// If there is no active tab
				var $visible_tabs = $tabs.find( '> li.visible' );
				
				if ( $visible_tabs.length > 0 && $visible_tabs.filter( '.active' ).is( ':visible' ) == false ) {
					setActiveTab( $visible_tabs.eq( 0 ).data( 'metabox' ) );
				} else {
					if ( $visible_tabs.length == 0 ) {
						$container.addClass( 'hidden' );
					} else {
						$container.removeClass( 'hidden' );
					}
				}
				
				// Min height for content pane
				$tabs_container.css( 'min-height', $tabs.outerHeight() + 15 );
			}
			
			var labAcfLoadingPanels = function() {
				$wp_mb.addClass( 'loading-panels' );
				
				if ( typeof this.tm != 'undefined' ) {
					window.clearTimeout( this.tm );
				}
				
				this.tm = setTimeout( function() {
					if ( $wp_mb.hasClass( 'loading-panels' ) ) {
						labAcfLoadingPanelsFinished();
					}
				}, 2000 );
			}
			
			var labAcfLoadingPanelsFinished = function() {
				$wp_mb.removeClass( 'loading-panels' );
			}
			
			
			// Events
			$tabs.on( 'click', 'a', function( ev ) {
				ev.preventDefault();
				
				var $this = $( this ),
					$tab_id = $this.parent();
				
				setActiveTab( $tab_id.data( 'metabox' ) );
			} );
			
			$( document ).on( 'acf/update_field_groups', labAcfLoadingPanels );
			
			$( document ).ajaxComplete(function( event, request, settings ) {
				if ( settings.data.match( /acf%2Flocation/ ) ) {
					checkAvailableTabs();
					setTimeout( labAcfLoadingPanelsFinished, 150 );
				}
			} );
			
			$( document ).on( 'acf/setup_fields acf/update_field_groups', checkAvailableTabs );
			
			checkAvailableTabs();
			//setInterval( checkAvailableTabs, 500 );
			
			
			// Set Active tab
			var $active_tab_id = $tabs.find( 'li.visible' ).eq( initial_tab );
			
			if ( $active_tab_id.length ) {
				setActiveTab( $active_tab_id.data( 'metabox' ) );
			} else {
				$tabs.find( 'li.visible' ).first().find( 'a' ).click();
			}
			
			// Loaded
			$container.addClass( 'loaded' );
		}
		
	} );

} )( jQuery, window );