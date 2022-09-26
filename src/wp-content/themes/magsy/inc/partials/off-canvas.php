<?php
  $menu_class = 'mobile-menu';
  if ( magsy_compare_options( magsy_get_option( 'magsy_navbar_hidden', false ), rwmb_meta( 'magsy_navbar_hidden' ) ) == false ) {
    $menu_class .= ' hidden-lg hidden-xl';
  }
?>

<div class="off-canvas">
  <div class="canvas-close"><i class="mdi mdi-close"></i></div>
  <?php magsy_logo(); ?>
  <div class="<?php echo esc_attr( $menu_class ); ?>"></div>
  <aside class="widget-area">
    <?php dynamic_sidebar( 'off_canvas' ); ?>
  </aside>
</div>