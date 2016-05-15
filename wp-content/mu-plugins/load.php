<?php
/**
 * Plugin Name: Load must use plugins
 * Description: This is file that loads must use plugins
 * Author: Vayu Robins
 * Author URI: http://flashkompagniet.dk
 * Version: 0.1.0
 */

// Load custom post types plugin
require WPMU_PLUGIN_DIR.'/simple-custom-types/simple-custom-types.php';
require WPMU_PLUGIN_DIR.'/simple-taxonomy/simple-taxonomy.php';