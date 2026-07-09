<?php
/*
Plugin Name: Animated Headline
Plugin URI: https://wordpress.org/plugins/animated-headline/
Description: A simple wordpress plugin for animated headlines using shortcode. [animated-headline title="Hello my friend" animated_text="Anshul,Harshali,Asha,Rahul" animation="rotate-1"]
Version: 5.0
Author: Anshul G
Author URI: https://profiles.wordpress.org/anshuln90/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 6.0
Requires PHP: 7.4
Text Domain: animated-headline
*/

define('AH_VERSION', '5.0');
define('AH_FILE', basename(__FILE__));
define('AH_NAME', str_replace('.php', '', AH_FILE));
define('AH_PATH', plugin_dir_path(__FILE__));
define('AH_URL', plugin_dir_url(__FILE__));
define('AH_HOMEPAGE', 'https://wordpress.org/plugins/animated-headline/');

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!class_exists('animated_headlines'))
{
	class animated_headlines
	{
		public function __construct()
		{
			require_once(sprintf("%s/settings.php", dirname(__FILE__)));
			$animated_headlines_settings = new animated_headlines_settings();

			$plugin = plugin_basename(__FILE__);
			add_filter("plugin_action_links_$plugin", array($this, 'plugin_action_links'));
			add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2);
		}

		public static function activate() {}
		public static function deactivate() {}

		public function plugin_action_links($links)
		{
			$new = array();
			$new[] = '<a href="options-general.php?page=animated-headlines">Settings</a>';
			$new[] = '<a href="https://www.paypal.me/anshulgangrade" target="_blank" style="color:#e06c00;font-weight:600;">&#9829; Donate</a>';
			return array_merge($new, $links);
		}

		public function plugin_row_meta($links, $file)
		{
			if($file === plugin_basename(__FILE__)){
				$links[] = '<a href="https://www.paypal.me/anshulgangrade" target="_blank">&#9829; Donate</a>';
			}
			return $links;
		}
	}
}

if(class_exists('animated_headlines'))
{
	register_activation_hook(__FILE__, array('animated_headlines', 'activate'));
	register_deactivation_hook(__FILE__, array('animated_headlines', 'deactivate'));
	$animated_headlines = new animated_headlines();
}
