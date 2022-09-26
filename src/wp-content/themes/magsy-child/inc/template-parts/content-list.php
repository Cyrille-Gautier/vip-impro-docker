<?php
  $sidebar = magsy_sidebar();
  $column_class = $sidebar == 'none' ? 'col-lg-6' : 'col-12';
?>

<div class="<?php echo esc_attr( $column_class ); ?>">
  <article id="post-<?php the_ID(); ?>" <?php post_class( 'post post-list' ); ?>>
    <?php magsy_entry_media( array( 'layout' => 'rect_300' ) ); ?>
    <div class="entry-wrapper">
      <?php magsy_entry_header( array( 'category' => true ) ); ?>
      <div class="entry-excerpt u-text-format">
        <?php the_excerpt(); ?>
      </div>
      <?php get_template_part( 'inc/partials/entry-footer' ); ?>
    </div>
  </article>
</div>