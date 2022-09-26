<?php
  $image = get_the_post_thumbnail_url();
?>

<div class="term-bar lazyload visible" data-bg="<?php echo esc_url( $image ); ?>">
  <?php 
    if ( is_archive() ) {
      the_archive_title( '<h1 class="term-title">', '</h1>' );
    } elseif ( is_search() ) {
      echo '<h1 class="term-title">' . sprintf( esc_html__( 'Search: %s', 'magsy' ), get_search_query() ) . '</h1>';
    }
  ?>
</div>