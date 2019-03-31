<?php

namespace WcNotify;

class AdminPage
{

    private $settings;

    public function __construct()
    {
        $this->create_page();
        $this->registerOptions();
    }

    // register menu
    public function create_page()
    {
	    add_submenu_page(
		    'woocommerce',
		    __( 'Woocommerce Notifications', 'woocommerce-notification' ),
		    __( 'Notifications', 'woocommerce-notification' ),
		    'manage_options',
		    'woocommerce-notification',
		    array($this, 'pageOutput') //function
	    );

    }

    // page output
    public function pageOutput()
    {
        echo '<div class="wrap">';
        echo '<h2>Woocommerce Notifications</h2>';
	    $this->settings->show_navigation();
	    $this->settings->script();
	    $this->settings->show_forms();

        echo '</div>';
    }

    public function registerOptions() {

	    $this->settings = new Settings();

	    // Section: Basic Settings.
	    $this->settings->add_section(
		    array(
			    'id'    => 'woocommerce-notification',
			    'title' => __( 'Types of notification.', 'woocommerce-notification' ),
			    'desc'  => __( 'select the types of notification you would like te activate',
				    'woocommerce-notification' ),
		    )
	    );

	    $this->settings->add_field(
		    'woocommerce-notification',
		    array(
			    'id'      => 'activated',
			    'type'    => 'multicheck',
			    'name'    => __( 'Select parts', 'woocommerce-notification' ),
			    'desc'    => __( 'You need to save the settings before they take effect.', 'woocommerce-notification' ),
			    'options' => array(
				    'wcnotify_sound'  => __( 'Activate sound notification.', 'woocommerce-notification' ),
				    'wcnotify_visual' => __( 'Activate visual notification.', 'woocommerce-notification' )
			    )
		    )
	    );

	    $settings = get_option( 'woocommerce-notification' );

	    if ( isset( $settings['activated']['wcnotify_sound'] ) ) {
		    // Section: Sound Settings.
		    $this->settings->add_section(
			    array(
				    'id'    => 'woocommerce-notification-sound',
				    'title' => __( 'Sound effect', 'woocommerce-notification' ),
				    'desc'  => __( 'select the types of notification you would like te activate', 'woocommerce-notification' ),
			    )
		    );

		    $this->settings->add_field(
			    'woocommerce-notification-sound',
			    array(
				    'id'   => 'sound',
				    'type' => 'select',
				    'name' => __( 'Sound', 'woocommerce-notification' ),
				    'desc' => __( 'A Dropdown list', 'woocommerce-notification' ),
				    'options' => array(
					    'bell' => __( 'Bell', 'woocommerce-notification' ),
					    'bird'  => __( 'Bird', 'woocommerce-notification' ),
					    'emergency'  => __( 'Emergency', 'woocommerce-notification' ),
					    'phone'  => __( 'Phone', 'woocommerce-notification' ),
				    )
			    )
		    );
	    }

	    // Section: Visual Settings.
	    if ( isset( $settings['activated']['wcnotify_visual'] ) ) {

		    $this->settings->add_section(
			    array(
				    'id'    => 'woocommerce-notification-visual',
				    'title' => __( 'Visual effect.', 'woocommerce-notification' ),
				    'desc'  => __( 'select the types of notification you would like te activate',
					    'woocommerce-notification' ),
			    )
		    );

		    $this->settings->add_field(
			    'woocommerce-notification-visual',
			    array(
				    'id'   => 'visual',
				    'type' => 'select',
				    'name' => __( 'Visual', 'woocommerce-notification' ),
				    'desc' => __( 'Select the background color for the rows with newly placed orders. If you want to disable this you can in the first screen.', 'woocommerce-notification' ),
				    'options' => array(
					    'yellow'      => __( 'Yellow Background', 'woocommerce-notification' ),
					    'red'         => __( 'Red Background', 'woocommerce-notification' ),
					    'grey'         => __( 'Grey Background', 'woocommerce-notification' ),
					    'contra'         => __( 'Contra Background', 'woocommerce-notification' )
				    )
			    )
		    );

	    }
    }

}

