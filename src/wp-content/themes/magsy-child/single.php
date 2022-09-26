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
					<?php while ( have_posts() ) : the_post(); ?>
						<?php if($post->post_type=='post' || $post->post_type=='salle') { ?>
                        <?php get_template_part( 'content', 'single' ); ?>
                        <?php } else { ?>
                        <?php get_template_part( 'content', $post->post_type ); ?>
                        <?php }  ?>
                        <?php
                            //get_template_part( 'inc/template-parts/content', 'single' );
                        /*****************************************************
                        **	BOUTON TELECHARGER GALERIE						**
                        *****************************************************/
                        global $current_user;
                        get_currentuserinfo();
                        if ( is_user_logged_in() && strpos($post->post_content,'[gallery') !== false ) { ?>
                        <?php echo do_shortcode('[za_show_download_button text="Télécharger la galerie" class="button secondary"]'); ?>
                        <?php }
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
  /*if ( comments_open() || get_comments_number() ) :
    comments_template();
  endif;*/
?>

<?php get_footer(); ?>
