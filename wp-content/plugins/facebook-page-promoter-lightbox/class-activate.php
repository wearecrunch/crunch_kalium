<?php 
/**
 * Class to install database tables on installation and cleanup on uninstall
 */
class arvlbActivate
{
	
	/**
	 * Procedures to be executed on deactivation. Output in errors or echos will result
	 * in php: unexpected character warnings.
	 * @return type
	 */
	public static function on_activate(){
	    $o 		= get_option('arv_fb24_opt',array());

	    $def 	= arvlbSHARED::getDefaults();
	    if (empty($o)){
	    	update_option('arv_fb24_opt', $def);

	    }

		return;
	}

	/**
	 * Procedures to be executed on deactivation. Output in errors or echos will result
	 * in php: unexpected character warnings.
	 * @return type
	 */
	public static function on_deactivate(){
		return;
	}
} 


?>