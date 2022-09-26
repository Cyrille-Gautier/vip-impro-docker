<?php
  $sidebar = magsy_sidebar();

  if ( $sidebar == 'none' ) {
    $media_class = magsy_compare_options( magsy_get_option( 'magsy_small_featured_image', false ), rwmb_meta( 'magsy_small_featured_image' ) ) == false ? 'container medium' : 'container small';
  } else {
    $media_class = '';
  }

  if ( ! magsy_show_hero() ) :
    if ( magsy_side_thumbnail() ) :
      $container_class = $sidebar == 'none' ? 'container medium' : ''; ?>
      <div class="<?php echo esc_attr( $container_class ); ?>">
        <div class="row">
          <div class="col-lg-7 portrait-header">
            <?php get_template_part( 'inc/partials/single-header' ); ?>
          </div>
          <div class="col-lg-5 portrait-media">
            <?php get_template_part( 'inc/partials/single-media' ); ?>
          </div>
        </div>
      </div>
    <?php else : ?>
      <div class="container small">
        <?php get_template_part( 'inc/partials/single-header' ); ?>
      </div>
      <div class="<?php echo esc_attr( $media_class ); ?>">
        <?php get_template_part( 'inc/partials/single-media' ); ?>
      </div>
    <?php endif;
  endif;
?>