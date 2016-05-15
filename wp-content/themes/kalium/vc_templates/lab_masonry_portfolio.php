<?php
/**
 *	Masonry Portfolio Items
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $lab_vc_portfolio_items_details;

$portfolio_type                 = 'type-2';
$lab_masonry_portfolio          = true;
$lab_vc_portfolio_items_details = array();

if(preg_match_all("/" . get_shortcode_regex() . "/", $content, $portfolio_items))
{
	foreach($portfolio_items[0] as $portfolio_item)
	{
		$portfolio_item = preg_replace( "/^\[[^\s]+/i", "", substr( $portfolio_item, 0, -1 ) );
		$portfolio_item = $this->prepareAtts( shortcode_parse_atts( $portfolio_item ) );
		
		$lab_vc_portfolio_items_details[] = $portfolio_item;
	}
}

include locate_template( 'vc_templates/lab_portfolio_items.php' );
