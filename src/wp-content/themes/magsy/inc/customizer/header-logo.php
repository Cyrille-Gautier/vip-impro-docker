<?php

Magsy_Kirki::add_section( $kirki_prefix . 'header_logo', array(
	'title' => esc_html__( 'Header & Logo', 'magsy' ),
  'priority' => 11,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'radio',
	'settings' => $kirki_prefix . 'navbar_style',
	'label' => esc_html__( 'Navigation bar style', 'magsy' ),
	'section' => $kirki_prefix . 'header_logo',
	'default' => 'sticky',
	'multiple' => 1,
	'choices' => array(
		'sticky' => esc_html__( 'Sticky', 'magsy' ),
		'transparent' => esc_html__( 'Transparent', 'magsy' ),
		'sticky_transparent' => esc_html__( 'Sticky+Transparent', 'magsy' ),
		'regular' => esc_html__( 'Regular', 'magsy' ),
	),
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'navbar_full',
	'label' => esc_html__( 'Full width navigation bar', 'magsy' ),
	'section' => $kirki_prefix . 'header_logo',
	'default' => false,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'navbar_slide',
	'label' => esc_html__( 'Hide navigation bar while scrolling', 'magsy' ),
	'section' => $kirki_prefix . 'header_logo',
	'default' => false,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'navbar_hidden',
	'label' => esc_html__( 'Hidden main menu', 'magsy' ),
	'section' => $kirki_prefix . 'header_logo',
	'default' => false,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'disable_search',
	'label' => esc_html__( 'Disable search', 'magsy' ),
	'section' => $kirki_prefix . 'header_logo',
	'default' => false,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'image',
	'settings' => $kirki_prefix . 'logo_regular',
	'label' => esc_html__( 'Logo', 'magsy' ),
	'section' => $kirki_prefix . 'header_logo',
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'image',
	'settings' => $kirki_prefix . 'logo_regular@2x',
	'label' => esc_html__( 'Retina logo', 'magsy' ),
	'description' => esc_html__( 'Choose x2 version of your logo. If the logo is 150x50, the retina logo must be 300x100.', 'magsy' ),
	'section' => $kirki_prefix . 'header_logo',
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'image',
	'settings' => $kirki_prefix . 'logo_contrary',
	'label' => esc_html__( 'Contrary logo', 'magsy' ),
	'description' => esc_html__( 'This logo will be used on Transparent and Sticky+Transparent navigation bars.', 'magsy' ),
	'section' => $kirki_prefix . 'header_logo',
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'image',
	'settings' => $kirki_prefix . 'logo_contrary@2x',
	'label' => esc_html__( 'Contrary retina logo', 'magsy' ),
	'section' => $kirki_prefix . 'header_logo',
) );