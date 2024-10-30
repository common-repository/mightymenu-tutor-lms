<?php
/*
Plugin Name: Tutor LMS - Personalized Sidebar Lite
Plugin URI: https://userelements.com/mightymenu-tutorlms
Description: Add a smart off-canvas vertical menu or sidebar to your Tutor LMS site, making it easier for users to navigate through courses and content.
Version: 1.3
Author: User Elements
Author URI: https://userelements.com/
Text Domain: mightymenu-tutor
Domain Path: /languages
*/

require_once 'inc/magic-menu-customize.php';
require_once 'view/appbar.view.php';

/**
 * The MightyMenu_Tutor_Lite_Main class provides functionality to register and enqueue assets,
 * add row meta and plugin action links for the MightyMenu Tutor LMS Lite plugin.
 * @package MightyMenu_Tutor_Lite_Main
 */
class MightyMenu_Tutor_Lite_Main {

    /**
     * Initializes the class by adding hooks for registering assets, adding row meta and plugin action links.
     */
    public function __construct()
    {
        add_action( 'init', array( $this, 'register_assets' ) );
        add_filter( 'plugin_row_meta', array( $this, 'add_row_meta' ), 10, 2 );
        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'add_plugin_action_links' ) );
    }

    /**
     * Registers the assets for the plugin.
     */
    public function register_assets()
    {
        $version = '1.0.0';
        $plugin_dir_url = plugin_dir_url(__FILE__);

        wp_register_script(
            'mightymenu-script',
            $plugin_dir_url . 'assets/js/mightymenu-tutor.js',
            [],
            $version,
            true
        );

        wp_register_style(
            'mightymenu-style',
            $plugin_dir_url . 'assets/css/mightymenu-tutor.css',
            [],
            $version
        );

        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    /**
     * Enqueues the registered assets for the plugin.
     */
    public function enqueue_assets()
    {
        wp_enqueue_script('mightymenu-script');
        wp_enqueue_style('mightymenu-style');
    }

    /**
     * Adds row meta for the plugin.
     *
     * @param array  $links An array of plugin row meta links.
     * @param string $file  The plugin file path.
     *
     * @return array An array of plugin row meta links.
     */
    public function add_row_meta($links, $file)
    {
        if (plugin_basename(__FILE__) === $file) {
            $links[] = '<a href="https://userelements.com">Visit Website</a>';
        }

        return $links;
    }

    /**
     * Adds plugin action links for the plugin.
     *
     * @param array $links An array of plugin action links.
     *
     * @return array An array of plugin action links.
     */
    public function add_plugin_action_links($links)
    {
        $links['pro_link'] =
            '<a href="https://userelements.com/mightymenu-tutorlms/" target="_blank">
                <span style="color: #ff7742; font-weight: bold;">' .
                    __('Upgrade to Pro', 'mightymenu-tutor') .
                '</span>
            </a>';

        return $links;
    }
}

new MightyMenu_Tutor_Lite_Main();



add_action( 'wp_ajax_dismiss_my_notice', 'mighty_tutor_dismiss_notice_callback' );
add_action( 'admin_notices', 'mighty_tutor_dismissible_notice' );

function mighty_tutor_dismissible_notice() {
    if ( ! get_user_meta( get_current_user_id(), 'mighty_tutor_notice_dismissed', false ) ) {
        ?>
        <div class="notice notice-info is-dismissible um-elemetor-pro">
            <h4><?php _e( 'Upgrade Tutor LMS - Personalized Sidebar', 'mightymenu-tutor' ); ?></h4>

                <p><?php _e( '<strong>Get Access to</strong>', 'mightymenu-tutor' ) ?></p>

                <ul>
                    <li><?php _e( 'Interactive Course Progress Visualization', 'mightymenu-tutor' ) ?></li>
                    <li><?php _e( 'Quiz Attempts', 'mightymenu-tutor' ) ?></li>
                    <li><?php _e( 'Completed Course', 'mightymenu-tutor' ) ?></li>
                    <li><?php _e( 'Q&A', 'mightymenu-tutor' ) ?></li>
                    <li><?php _e( 'Wishlisted Course', 'mightymenu-tutor' ) ?></li>
                </ul>
                <p>
                    <a href="https://userelements.com/mightymenu-tutorlms/" class="button button-primary" target="_blank">
                        <?php _e( 'Unlock more features', 'mightymenu-tutor' ) ?>
                    </a>
                </p>


            <button type="button" class="notice-dismiss" onclick="dismissNotice();">
                <span class="screen-reader-text"><?php _e( 'Dismiss this notice', 'mightymenu-tutor' ); ?></span>
            </button>
        </div>
        <script>
            function dismissNotice() {
                jQuery.post( ajaxurl, {
                    action: 'dismiss_my_notice',
                    _wpnonce: '<?php echo wp_create_nonce( 'dismiss_my_notice' ); ?>'
                } );
            }
        </script>
        <style type="text/css">
            .um-elemetor-pro{background-color:#e5d5ff;border-left-color:#7b61ff}.um-elemetor-pro .button-primary{background-color:#7b61ff!important;border:none!important}.um-elemetor-pro ul{list-style:disc;margin-left:1rem}

        </style>
        <?php
    }
}

function mighty_tutor_dismiss_notice_callback() {
    if ( check_ajax_referer( 'dismiss_my_notice', '_wpnonce' ) ) {
        update_user_meta( get_current_user_id(), 'mighty_tutor_notice_dismissed', true );
    }
    wp_die();
}