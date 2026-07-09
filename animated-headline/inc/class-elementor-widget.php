<?php
/**
 * Animated Headline - Elementor Widget
 * Version: 2.1.0
 */
if(!defined('ABSPATH')) exit;

class Animated_Headline_Elementor_Widget extends \Elementor\Widget_Base
{
	public function get_name()
	{
		return 'animated_headline';
	}

	public function get_title()
	{
		return __('Animated Headline', 'animated-headline');
	}

	public function get_icon()
	{
		return 'eicon-animated-headline';
	}

	public function get_categories()
	{
		return array('general');
	}

	public function get_keywords()
	{
		return array('animated', 'headline', 'text', 'rotating');
	}

	// Tell Elementor to load our JS when this widget is on the page
	public function get_script_depends()
	{
		return array('animated-headline');
	}

	// Tell Elementor to load our CSS when this widget is on the page
	public function get_style_depends()
	{
		return array('animated-headline');
	}

	protected function register_controls()
	{
		/* ---- Content Section ---- */
		$this->start_controls_section('section_content', array(
			'label' => __('Content', 'animated-headline'),
		));

		$this->add_control('title', array(
			'label'   => __('Title Text', 'animated-headline'),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __('Hello my friend', 'animated-headline'),
		));

		$this->add_control('animated_text', array(
			'label'       => __('Animated Words', 'animated-headline'),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Awesome,Amazing,Cool',
			'description' => __('Comma separated words', 'animated-headline'),
		));

		$this->add_control('animation', array(
			'label'   => __('Animation Style', 'animated-headline'),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'rotate-1',
			'options' => animated_headlines_settings::get_animation_options(),
		));

		$this->add_control('tag', array(
			'label'   => __('HTML Tag', 'animated-headline'),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'h1',
			'options' => array(
				'h1'  => 'H1',
				'h2'  => 'H2',
				'h3'  => 'H3',
				'h4'  => 'H4',
				'h5'  => 'H5',
				'h6'  => 'H6',
				'div' => 'DIV',
			),
		));

		$this->end_controls_section();

		/* ---- Timing Section ---- */
		$this->start_controls_section('section_timing', array(
			'label' => __('Timing', 'animated-headline'),
		));

		$this->add_control('delay', array(
			'label'   => __('Delay (ms)', 'animated-headline'),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'default' => 2500,
			'min'     => 500,
			'max'     => 8000,
			'step'    => 100,
		));

		$this->add_control('speed', array(
			'label'   => __('Speed (ms)', 'animated-headline'),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'default' => 600,
			'min'     => 100,
			'max'     => 3000,
			'step'    => 50,
		));

		$this->end_controls_section();
	}

	protected function render()
	{
		$s = $this->get_settings_for_display();
		$sc = sprintf(
			'[animated-headline title="%s" animated_text="%s" animation="%s" tag="%s" delay="%s" speed="%s"]',
			esc_attr($s['title']),
			esc_attr($s['animated_text']),
			esc_attr($s['animation']),
			esc_attr($s['tag']),
			esc_attr($s['delay']),
			esc_attr($s['speed'])
		);
		echo do_shortcode($sc);
	}
}
