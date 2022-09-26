<?php
  $sidebar = magsy_sidebar();
	$column_classes = magsy_column_classes( $sidebar );
  get_header();
?>

<div class="container">
  <div class="row">
    <div class="<?php echo esc_attr( $column_classes[0] ); ?>">
      <div class="content-area">
        <main class="site-main">
          <?php if ( have_posts() ) : ?>
            <?php if ( is_home() ) : ?>
              <h1 class="latest-title"><?php echo apply_filters( 'magsy_latest_posts_title', esc_html__( 'Latest Posts', 'magsy' ) ); ?></h1>
            <?php endif; ?>
            <div class="row posts-wrapper">
              <?php while ( have_posts() ) : the_post();
                get_template_part( 'inc/template-parts/content', magsy_get_option( 'magsy_latest_layout', 'list' ) );
              endwhile; ?>
            </div>
            <?php get_template_part( 'inc/partials/pagination' ); ?>
          <?php else : ?>
            <?php get_template_part( 'inc/template-parts/content', 'none' ); ?>
          <?php endif; ?>
        </main>
      </div>
    </div>
    <?php if ( $sidebar != 'none' ) : ?>
			<div class="<?php echo esc_attr( $column_classes[1] ); ?>">
				<?php get_sidebar(); ?>
			</div>
		<?php endif; ?>
  </div>
</div>

<?php get_footer(); ?>