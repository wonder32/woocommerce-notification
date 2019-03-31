<?php

namespace WcNotify;

class Notification
{

    private $filter;

    private $settings;

    private $sound;

    public function __construct()
    {

        $this->filter = new Filter();

        $this->settings = get_option('woocommerce-notification');
        $this->sound = get_option('woocommerce-notification-sound');

        $this->filter->add_action('current_screen', $this, 'orderScreen');

        $this->filter->add_action('admin_notices', $this, 'hide_play_button');

        //$this->filter->add_action( 'manage_shop_order_posts_custom_column', $this, 'order_notification' );

        $this->filter->run();
    }

    public function orderScreen()
    {
        $current_screen = get_current_screen();
        if (is_object($current_screen) && isset($current_screen->id) && $current_screen->id === 'edit-shop_order') {

            $this->order_notification();
        }
    }

    public function hide_play_button()
    {
        $current_screen = get_current_screen();
        if (is_object($current_screen) && isset($current_screen->id) && $current_screen->id === 'edit-shop_order') {

                $sound_class = isset($this->settings['wcnotify_sound']) ? 'notification-sound' : '';

            echo "<div id='notification_container' style='display:none'>" . PHP_EOL;
            echo "<a class='button button-primary button-hero button-notification {$sound_class}' href='#' id='stop_notification'><strong>" . __('Stop', 'woocommerce-notification') . " </strong></a>" . PHP_EOL;

            if (isset($this->settings['activated']['wcnotify_sound'])) {
                echo "<a class='button button-primary button-hero button-notification {$sound_class}' href='#' id='mute_notification'><strong>" . __('Mute', 'woocommerce-notification') . " </strong></a>" . PHP_EOL;
            }
            echo "</div>" . PHP_EOL;

            echo "<div id='notification_counter'>" . PHP_EOL;
            echo "</div>" . PHP_EOL;

        }
    }

    public function order_notification()
    {

		$settings = get_option('woocommerce-notification');

        $sound = '';

        if (isset($settings['activated']['wcnotify_sound'])) {

            $sound = get_option('woocommerce-notification-sound');
            $sound['sound'] = plugin_dir_url(WC_NOTIFY_FILE) . 'assets/sound/' . $sound['sound'] . '.mp3';
            $sound['activated'] = 'yes';
        }

        $visual = '';

        if (isset($settings['activated']['wcnotify_visual'])) {
            $visual = get_option('woocommerce-notification-visual');
            $visual['activated'] = 'yes';
        }


        wp_register_style('order_notification_css', plugin_dir_url(WC_NOTIFY_FILE) . 'assets/css/order-notification.css');
        wp_enqueue_style('order_notification_css');
        wp_register_script('order_notification_js', plugin_dir_url(WC_NOTIFY_FILE) . 'assets/js/order-notification.js', true);
        wp_enqueue_script('order_notification_js');
        wp_localize_script('order_notification_js', 'notification', array('sound' => $sound, 'visual' => $visual));
    }

}

