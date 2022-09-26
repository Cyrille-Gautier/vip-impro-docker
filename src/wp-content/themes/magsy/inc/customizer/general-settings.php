<?php

Magsy_Kirki::add_section( $kirki_prefix . 'general_settings', array(
	'title' => esc_html__( 'General Settings', 'magsy' ),
  'priority' => 10,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'radio',
	'settings' => $kirki_prefix . 'latest_layout',
	'label' => esc_html__( 'Latest posts layout', 'magsy' ),
	'section' => $kirki_prefix . 'general_settings',
	'default' => 'list',
	'multiple' => 1,
	'choices' => array(
		'list' => esc_html__( 'List', 'magsy' ),
		'grid' => esc_html__( 'Grid', 'magsy' ),
	),
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'color',
	'settings' => $kirki_prefix . 'color_accent',
	'label' => esc_html__( 'Accent color', 'magsy' ),
  'section' => $kirki_prefix . 'general_settings',
  'output' => array(
    array(
      'element' => array( 'html' ),
      'property' => '--accent-color',
		),
  ),
  'transport' => 'auto',
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'radio',
	'settings' => $kirki_prefix . 'pagination',
	'label' => esc_html__( 'Pagination', 'magsy' ),
	'section' => $kirki_prefix . 'general_settings',
	'default' => 'infinite_button',
	'multiple' => 1,
	'choices' => array(
		'navigation' => esc_html__( 'Navigation', 'magsy' ),
		'numeric' => esc_html__( 'Numeric', 'magsy' ),
		'infinite_button' => esc_html__( 'Infinite + Button', 'magsy' ),
		'infinite_scroll' => esc_html__( 'Infinite + Scroll', 'magsy' ),
	),
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'select',
	'settings' => $kirki_prefix . 'sidebar_home',
	'label' => esc_html__( 'Latest posts sidebar', 'magsy' ),
	'section' => $kirki_prefix . 'general_settings',
	'default' => 'none',
	'multiple' => 1,
	'choices' => array(
		'none' => esc_html__( 'None', 'magsy' ),
		'right' => esc_html__( 'Right', 'magsy' ),
		'left' => esc_html__( 'Left', 'magsy' ),
	),
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'select',
	'settings' => $kirki_prefix . 'sidebar_single',
	'label' => esc_html__( 'Single post/page sidebar', 'magsy' ),
	'section' => $kirki_prefix . 'general_settings',
	'default' => 'none',
	'multiple' => 1,
	'choices' => array(
		'none' => esc_html__( 'None', 'magsy' ),
		'right' => esc_html__( 'Right', 'magsy' ),
		'left' => esc_html__( 'Left', 'magsy' ),
	),
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'select',
	'settings' => $kirki_prefix . 'sidebar_archive',
	'label' => esc_html__( 'Archive page sidebar', 'magsy' ),
	'section' => $kirki_prefix . 'general_settings',
	'default' => 'none',
	'multiple' => 1,
	'choices' => array(
		'none' => esc_html__( 'None', 'magsy' ),
		'right' => esc_html__( 'Right', 'magsy' ),
		'left' => esc_html__( 'Left', 'magsy' ),
	),
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'enable_human_readable_date',
	'label' => esc_html__( 'Use human readable date format', 'magsy' ),
	'section' => $kirki_prefix . 'general_settings',
	'default' => false,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'disable_open_graph',
	'label' => esc_html__( 'Disable Open Graph tags', 'magsy' ),
	'section' => $kirki_prefix . 'general_settings',
	'default' => false,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'disable_recommended_plugins',
	'label' => esc_html__( 'Disable recommended plugins', 'magsy' ),
	'description' => esc_html__( 'Enable this if you do not need recommended plugins and want to hide the notice.', 'magsy' ),
	'section' => $kirki_prefix . 'general_settings',
	'default' => false,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'enable_standard_widgets',
	'label' => esc_html__( 'Widgets on modular page', 'magsy' ),
	'description' => esc_html__( 'Enable this only if you understand that standard widgets are not styled for modular page.', 'magsy' ),
	'section' => $kirki_prefix . 'general_settings',
	'default' => false,
) );