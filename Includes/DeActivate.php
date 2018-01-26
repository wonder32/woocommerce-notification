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

		add_option('woocommerce-notification');
		add_option('woocommerce-notification-sound');
		add_option('woocommerce-notification-visual');

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
