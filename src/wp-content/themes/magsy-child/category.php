<?php
/**
 * @package wp-bootstrap
 */

get_header(); ?>
<div class="container" id="category-title">
	<div class="row">
    	<div class="col-md-12">
        	<h1><?php single_cat_title(); ?></h1>
		</div><!-- .col -->
	</div><!-- .row -->
</div><!-- .container -->
<div class="container">
	<div class="row">
<?php
/*--------------------------------------------------------
--					Affichage standard					--
--------------------------------------------------------*/

/* étendre la requete WP aux autres types de post */
global $wp_query; 
$args = array_merge( $wp_query->query, array( 'post_type' => 'any' ) ); 
/*,
	'meta_key'			=> 'details_date_finale',
	'orderby'			=> 'meta_value',
	'order'				=> 'DESC'*/
query_posts( $args );
if ( have_posts() ) : ?>
	<?php
	// Start the Loop.
	$npost=0;
	while ( have_posts() ) : the_post();
	?>
    	<div class="col-md-6">
		<?php if($post->post_type=='post') { ?>
		<?php get_template_part( 'content', 'single' ); ?>
        <?php } else if($post->post_type=='spectacle') { ?>
		<?php get_template_part( 'content', 'spectacle' ); ?>
        <?php } else { ?>
        <?php get_template_part( 'content', $post->post_type ); ?>
        <?php }  ?>
    	<?php $npost++; ?>
    	</div>
    <?php
	endwhile;
else :
	// If no content, include the "No posts found" template.
	get_template_part( 'content', 'none' );
endif;
	?>
	</div><!-- .row -->
</div><!-- .container -->
    
<div class="container-fluid fond gris no-padding">
    <div class="container">
		<div class="row">
    		<div class="col-md-6 text-center">
	<?php
    next_posts_link( '&lt;&lt; Articles plus anciens', $query->max_num_pages );
    ?>
    		</div><!-- .col-md-6-->
    		<div class="col-md-6 text-center">
	<?php
    previous_posts_link( 'Articles plus récents &gt;&gt;' );
    ?>
    		</div><!-- .col-md-6-->
        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- .container -->
<?php
//get_sidebar($type_du_post);
get_footer();