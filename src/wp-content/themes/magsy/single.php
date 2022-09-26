<?php
	if ( class_exists( 'Magsy_Essentials' ) ) {
		Magsy_Essentials::magsy_view();
	}
	$sidebar = magsy_sidebar();
	$column_classes = magsy_column_classes( $sidebar );
	get_header();
?>

<div class="container">
	<div class="row">
		<div class="<?php echo esc_attr( $column_classes[0] ); ?>">
			<div class="content-area">
				<main class="site-main">
					<?php while ( have_posts() ) : the_post();
						get_template_part( 'inc/template-parts/content', 'single' );
					endwhile; ?>
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

<?php
  get_template_part( 'inc/partials/related-posts' );
  if ( comments_open() || get_comments_number() ) :
    comments_template();
  endif;
?>

<?php get_footer(); ?>