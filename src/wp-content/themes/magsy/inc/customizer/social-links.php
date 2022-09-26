<?php

Magsy_Kirki::add_section( $kirki_prefix . 'social_links', array(
	'title'    => esc_html__( 'Social Links', 'magsy' ),
  'priority' => 14,
) );

$social_links = magsy_social_links();

foreach ( $social_links as $link ) {
	Magsy_Kirki::add_field( 'magsy', array(
		'type'     => 'text',
		'settings' => $kirki_prefix . $link['option'],
		'label'    => sprintf( esc_html__( '%s', 'magsy' ), $link['name'] ),
		'section'  => $kirki_prefix . 'social_links',
	) );
}