<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!class_exists('animated_headlines_settings'))
{
	class animated_headlines_settings
	{
		private $elementor_widget_registered = false;

		public function __construct()
		{
			add_action('init',                              array($this, 'register_assets'), 5);
			add_action('init',                              array($this, 'register_gutenberg_block'));
			add_action('admin_menu',                        array($this, 'add_menu'));
			add_action('wp_enqueue_scripts',                array($this, 'enqueue_assets'));
			add_action('admin_enqueue_scripts',             array($this, 'admin_assets'));
			add_action('vc_before_init',                    array($this, 'register_wpbakery_element'));
			add_action('elementor/widgets/register',        array($this, 'register_elementor_widget'));
			add_action('elementor/widgets/widgets_registered', array($this, 'register_elementor_widget'));

			add_shortcode('animated-headline', array($this, 'render_shortcode'));
			add_filter('widget_text', 'shortcode_unautop');
			add_filter('widget_text', 'do_shortcode');
		}

		/* -------------------------------------------------------
		 * ANIMATION OPTIONS
		 * ----------------------------------------------------- */
		public static function get_animation_options()
		{
			return array(
				'rotate-1'    => 'Rotate 1',
				'rotate-2'    => 'Rotate 2',
				'rotate-3'    => 'Rotate 3',
				'type'        => 'Type',
				'scale'       => 'Scale',
				'loading-bar' => 'Loading Bar',
				'slide'       => 'Slide',
				'clip'        => 'Clip',
				'zoom'        => 'Zoom',
				'push'        => 'Push',
			);
		}

		/* -------------------------------------------------------
		 * REGISTER (not enqueue) CSS + JS globally
		 * Gutenberg block style/view_script uses these handles
		 * ----------------------------------------------------- */
		public function register_assets()
		{
			wp_register_style(
				'animated-headline',
				AH_URL . 'css/style.css',
				array(),
				AH_VERSION
			);
			wp_register_script(
				'animated-headline',
				AH_URL . 'js/main.js',
				array('jquery'),
				AH_VERSION,
				true
			);
		}

		/* -------------------------------------------------------
		 * PERFORMANCE: Only enqueue on pages that need it
		 * ----------------------------------------------------- */
		public function enqueue_assets()
		{
			global $post;
			$load = false;

			if(is_singular() && is_a($post, 'WP_Post')){
				// Shortcode check
				if(has_shortcode($post->post_content, 'animated-headline')){
					$load = true;
				}
				// Gutenberg block check
				if(!$load && function_exists('has_block') && has_block('animated-headline/headline', $post)){
					$load = true;
				}
			}

			// Allow themes/plugins to force-load assets
			$load = apply_filters('animated_headline_load_assets', $load);

			if(!$load) return;

			wp_enqueue_style('animated-headline');
			wp_enqueue_script('animated-headline');
		}

		/* -------------------------------------------------------
		 * ADMIN ASSETS: Only on settings page
		 * ----------------------------------------------------- */
		public function admin_assets($hook)
		{
			if('settings_page_animated-headlines' !== $hook) return;

			wp_enqueue_style('animated-headline', AH_URL . 'css/style.css', array(), AH_VERSION);
			wp_enqueue_script('animated-headline', AH_URL . 'js/main.js', array('jquery'), AH_VERSION, true);
			wp_enqueue_style('animated-headline-admin', AH_URL . 'css/admin.css', array(), AH_VERSION);
			wp_enqueue_script('animated-headline-admin', AH_URL . 'js/admin.js', array('jquery', 'animated-headline'), AH_VERSION, true);
		}

		/* -------------------------------------------------------
		 * ADMIN MENU
		 * ----------------------------------------------------- */
		public function add_menu()
		{
			add_options_page(
				'Animated Headline',
				'Animated Headline',
				'manage_options',
				'animated-headlines',
				array($this, 'plugin_detail_page')
			);
		}

		public function plugin_detail_page()
		{
			if(!current_user_can('manage_options')){
				wp_die(__('You do not have sufficient permissions to access this page.', 'animated-headline'));
			}
			$animations = self::get_animation_options();
			include(sprintf('%s/inc/settings.php', dirname(__FILE__)));
		}

		/* -------------------------------------------------------
		 * GUTENBERG BLOCK
		 * ----------------------------------------------------- */
		public function register_gutenberg_block()
		{
			if(!function_exists('register_block_type')) return;

			wp_register_script(
				'animated-headline-block',
				AH_URL . 'js/block.js',
				array('wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-i18n'),
				AH_VERSION,
				true
			);

			wp_localize_script('animated-headline-block', 'AnimatedHeadlineBlock', array(
				'animations' => self::get_animation_options(),
			));

			register_block_type('animated-headline/headline', array(
				'editor_script'   => 'animated-headline-block',
				'style'           => 'animated-headline',
				'render_callback' => array($this, 'render_shortcode'),
				'attributes'      => array(
					'title'         => array('type' => 'string',  'default' => 'Hello my friend'),
					'animated_text' => array('type' => 'string',  'default' => 'Awesome,Amazing,Cool'),
					'animation'     => array('type' => 'string',  'default' => 'rotate-1'),
					'tag'           => array('type' => 'string',  'default' => 'h1'),
					'delay'         => array('type' => 'string',  'default' => ''),
					'speed'         => array('type' => 'string',  'default' => ''),
				),
			));
		}

		/* -------------------------------------------------------
		 * ELEMENTOR WIDGET
		 * ----------------------------------------------------- */
		public function register_elementor_widget($widgets_manager = null)
		{
			if($this->elementor_widget_registered) return;
			if(!did_action('elementor/loaded') || !class_exists('Elementor\Widget_Base')) return;

			$this->elementor_widget_registered = true;
			require_once AH_PATH . 'inc/class-elementor-widget.php';
			$widget = new Animated_Headline_Elementor_Widget();

			if($widgets_manager && method_exists($widgets_manager, 'register')){
				$widgets_manager->register($widget);
			} elseif(isset(\Elementor\Plugin::$instance->widgets_manager) && method_exists(\Elementor\Plugin::$instance->widgets_manager, 'register_widget_type')){
				\Elementor\Plugin::$instance->widgets_manager->register_widget_type($widget);
			}
		}

		/* -------------------------------------------------------
		 * WPBAKERY ELEMENT
		 * ----------------------------------------------------- */
		public function register_wpbakery_element()
		{
			if(!function_exists('vc_map')) return;

			$anim_values = array();
			foreach(self::get_animation_options() as $val => $label){
				$anim_values[$label] = $val;
			}

			vc_map(array(
				'name'     => __('Animated Headline', 'animated-headline'),
				'base'     => 'animated-headline',
				'category' => __('Content', 'animated-headline'),
				'icon'     => 'icon-wpb-ui-custom_heading',
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => __('Title', 'animated-headline'),
						'param_name'  => 'title',
					),
					array(
						'type'        => 'textfield',
						'heading'     => __('Animated Text', 'animated-headline'),
						'param_name'  => 'animated_text',
						'description' => __('Comma separated words e.g. Awesome,Amazing,Cool', 'animated-headline'),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __('Animation', 'animated-headline'),
						'param_name'  => 'animation',
						'value'       => $anim_values,
						'std'         => 'rotate-1',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => __('HTML Tag', 'animated-headline'),
						'param_name' => 'tag',
						'value'      => array('H1'=>'h1','H2'=>'h2','H3'=>'h3','H4'=>'h4','H5'=>'h5','H6'=>'h6','DIV'=>'div'),
						'std'        => 'h1',
					),
					array(
						'type'        => 'textfield',
						'heading'     => __('Delay (ms)', 'animated-headline'),
						'param_name'  => 'delay',
						'description' => __('Time between word changes. Default: 2500', 'animated-headline'),
					),
					array(
						'type'        => 'textfield',
						'heading'     => __('Speed (ms)', 'animated-headline'),
						'param_name'  => 'speed',
						'description' => __('Animation speed in ms. Default: 600', 'animated-headline'),
					),
				),
			));
		}

		/* -------------------------------------------------------
		 * SHORTCODE RENDER (backward compatible)
		 * ----------------------------------------------------- */
		public function render_shortcode($atts)
		{
			$atts = shortcode_atts(
				array(
					'title'         => '',
					'animation'     => 'rotate-1',
					'animated_text' => '',
					'tag'           => 'h1',
					'delay'         => '',
					'speed'         => '',
				),
				$atts,
				'animated-headline'
			);

			$allowed   = array_keys(self::get_animation_options());
			$title     = sanitize_text_field($atts['title']);
			$anim      = sanitize_key($atts['animation']);

			if(!in_array($anim, $allowed, true)) $anim = 'rotate-1';

			$words = $this->parse_animated_text($atts['animated_text']);

			// Add letters class for letter-by-letter animations
			if(in_array($anim, array('rotate-2','rotate-3','type','scale'), true)){
				$anim .= ' letters';
			}

			$tag = strtolower(sanitize_key($atts['tag']));
			if(!in_array($tag, array('h1','h2','h3','h4','h5','h6','div'), true)) $tag = 'h1';

			$data = '';
			$delay = absint($atts['delay']);
			$speed = absint($atts['speed']);
			if($delay > 0) $data .= ' data-delay="' . esc_attr($delay) . '"';
			if($speed > 0) $data .= ' data-speed="' . esc_attr($speed) . '"';

			$out  = '<' . tag_escape($tag) . ' class="cd-headline ' . esc_attr($anim) . '"' . $data . '>';
			$out .= '<span> ' . esc_html($title) . ' </span> ';
			$out .= '<span class="cd-words-wrapper">';
			foreach($words as $i => $word){
				$cls = ($i === 0) ? 'is-visible' : '';
				$out .= '<b class="' . esc_attr($cls) . '">' . esc_html($word) . '</b>' . "\n";
			}
			$out .= '</span></' . tag_escape($tag) . '>';

			return $out;
		}

		private function parse_animated_text($input)
		{
			$parts = explode(',', (string)$input);
			$parts = array_map('sanitize_text_field', $parts);
			$parts = array_map('trim', $parts);
			return array_values(array_filter($parts, 'strlen'));
		}
	}
}
