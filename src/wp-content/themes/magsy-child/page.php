<?php get_header(); ?>

<div class="content-area">
	<main class="site-main">
		<?php while ( have_posts() ) : the_post();
			get_template_part( 'inc/template-parts/content', 'page' );
		endwhile; ?>
	</main>
</div>

<?php get_footer(); ?>