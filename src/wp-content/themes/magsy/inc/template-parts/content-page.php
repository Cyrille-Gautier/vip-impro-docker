<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
  <?php get_template_part( 'inc/partials/single-top' ); ?>

  <div class="container small">
    <?php if ( magsy_show_hero() ) :
      get_template_part( 'inc/partials/entry-subheading' );
    endif; ?>
    <div class="entry-wrapper">
      <div class="entry-content u-text-format u-clearfix">
        <?php the_content(); ?>
      </div>
      <?php wp_link_pages( 'before=<div class="page-links">&after=</div>&link_before=<span>&link_after=</span>' ); ?>
    </div>
  </div>
</article>

<?php
  if ( comments_open() || get_comments_number() ) :
    comments_template();
  endif;
?>