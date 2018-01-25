<?php

namespace Wcnotify\Includes;

class AdminPage
{

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
        echo '<h2>Woocommerce Notofications</h2>';
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
			    'title' => __( 'Types of notofication.', 'woocommerce-notification' ),
			    'desc' => __( 'select the types of notofication you would like te activate', 'woocommerce-notification' ),
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
				    'wcnotify_sound' => __( 'Activate sound notofocation.', 'woocommerce-notification' ),
				    'wcnotify_visual'  =>  __( 'Activate visual notification.', 'woocommerce-notification' )
			    )
		    )
	    );

    }

}

