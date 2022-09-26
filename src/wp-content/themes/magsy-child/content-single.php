<?php
/**
 * @package wp-bootstrap
*/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <?php get_template_part( 'inc/partials/single-top' ); ?>

  <div class="container <?php if(!has_gallery()) echo 'medium'; else echo 'large'; ?>">
    <?php magsy_ads( array( 'location' => 'before_post_content', 'container' => false ) ); ?>
    <?php if ( magsy_show_hero() ) :
      get_template_part( 'inc/partials/entry-subheading' );
    endif; ?>
    <div class="entry-wrapper">
      <div class="entry-content u-text-format u-clearfix">
<div class="post-date time mini">
    <span class="entry-date">
        <abbr class="published" title="<?php echo get_the_time('Y-m-dTH:i:sO'); ?>">
            <span class="post_date post_date_day_of_week"><?php echo get_the_time('D'); ?></span>
            <span class="post_date post_date_day"><?php echo get_the_time('d'); ?></span>
            <span class="post_date post_date_month"><?php echo get_the_time('M'); ?></span>
            <span class="post_date post_date_year"><?php echo get_the_time('Y'); ?></span>
        </abbr>
    </span>
</div><!-- .entry-meta -->

<?php if (is_category()) { ?>

	<?php 
	$gallery = get_post_gallery();
    $content_without_gallery = strip_shortcode_gallery( get_the_content(), $enable_button=true, $id=get_the_ID() );
	echo do_shortcode($content_without_gallery); ?>

<?php } else { ?>

	<?php the_content(); ?>

<?php }  ?>

      </div>
      <?php
        wp_link_pages( 'before=<div class="page-links">&after=</div>&link_before=<span>&link_after=</span>' );
        get_template_part( 'inc/partials/entry-tags' );
        magsy_ads( array( 'location' => 'after_post_content', 'container' => false ) );
        get_template_part( 'inc/partials/entry-action' );
        get_template_part( 'inc/partials/entry-navigation' );
        get_template_part( 'inc/partials/author-box' );
      ?>
    </div>
  </div>
</article>

<!-- content-single.php -->
<?php /*if (is_category()) { ?>
	<a href="<?php the_permalink(); ?>"><?php the_title( '<h2 class="entry-title">', '</h2>' ); ?></a>
<?php } else { ?>
	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
<?php }  ?>
<?php if (has_post_thumbnail()) { ?> 
	<img src="<?php the_post_thumbnail_url( 'large-thumbnail'); ?>" class="img-responsive">
<?php }*/ ?>

<?php edit_post_link( __( 'Editer', 'wp-bootstrap' ), '<span class="edit-link">', '</span>' ); ?>