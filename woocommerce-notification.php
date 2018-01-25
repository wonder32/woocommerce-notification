<?php
/*
Plugin Name: WooCommerce Notification
Plugin URI: https://www.puddinq.com/plugins/woocommerce-notification/
Description: Get sound notification in order view when order is made
Version: 0.0.1
Author: Wonder32
Author URI: www.puddinq.mobi/wip/stefan-schotvanger
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: woocommerce-notification
*/

use Wcnotify\Includes\Backend;


// die if called direct
if ( ! defined('WPINC')) {
	die;
}

// autoloader
require_once 'vendor/autoload.php';


/************************************
 *      CONSTANTS
 ************************************/

define ('WCNOTIFYDIR', plugin_dir_path(__FILE__));
define ('WCNOTIFYFILE', __FILE__);

/********************** **************
 *      LOAD FILES
 ************************************/


// start the show
if( is_admin() ) {
	// Settingspage, Errorpage
	$backend = new Backend;
}