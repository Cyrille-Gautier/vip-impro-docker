<?php

Magsy_Kirki::add_section( $kirki_prefix . 'footer_settings', array(
	'title' => esc_html__( 'Footer Settings', 'magsy' ),
  'priority' => 15,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'toggle',
	'settings' => $kirki_prefix . 'enable_social_bar',
	'label' => esc_html__( 'Enable social bar', 'magsy' ),
	'section' => $kirki_prefix . 'footer_settings',
	'default' => false,
) );

Magsy_Kirki::add_field( 'magsy', array(
	'type' => 'textarea',
	'settings' => $kirki_prefix . 'copyright_text',
	'label' => esc_html__( 'Copyright text', 'magsy' ),
	'section' => $kirki_prefix . 'footer_settings',
) );