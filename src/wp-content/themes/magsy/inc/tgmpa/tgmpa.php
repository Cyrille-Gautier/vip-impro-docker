<?php function magsy_register_required_plugins() {
  $plugins = array(
    array(
      'name' => esc_html__( 'Magsy Essentials', 'magsy' ),
      'slug' => 'magsy-essentials',
      'source' => get_template_directory() . '/inc/plugins/magsy-essentials.zip',
      'required' => true,
      'version' => '1.3',
    ),
    array(
      'name' => esc_html__( 'Kirki', 'magsy' ),
      'slug' => 'kirki',
      'required' => true,
    ),
    array(
      'name' => esc_html__( 'Meta Box', 'magsy' ),
      'slug' => 'meta-box',
      'required' => true,
    ),
  );

  if ( magsy_get_option( 'magsy_disable_recommended_plugins', false ) == false ) {
    $plugins[] = array(
      'name' => esc_html__( 'WP Instagram Widget', 'magsy' ),
      'slug' => 'wp-instagram-widget',
      'required' => false,
    );
    
    $plugins[] = array(
      'name' => esc_html__( 'Contact Form 7', 'magsy' ),
      'slug' => 'contact-form-7',
      'required' => false,
    );

    $plugins[] = array(
      'name' => esc_html__( 'WooSidebars', 'magsy' ),
      'slug' => 'woosidebars',
      'required' => false,
    );

    $plugins[] = array(
      'name' => esc_html__( 'One Click Demo Import', 'magsy' ),
      'slug' => 'one-click-demo-import',
      'required' => false,
    );
  }

  $config = array(
    'id' => 'tgmpa',
    'default_path' => '',
    'menu' => 'tgmpa-install-plugins',
    'parent_slug' => 'themes.php',
    'capability' => 'edit_theme_options',
    'has_notices' => true,
    'dismissable' => false,
    'is_automatic' => true,
  );

  tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'magsy_register_required_plugins' );