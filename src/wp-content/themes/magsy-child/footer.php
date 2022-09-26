		<div class="container-fluid  prochains spectacles">
            <div class="container">
                <div class="row">
                <div class="col-md-6-">
                    <?php 
					//echo do_shortcode('[calendrier class="" cal_month="" cal_year="" with_spectacles="false"]');
					//get_template_part( 'content', 'spectacle-mini' ); ?>
                </div>
                <div class="col-md-6-">
                    <?php 
					//echo do_shortcode('[calendrier class="" cal_month="m+1" cal_year="" with_spectacles="false"]');
					//get_template_part( 'content', 'spectacle-mini' ); ?>
                </div>
                    <?php get_template_part( 'content', 'spectacle-mini' ); ?>
                </div>
            </div>
        </div>
    </div>
  

	<?php
		magsy_ads( array( 'location' => 'before_footer' ) );
		if ( magsy_get_option( 'magsy_enable_social_bar', false ) == true ) {
			get_template_part( 'inc/partials/social-bar' );
		}
	?>
	
	<footer class="site-footer">
		<div class="container">
			<nav class="footer-menu">
				<?php wp_nav_menu( array(
					'container' => false,
					'fallback_cb' => 'Magsy_Walker_Nav_Menu::fallback',
					'menu_class' => 'nav-list u-plain-list',
					'theme_location' => 'menu-2',
					'walker' => new MAGSY_Walker_Nav_Menu( true ),
				) ); ?>
			</nav>
			<?php get_template_part( 'inc/partials/copyright' ); ?>
			<?php dynamic_sidebar( 'sidebar' ); ?>
		</div>
	</footer>
</div>

<div class="dimmer"></div>
<?php
	if ( is_singular( 'post' ) ) {
		get_template_part( 'inc/partials/modal' );
	}
	get_template_part( 'inc/partials/off-canvas' );
	if ( is_singular( 'post' ) && get_post_format() == 'gallery' && rwmb_meta( 'magsy_pf_gallery_style' ) == 'justified' ) {
		get_template_part( 'inc/partials/photoswipe' );
	}
?>

<?php wp_footer(); ?>

</body>
</html>