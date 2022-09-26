<div class="_404">
	<div class="_404-inner">
		<h1 class="entry-title"><?php echo apply_filters( 'magsy_no_result_title', esc_html__( 'No results found', 'magsy' ) ); ?></h1>
		<div class="entry-content">
			<?php echo apply_filters( 'magsy_no_result_message', esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'magsy' ) ); ?>
		</div>
		<?php get_search_form(); ?>
	</div>
</div>