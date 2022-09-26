<?php
  $sidebar = magsy_sidebar();
  $column_class = $sidebar == 'none' ? 'col-sm-6 col-md-4 col-lg-3' : 'col-sm-6 col-md-4';
?>

<div class="<?php echo esc_attr( $column_class ); ?>">
  <article id="post-<?php the_ID(); ?>" <?php post_class( 'post post-grid' ); ?>>
    <?php magsy_entry_media( array( 'layout' => 'full_400' ) ); ?>
    <div class="entry-wrapper">
      <?php magsy_entry_header( array( 'category' => true ) ); ?>
      <div class="entry-excerpt u-text-format">
        <?php the_excerpt(); ?>
      </div>
      <?php get_template_part( 'inc/partials/entry-footer' ); ?>
    </div>
  </article>
</div>