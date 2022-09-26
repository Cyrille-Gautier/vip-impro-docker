<?php function magsy_entry_media( $options = array() ) {
  $options = array_merge( array( 'gallery' => false ), $options );

  switch ( $options['layout'] ) {
    case 'full_400' :
      $image_size = 'magsy_full_400';
      $sizes = '';
      break;
    case 'full_800' :
      $image_size = 'magsy_full_800';
      $sizes = '';
      break;
    case 'full_1160' :
      $image_size = 'magsy_full_1160';
      $sizes = '';
      break;
    case 'rect_300' :
      $image_size = 'magsy_rect_300';
      $sizes = '';
      break;
  }
  
  $ratio = magsy_thumbnail_ratio( $image_size );
  $alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt' );
  $alt = ! empty( $alt ) ? $alt[0] : ''; ?>

  <?php if ( ! $options['gallery'] && has_post_thumbnail() ) :
    if ( ! magsy_is_gif() ) : ?>
      <div class="entry-media">
        <div class="placeholder" style="padding-bottom: <?php echo esc_attr( $ratio ); ?>;">
          <a href="<?php echo esc_url( get_permalink() ); ?>">
            <?php if ( wp_get_attachment_image_srcset( get_post_thumbnail_id(), $image_size ) ) : ?>
              <img class="lazyload" data-srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_post_thumbnail_id(), $image_size ) ); ?>" data-sizes="auto" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="<?php echo esc_attr( $alt ); ?>">
            <?php else :
              $image = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_size ); ?>
              <img class="lazyload" data-src="<?php echo esc_url( $image[0] ); ?>" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="<?php echo esc_attr( $alt ); ?>">  
            <?php endif; ?>
          </a>
        </div>
        <?php get_template_part( 'inc/partials/entry-format' ); ?>
      </div>
    <?php else :
      $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
      $ratio = magsy_thumbnail_ratio( 'full' ); ?>
      <div class="entry-media">
        <div class="placeholder" style="padding-bottom: <?php echo esc_attr( $ratio ); ?>;">
          <a href="<?php echo esc_url( get_permalink() ); ?>">
            <img class="lazyload" data-src="<?php echo esc_url( $image[0] ); ?>" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="<?php echo esc_attr( $alt ); ?>">
          </a>
        </div>
        <?php get_template_part( 'inc/partials/entry-format' ); ?>
      </div>
    <?php endif;
  else :
    $gallery = rwmb_meta( 'magsy_pf_gallery_data', array( 'size' => 'full' ) );
    $style = rwmb_meta( 'magsy_pf_gallery_style' );
    if ( ! empty( $gallery ) ) : ?>
      <div class="entry-media">
        <?php if ( $style == 'justified' ) : ?>
          <div class="entry-gallery justified-gallery">
            <?php foreach ( $gallery as $image ) :
              $image_data = wp_get_attachment_image_src( $image['ID'], $image_size ); ?>
              <div class="gallery-item">
                <a href="<?php echo esc_url( $image['full_url'] ); ?>" data-width="<?php echo esc_attr( $image['width'] ); ?>" data-height="<?php echo esc_attr( $image['height'] ); ?>">
                  <img src="<?php echo esc_url( $image_data[0] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                </a>
                <?php if ( $image['caption'] ) : ?>
                  <div class="caption"><?php echo esc_html( $image['caption'] ); ?></div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else : ?>
          <div class="entry-gallery slider owl nav-transparent">
            <?php foreach ( $gallery as $image ) : ?>
              <div class="gallery-item">
                <img class="lazyload" data-srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $image['ID'], $image_size ) ); ?>" sizes="auto" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                <?php if ( $image['caption'] ) : ?>
                  <div class="caption"><?php echo esc_html( $image['caption'] ); ?></div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif;
  endif;
}