<?php

namespace Wcnotify\Includes;

class Backend
{

	private $filter;

	public function __construct() {

		$this->check_for_updates();

		$this->startActivation();
		$this->filter = new Filter();

		if (!$this->isWoocommerceActive()) {
			$this->filter->add_action( 'admin_notices', $this, 'error_notice' );
			$this->filter->run();
			return;
		}

		$this->orderNotices();

		$this->filter->add_action( 'plugins_loaded', $this, 'load_textdomain' );
		$this->filter->add_action( 'admin_menu', $this, 'loadAdminPage' );
		$this->filter->run();

	}

	public function check_for_updates()
	{
		// only load file if it has not been loaded
		if (is_admin()) {
			if( !class_exists( '\Puc_v4_Factory' ) ) {
				require WCNOTIFYDIR . 'vendor/plugin-update-checker/plugin-update-checker.php';
			}
			$notification_update_checker = \Puc_v4_Factory::buildUpdateChecker(
				'https://plugins.puddinq.com/updates/?action=get_metadata&slug=woocommerce-notification',
				WCNOTIFYFILE
			);
		}

	}

	public function isWoocommerceActive() {
		$woocommerce_plugin = 'woocommerce/woocommerce.php';
		$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

		if (in_array($woocommerce_plugin, $active_plugins)) {
			return true;
		}

		return false;

	}

	public function orderNotices() {
		$orderNotices = new Notification;
	}


	public function load_textdomain() {
		load_plugin_textdomain( 'woocommerce-notification', false, dirname( plugin_basename(WCNOTIFYFILE) ) . '/languages/' );

	}

	public function error_notice() {

		$class = 'notice notice-error';
		$message = __( 'Woocommerce needs to installed and activated.', 'woocommerce-notification' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}

	public function startActivation() {
		register_activation_hook(WCNOTIFYFILE, array('Wcnotify\Includes\DeActivate', 'activate'));
		register_deactivation_hook(WCNOTIFYFILE, array('Wcnotify\Includes\DeActivate', 'deactivate'));
	}

	public function loadAdminPage() {

		$admin_page = new AdminPage;

	}
}