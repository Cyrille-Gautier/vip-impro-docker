<?php

Magsy_Kirki::add_section( $kirki_prefix . 'post_settings', array(
	'title' => esc_html__( 'Post Settings', 'magsy' ),
  'priority' => 13,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'radio',
	'settings' => $kirki_prefix . 'featured_image_location',
	'label' => esc_html__( 'Featured image location', 'magsy' ),
	'section' => $kirki_prefix . 'post_settings',
	'default' => 'mixed',
	'multiple' => 1,
	'choices' => array(
		'mixed' => esc_html__( 'Mixed', 'magsy' ),
		'side' => esc_html__( 'On side', 'magsy' ),
		'with' => esc_html__( 'With content', 'magsy' ),
	),
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'small_featured_image',
	'label' => esc_html__( 'Make featured image smaller', 'magsy' ),
	'section' => $kirki_prefix . 'post_settings',
	'default' => false,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'disable_post_tags',
	'label' => esc_html__( 'Disable post tags', 'magsy' ),
	'section' => $kirki_prefix . 'post_settings',
	'default' => false,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'disable_author_box',
	'label' => esc_html__( 'Disable author box', 'magsy' ),
	'section' => $kirki_prefix . 'post_settings',
	'default' => false,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'disable_related_posts',
	'label' => esc_html__( 'Disable related posts', 'magsy' ),
	'section' => $kirki_prefix . 'post_settings',
	'default' => false,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'slider',
	'settings' => $kirki_prefix . 'excerpt_length',
	'label' => esc_html__( 'Excerpt length', 'magsy' ),
	'section' => $kirki_prefix . 'post_settings',
	'default' => 12,
	'choices' => array(
		'min' => 0,
		'max' => 100,
		'step' => 1,
	),
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'text',
	'settings' => $kirki_prefix . 'excerpt_more',
	'label' => esc_html__( 'Excerpt more', 'magsy' ),
	'section' => $kirki_prefix . 'post_settings',
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'excerpt_link',
	'label' => esc_html__( 'Make excerpt more with link', 'magsy' ),
	'section' => $kirki_prefix . 'post_settings',
	'default' => false,
) );

$links = magsy_sharing_links();
$options = array();

foreach ( $links as $i => $v ) {
	$options[ $i ] = $v['label'];
}

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'multicheck',
	'settings' => $kirki_prefix . 'sharing_links',
	'label' => esc_html__( 'Sharing links', 'magsy' ),
	'section' => $kirki_prefix . 'post_settings',
	'default' => array( 'facebook', 'twitter', 'google', 'pinterest' ),
	'choices' => $options,
) );