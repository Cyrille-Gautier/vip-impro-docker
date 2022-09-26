<?php
  $container = magsy_get_option( 'magsy_navbar_full', false );
  $menu_class = 'main-menu hidden-xs hidden-sm hidden-md';
  if ( magsy_compare_options( magsy_get_option( 'magsy_navbar_hidden', false ), rwmb_meta( 'magsy_navbar_hidden' ) ) == true ) {
    $menu_class .= ' hidden-lg hidden-xl';
  }
?>

<header class="site-header">
  <?php if ( $container == false ) : ?>
    <div class="container">
  <?php endif; ?>
    <div class="navbar">
      <?php magsy_logo(); ?>
      <div class="sep"></div>
      
      <nav class="<?php echo esc_attr( $menu_class ); ?>">
        <?php wp_nav_menu( array(
          'container' => false,
          'fallback_cb' => 'Magsy_Walker_Nav_Menu::fallback',
          'menu_class' => 'nav-list u-plain-list',
          'theme_location' => 'menu-1',
          'walker' => new MAGSY_Walker_Nav_Menu( true ),
        ) ); ?>
      </nav>
      
      <div class="main-search">
        <?php get_search_form(); ?>
        <div class="search-close navbar-button"><i class="mdi mdi-close"></i></div>
      </div>

      <div class="actions">
        <div class="search-open navbar-button"><i class="mdi mdi-magnify"></i></div>
        <div class="burger"></div>
      </div>
    </div>
  <?php if ( $container == false ) : ?>
    </div>
  <?php endif; ?>
</header>

<div class="header-gap"></div>