<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php get_template_part( 'inc/partials/single-top' ); ?>

  <div class="container small">
    <?php if ( magsy_show_hero() ) :
      get_template_part( 'inc/partials/entry-subheading' );
    endif; ?>
    <div class="entry-wrapper">
      <div class="entry-content u-text-format u-clearfix">
        <?php the_content(); ?>
      </div>
      <?php
        wp_link_pages( 'before=<div class="page-links">&after=</div>&link_before=<span>&link_after=</span>' );
        get_template_part( 'inc/partials/entry-tags' );
        get_template_part( 'inc/partials/entry-action' );
        get_template_part( 'inc/partials/entry-navigation' );
        get_template_part( 'inc/partials/author-box' );
      ?>
    </div>
  </div>
</article>