<?php if ( ! get_post_format() && has_post_thumbnail() ) :
  magsy_entry_media( array( 'layout' => 'full_1160' ) );
elseif ( get_post_format() == 'video' && rwmb_meta( 'magsy_pf_video_data' ) != '' ) : ?>
  <div class="entry-media">
    <?php echo rwmb_meta( 'magsy_pf_video_data' ); ?>
  </div> <?php
elseif ( get_post_format() == 'gallery' ) :
  $style = rwmb_meta( 'magsy_pf_gallery_style' );
  if ( $style == 'justified' ) {
    $image_size = 'full_800';
  } else {
    $image_size = 'full_1160';
  }
  magsy_entry_media( array( 'layout' => $image_size, 'gallery' => true ) );
elseif ( get_post_format() == 'audio' && rwmb_meta( 'magsy_pf_audio_data' ) != '' ) : ?>
  <div class="entry-media">
    <?php echo rwmb_meta( 'magsy_pf_audio_data' ); ?>
  </div> <?php
endif; ?>