<?php

/*******************************
 *      Installation
 *******************************/


namespace Wcnotify\Includes;

class DeActivate
{

	/********************************
	 *      Un installation
	 ********************************/
	public static function activate()
	{

		add_option('woocommerce-notification', array('activated' => array('wcnotify_sound' => 'wcnotify_sound', 'wcnotify_visual' => 'wcnotify_visual')));
		add_option('woocommerce-notification-sound', array('sound' => 'bell'));
		add_option('woocommerce-notification-visual', array('visual' => 'background'));


	}


	/********************************
	 *      Un installation
	 ********************************/
	public static function deactivate()
	{

//	    wp_die('test this');
		delete_option( 'woocommerce-notification' );
		delete_option( 'woocommerce-notification-sound' );
		delete_option( 'woocommerce-notification-visual' );

    }
}
