<?php 
/*
   Plugin Name: Facebook Page Promoter Lightbox
   Plugin URI:  http://http://wordpress.org/plugins/facebook-page-promoter-lightbox/faq/ 
   Description:  All your visitors should know about your facebook page and tell their friends. With this plugin you can display a preconfigured Facebook Page-Like Box inside a lightbox.
   Version: 3.4
   Author: Arevico
   Author URI: http://arevico.com/sp-facebook-lightbox-premium/
   Copyright: 2013, Arevico
*/


include dirname(__FILE__) .'/includes/class-moscow.php';

include dirname(__FILE__) .'/class-activate.php';
include dirname(__FILE__) .'/plugin.php';

register_activation_hook(__FILE__, array('arvlbActivate', 'on_activate') );

if (is_admin() ){
	include dirname(__FILE__) .'/admin.php';
	$arvlbAdmin 		= new arvlbAdmin();

} else {
  $arvlbFPPL = new arvlbFPPL();
}


 


 ?>