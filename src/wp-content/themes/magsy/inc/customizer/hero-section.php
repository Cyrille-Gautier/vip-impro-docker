<?php

Magsy_Kirki::add_panel( $kirki_prefix . 'hero', array(
  'title'    => esc_html__( 'Hero Section', 'magsy' ),
  'priority' => 12,
) );

Magsy_Kirki::add_section( $kirki_prefix . 'hero_home', array(
	'title'    => esc_html__( 'Latest posts', 'magsy' ),
  'panel'    => $kirki_prefix . 'hero',
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type'        => 'radio',
	'settings'    => $kirki_prefix . 'hero_home_style',
	'label'       => esc_html__( 'Choose a style', 'magsy' ),
	'section'     => $kirki_prefix . 'hero_home',
	'default'     => 'none',
	'multiple'    => 1,
	'choices'     => array(
		'wide' => esc_html__( 'Widescreen area', 'magsy' ),
		'full' => esc_html__( 'Fullscreen area', 'magsy' ),
		'none' => esc_html__( 'None', 'magsy' ),
	),
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type'        => 'radio',
	'settings'    => $kirki_prefix . 'hero_home_content',
	'label'       => esc_html__( 'Add the following content', 'magsy' ),
	'section'     => $kirki_prefix . 'hero_home',
	'default'     => 'image',
	'multiple'    => 1,
	'choices'     => array(
		'image'   => esc_html__( 'Image', 'magsy' ),
		'gallery' => esc_html__( 'Gallery', 'magsy' ),
	),
  'active_callback' => array(
    array(
      'setting' => $kirki_prefix . 'hero_home_style',
      'operator' => '!=',
      'value' => 'none',
    ),
  ),
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type'     => 'image',
	'settings' => $kirki_prefix . 'hero_home_bg_image',
	'section'  => $kirki_prefix . 'hero_home',
  'active_callback' => array(
    array(
      'setting' => $kirki_prefix . 'hero_home_content',
      'operator' => '==',
      'value' => 'image',
    ),
    array(
      'setting' => $kirki_prefix . 'hero_home_style',
      'operator' => '!=',
      'value' => 'none',
    ),
  ),
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type'     => 'text',
	'settings' => $kirki_prefix . 'hero_home_heading',
	'label'    => esc_html__( 'Heading', 'magsy' ),
	'section'  => $kirki_prefix . 'hero_home',
  'active_callback' => array(
    array(
      'setting' => $kirki_prefix . 'hero_home_content',
      'operator' => '==',
      'value' => 'image',
    ),
    array(
      'setting' => $kirki_prefix . 'hero_home_style',
      'operator' => '!=',
      'value' => 'none',
    ),
  ),
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type'     => 'text',
	'settings' => $kirki_prefix . 'hero_home_subheading',
	'label'    => esc_html__( 'Subheading', 'magsy' ),
	'section'  => $kirki_prefix . 'hero_home',
  'active_callback' => array(
    array(
      'setting' => $kirki_prefix . 'hero_home_content',
      'operator' => '==',
      'value' => 'image',
    ),
    array(
      'setting' => $kirki_prefix . 'hero_home_style',
      'operator' => '!=',
      'value' => 'none',
    ),
  ),
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'repeater',
	'settings' => $kirki_prefix . 'hero_home_bg_slider',
	'section'  => $kirki_prefix . 'hero_home',
  'row_label' => array(
    'type' => 'text',
    'value' => esc_html__( 'slide', 'magsy' ),
  ),
  'fields' => array(
    'slider_image' => array(
    	'type' => 'image',
    ),
    'slider_heading' => array(
      'type' => 'text',
      'label' => esc_html__( 'Heading', 'magsy' ),
    ),
    'slider_subheading' => array(
      'type' => 'text',
      'label' => esc_html__( 'Subheading', 'magsy' ),
    ),
  ),
  'active_callback' => array(
    array(
      'setting' => $kirki_prefix . 'hero_home_content',
      'operator' => '==',
      'value' => 'gallery',
    ),
    array(
      'setting' => $kirki_prefix . 'hero_home_style',
      'operator' => '!=',
      'value' => 'none',
    ),
  ),
) );

Magsy_Kirki::add_section( $kirki_prefix . 'hero_single', array(
	'title'    => esc_html__( 'Single Post/Page', 'magsy' ),
  'panel'    => $kirki_prefix . 'hero',
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type'        => 'radio',
	'settings'    => $kirki_prefix . 'hero_single_style',
	'label'       => esc_html__( 'Choose a style', 'magsy' ),
	'section'     => $kirki_prefix . 'hero_single',
	'default'     => 'none',
	'multiple'    => 1,
	'choices'     => array(
		'wide' => esc_html__( 'Widescreen area', 'magsy' ),
		'full' => esc_html__( 'Fullscreen area', 'magsy' ),
		'none' => esc_html__( 'None', 'magsy' ),
	),
) );