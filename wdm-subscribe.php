<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://github.com/RajatWisdm/
 * @since             1.0.0
 * @package           Wdm_Subscribe
 *
 * @wordpress-plugin
 * Plugin Name:       WDM Subscribe
 * Plugin URI:        https://https://github.com/RajatWisdm/wdm_subscribe
 * Description:       A plugin that stores user email and notify them
 * Version:           1.0.0
 * Author:            Rajat Ganguly
 * Author URI:        https://https://github.com/RajatWisdm/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wdm-subscribe
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WDM_SUBSCRIBE_VERSION', '1.0.0');


class WdmSub
{
	public $plugin;

	function __construct()
	{
		$this->plugin = plugin_basename(__FILE__);
	}

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-wdm-subscribe-activator.php
	 */
	function activate_wdm_subscribe()
	{
		require_once plugin_dir_path(__FILE__) . 'includes/class-wdm-subscribe-activator.php';
		Wdm_Subscribe_Activator::activate();
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-wdm-subscribe-deactivator.php
	 */
	function deactivate_wdm_subscribe()
	{
		require_once plugin_dir_path(__FILE__) . 'includes/class-wdm-subscribe-deactivator.php';
		Wdm_Subscribe_Deactivator::deactivate();
	}

	function register()
	{
		// ADDING SETTINGS PAGE
		add_action('admin_menu', [$this, 'add_admin_pages']);

		add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
	}

	public function settings_link($links)
	{
		$settings_link = '<a href="admin.php?page=plugin_one">Settings</a>';
		array_push($links, $settings_link);
		return $links;
	}

	function add_admin_pages()
	{
		add_menu_page('WDM Subscribe', 'WDM Subscribe', 'manage_options', 'wdm_sub', array($this, 'admin_page_markup'), 'dashicons-mail-alt', 100);
		// add_submenu_page('wdm_sub', 'Add Plan', 'Add Plan', 'manage_options', 'add_plan', array($this, 'add_page_markup'));
	}

	function admin_page_markup()
	{
		require_once plugin_dir_path(__FILE__) . 'templates/calendar.php';
	}
}

function wdm_send_mail($email)
{
    $subject = 'Congratulations! You are Subscribed';
    $summary = get_daily_post_summary();
    $message = 'You are Successfully added to our Daily Update List';
    $message .= "\n\n";
    $message .= "Here are our Top latest Posts";
    $message .= "\n";
    foreach ($summary as $post_data) {
        $message .= 'Title: ' . $post_data['title'] . "\n";
        $message .= 'URL: ' . $post_data['url'] . "\n";
        $message .= "\n";
    }

    $headers = array(
        'From: wisdm@shilavilla.com',
        'Content-Type: text/html; charset=UTF-8'
    );

    wp_mail($email, $subject, $message, $headers);
};

// function wdm_form_shortcode() { 
  
	
// 	$wdm_form = '
// 	<form>
// 	<div class="mb-3">
// 	  <label for="exampleInputEmail1" class="form-label">Email address</label>
// 	  <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
// 	  <div id="emailHelp" class="form-text">We will never share your email with anyone else.</div>
// 	</div>
// 	<button type="submit" class="btn btn-primary">Submit</button>
//   </form>
// 	'; 

	
	  
// 	// Output needs to be return
// 	return $wdm_form;
// 	}
	// register shortcode
	add_shortcode('wdmsub', 'wdm_form_shortcode');
// register_activation_hook( __FILE__, 'activate_wdm_subscribe' );
// register_deactivation_hook( __FILE__, 'deactivate_wdm_subscribe' );


 function wdm_form_shortcode() { 
  
	// Things that you want to do.
	$message = '<form method="post">
	<div class="mb-3">
	  <label for="exampleInputEmail1" class="form-label">Email address</label>
	  <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
	  <div id="emailHelp" class="form-text">We will never share your email with anyone else.</div>
	</div>
	<button type="submit" class="btn btn-primary">Submit</button>
  </form>
	'; 
	if (isset($_POST['email'])) {
        $email = sanitize_email($_POST['email']);
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        if (preg_match($pattern, $email)) {
            if (isset($_POST['submit'])) {

                $subs_emails = get_option('subs_emails');

                if (!$subs_emails) {
                    $subs_emails = array();
                }

                if (in_array($email, $subs_emails)) {
                    echo '<script>alert("You are already subscribed!");</script>';
                } else {
                    $subs_emails[] = $email;
                    update_option('subs_emails', $subs_emails);

                    // Display a success message
                    echo '<script>alert("You have been subscribed Successfully!");</script>';

                    wdm_send_mail($email);
                }
            }
        } else {
            //Display Error Message
            echo '<div class="error"><p>Your email id is not valid! Please try again</p></div>';
        }
    }
	  
	// Output needs to be return
	return $message;
	}
	// register shortcode
	add_shortcode('greeting', 'wdm_form_shortcode');
	
	wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css');
	wp_enqueue_style('bootstrap');
	wp_register_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js');
	wp_enqueue_script('bootstrap');

	if (isset($_POST['email'])) {
        $email = sanitize_email($_POST['email']);
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        if (preg_match($pattern, $email)) {
            if (isset($_POST['submit'])) {

                $subs_emails = get_option('subs_emails');

                if (!$subs_emails) {
                    $subs_emails = array();
                }

                if (in_array($email, $subs_emails)) {
                    echo '<script>alert("You are already subscribed!");</script>';
                } else {
                    $subs_emails[] = $email;
                    update_option('subs_emails', $subs_emails);

                    // Display a success message
                    echo '<script>alert("You have been subscribed Successfully!");</script>';

                    wdm_send_mail($email);
                }
            }
        } else {
            //Display Error Message
            echo '<div class="error"><p>Your email id is not valid! Please try again</p></div>';
        }
    }
// if (class_exists('WdmSub')) {
// 	$sub = new WdmSub();

// 	// BOOTSTRAP CDN LINKING

// 	// CUSTOM STYLE
// 	wp_register_style('wdm-custom-style', './public/css/rajat-cal-public.css');
// 	wp_enqueue_style('wdm-custom-style');

// 	$sub->register();
// }
