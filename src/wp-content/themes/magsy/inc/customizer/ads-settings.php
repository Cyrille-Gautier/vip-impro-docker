<?php

$locations = array(
	array( 'before_header', esc_html__( 'Before header', 'magsy' ) ),
	array( 'after_header', esc_html__( 'After header', 'magsy' ) ),
	array( 'before_footer', esc_html__( 'Before footer', 'magsy' ) ),
	array( 'before_post_content', esc_html__( 'Before post content', 'magsy' ) ),
	array( 'after_post_content', esc_html__( 'After post content', 'magsy' ) ),
);

Magsy_Kirki::add_panel( $kirki_prefix . 'ads', array(
  'title' => esc_html__( 'Ads Settings', 'magsy' ),
  'priority' => 16,
) );

foreach ( $locations as $location ) {
	Magsy_Kirki::add_section( $kirki_prefix . 'ads_' . $location[0], array(
		'title' => $location[1],
		'panel' => $kirki_prefix . 'ads',
	) );

	Magsy_Kirki::add_field( 'magsy', array(
		'type' => 'radio',
		'settings' => $kirki_prefix . 'ads_' . $location[0] . '_style',
		'label' => esc_html__( 'Choose a style', 'magsy' ),
		'section' => $kirki_prefix . 'ads_' . $location[0],
		'default' => 'none',
		'multiple' => 1,
		'choices' => array(
			'none' => esc_html__( 'None', 'magsy' ),
			'image' => esc_html__( 'Image', 'magsy' ),
			'html' => esc_html__( 'HTML', 'magsy' ),
		),
	) );

	Magsy_Kirki::add_field( 'magsy', array(
		'type' => 'image',
		'settings' => $kirki_prefix . 'ads_' . $location[0] . '_image',
		'section' => $kirki_prefix . 'ads_' . $location[0],
		'active_callback' => array(
			array(
				'setting' => $kirki_prefix . 'ads_' . $location[0] . '_style',
				'operator' => '==',
				'value' => 'image',
			),
		),
	) );

	Magsy_Kirki::add_field( 'magsy', array(
		'type' => 'text',
		'settings' => $kirki_prefix . 'ads_' . $location[0] . '_link',
		'label' => esc_html__( 'Link', 'magsy' ),
		'section' => $kirki_prefix . 'ads_' . $location[0],
		'active_callback' => array(
			array(
				'setting' => $kirki_prefix . 'ads_' . $location[0] . '_style',
				'operator' => '==',
				'value' => 'image',
			),
		),
	) );

	Magsy_Kirki::add_field( 'magsy', array(
		'type' => 'toggle',
		'settings' => $kirki_prefix . 'ads_' . $location[0] . '_new_tab',
		'label' => esc_html__( 'Open link in a new tab', 'magsy' ),
		'section' => $kirki_prefix . 'ads_' . $location[0],
		'default' => false,
		'active_callback' => array(
			array(
				'setting' => $kirki_prefix . 'ads_' . $location[0] . '_style',
				'operator' => '==',
				'value' => 'image',
			),
		),
	) );

	Magsy_Kirki::add_field( 'magsy', array(
		'type' => 'code',
		'settings' => $kirki_prefix . 'ads_' . $location[0] . '_html',
		'label' => esc_html__( 'HTML code', 'magsy' ),
		'section' => $kirki_prefix . 'ads_' . $location[0],
		'choices' => array(
			'language' => 'html',
		),
		'active_callback' => array(
			array(
				'setting' => $kirki_prefix . 'ads_' . $location[0] . '_style',
				'operator' => '==',
				'value' => 'html',
			),
		),
	) );

	if ( $location[0] != 'before_post_content' && $location[0] != 'after_post_content' ) {
		Magsy_Kirki::add_field( 'magsy', array(
			'type' => 'toggle',
			'settings' => $kirki_prefix . 'ads_' . $location[0] . '_hide_post',
			'label' => esc_html__( 'Hide on single posts', 'magsy' ),
			'section' => $kirki_prefix . 'ads_' . $location[0],
			'default' => false,
		) );

		Magsy_Kirki::add_field( 'magsy', array(
			'type' => 'toggle',
			'settings' => $kirki_prefix . 'ads_' . $location[0] . '_hide_page',
			'label' => esc_html__( 'Hide on single pages', 'magsy' ),
			'section' => $kirki_prefix . 'ads_' . $location[0],
			'default' => false,
		) );

		Magsy_Kirki::add_field( 'magsy', array(
			'type' => 'toggle',
			'settings' => $kirki_prefix . 'ads_' . $location[0] . '_hide_archive',
			'label' => esc_html__( 'Hide on archive pages', 'magsy' ),
			'section' => $kirki_prefix . 'ads_' . $location[0],
			'default' => false,
		) );

		Magsy_Kirki::add_field( 'magsy', array(
			'type' => 'toggle',
			'settings' => $kirki_prefix . 'ads_' . $location[0] . '_hide_latest',
			'label' => esc_html__( 'Hide on latest posts', 'magsy' ),
			'section' => $kirki_prefix . 'ads_' . $location[0],
			'default' => false,
		) );
	}
}