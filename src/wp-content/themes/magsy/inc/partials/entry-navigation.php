<?php
  $next_post = get_next_post();
?>

<?php if ( ! empty( $next_post ) ) : ?>
  <div class="entry-navigation">
    <?php if ( has_post_thumbnail( $next_post->ID ) ) : ?>
      <img class="jarallax-img lazyload" data-srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_post_thumbnail_id( $next_post->ID ), 'magsy_full_1160' ) ); ?>" data-sizes="auto">
    <?php endif; ?>
    <div class="navigation-content">
      <span class="u-border-title"><?php echo apply_filters( 'magsy_next_post_title', esc_html__( 'Next Article', 'magsy' ) ); ?></span>
      <h4 class="navigation-title"><?php echo get_the_title( $next_post->ID ); ?></h4>
    </div>
    <a class="u-permalink" href="<?php echo esc_url( get_the_permalink( $next_post->ID ) ); ?>"></a>
  </div>
<?php endif; ?>