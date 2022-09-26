<?php

if ( class_exists( 'Magsy_Kirki' ) ) {
  $kirki_prefix = 'magsy_';

  Magsy_Kirki::add_config( 'magsy', array(
    'option_type' => 'option',
    'option_name' => 'magsy_admin_options',
  	'capability'  => 'edit_theme_options',
  ) );

  require_once get_template_directory() . '/inc/customizer/general-settings.php';
  require_once get_template_directory() . '/inc/customizer/header-logo.php';
  require_once get_template_directory() . '/inc/customizer/hero-section.php';
  require_once get_template_directory() . '/inc/customizer/post-settings.php';
  require_once get_template_directory() . '/inc/customizer/social-links.php';
  require_once get_template_directory() . '/inc/customizer/footer-settings.php';
  require_once get_template_directory() . '/inc/customizer/ads-settings.php';

  function Magsy_Kirki_config( $config ) {
    return wp_parse_args( array(
      'disable_loader' => true,
    ), $config );
  }
  add_filter( 'kirki_config', 'Magsy_Kirki_config' );
}