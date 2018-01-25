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

	}


	/********************************
	 *      Un installation
	 ********************************/
	public static function deactivate()
	{

//	    wp_die('test this');
		delete_option( 'woocommerce-notification' );

    }
}
