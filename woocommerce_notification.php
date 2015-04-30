<?php
/*
Plugin Name: Woocommerce Notification
Plugin URI: http://www.puddinq.mobi
Description: Get sound notification in order view when order is made
Version: 0.0.1
Author: Wonder32
Author URI: www.puddinq.mobi/wip/stefan-schotvanger
*/

//if(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	if (!class_exists( 'woocommerce_notification' ) ) {
		
		class woocommerce_notification{
			
			private $notification;
			
			public function __construct(){
				add_action('manage_shop_order_posts_custom_column', array($this, 'order_notification'), 10, 2);
			}
			
			public function order_notification(){
				if(empty($this->notification)){
					$this->notification = plugin_dir_url( __FILE__ ) .'notification.mp3';
					wp_register_script('order_notification_js', plugin_dir_url( __FILE__ ) . '/js/order_notification.js', array('jquery') );
                                        wp_enqueue_script('order_notification_js');
					wp_register_style('order_notification_css',  plugin_dir_url( __FILE__ ) . '/css/order_notification.css' );
                                        wp_enqueue_style('order_notification_css');
					wp_localize_script('order_notification_js', 'notification', array('sound' => $this->notification));
				}
			}
		}
	}

	new woocommerce_notification();
//}
