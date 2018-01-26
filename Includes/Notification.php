<?php

namespace Wcnotify\Includes;

class Notification
{

	public function __construct(){
		$this->filter = new Filter();
		$this->filter->add_action( 'current_screen', $this, 'orderScreen' );
		//$this->filter->add_action( 'manage_shop_order_posts_custom_column', $this, 'order_notification' );
		$this->filter->run();
	}
	
	public function orderScreen() {
		$current_screen = get_current_screen();
		if (is_object($current_screen) && isset($current_screen->id) && $current_screen->id === 'edit-shop_order' ) {
			$this->order_notification();
		}
	}

	public function order_notification(){

		$settings = get_option('woocommerce-notification');

		$sound = '';
		if (isset($settings['activated']['wcnotify_sound'])) {
			$sound = plugin_dir_url( WCNOTIFYFILE ) . 'sound/notification.mp3';
		}

		$visual = '';
		if (isset($settings['activated']['wcnotify_visual'])) {
			$visual = true;
		}

		wp_register_style('order_notification_css',  plugin_dir_url( WCNOTIFYFILE ) . 'css/order_notification.css' );
		wp_enqueue_style('order_notification_css');
		wp_register_script('order_notification_js', plugin_dir_url( WCNOTIFYFILE ) . 'js/order_notification.js', true);
		wp_enqueue_script('order_notification_js');
		wp_localize_script('order_notification_js', 'notification', array('sound' => $sound, 'visual' => $visual));
	}

}

