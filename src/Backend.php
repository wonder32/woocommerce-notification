<?php

namespace WcNotify;

class Backend
{

	private $filter;

	public function __construct() {

		$this->check_for_updates();

		$this->startActivation();
		$this->filter = new Filter();

		// check if WooCommerce is active
		if (!$this->isWoocommerceActive()) {
			$this->filter->add_action( 'admin_notices', $this, 'error_notice' );
			$this->filter->run();
			return;
		}

		// install update progress
        $this->filter->add_action( 'upgrader_process_complete', $this, 'upgrade_completed', 10, 2 );
        $this->filter->add_action( 'admin_notices', $this, 'display_update_notice' );

		// activate Notice system
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
				require WC_NOTIFY_DIR . 'vendor/plugin-update-checker/plugin-update-checker.php';
			}
			$notification_update_checker = \Puc_v4_Factory::buildUpdateChecker(
				'https://plugins.puddinq.com/updates/?action=get_metadata&slug=woocommerce-notification',
				WC_NOTIFY_FILE
			);
		}

	}

	public function display_update_notice() {
        // Check the transient to see if we've just updated the plugin
        if( get_transient( 'woocommerce_notification_update' ) ) {
            echo '<div class="notice notice-success">' . __( 'Thanks for updating', 'woocommerce-notification' ) . '</div>';
            delete_transient( 'woocommerce_notofication_up' );

            update_option('woocommerce-notification', array('activated' => array('wcnotify_sound' => 'wcnotify_sound', 'wcnotify_visual' => 'wcnotify_visual')));
            update_option('woocommerce-notification-sound', array('sound' => 'bell'));
            update_option('woocommerce-notification-visual', array('visual' => 'background'));
        }
    }

    function upgrade_completed( $upgrader_object, $options ) {
        // The path to our plugin's main file
        $our_plugin = plugin_basename( WC_NOTIFY_FILE );
        // If an update has taken place and the updated type is plugins and the plugins element exists
        if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
            // Iterate through the plugins being updated and check if ours is there
            foreach( $options['plugins'] as $plugin ) {
                if( $plugin == $our_plugin ) {
                    // Set a transient to record that our plugin has just been updated
                    set_transient( 'woocommerce_notofication_up', 1 );
                }
            }
        }
    }

    /**
     * Check if WooCommerce is activated
     *
     * @return bool
     */
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
		load_plugin_textdomain( 'woocommerce-notification', false, dirname( plugin_basename(WC_NOTIFY_FILE) ) . '/i18n/languages/' );

	}

	public function error_notice() {

		$class = 'notice notice-error';
		$message = __( 'WooCommerce notification : WooCommerce needs to installed and activated.', 'woocommerce-notification' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}

	public function startActivation() {
		register_activation_hook(WC_NOTIFY_FILE, array('WcNotify\DeActivate', 'activate'));
		register_deactivation_hook(WC_NOTIFY_FILE, array('WcNotify\DeActivate', 'deactivate'));
	}

	public function loadAdminPage() {

		$admin_page = new AdminPage;

	}
}