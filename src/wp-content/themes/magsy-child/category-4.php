<?php
/**
 * @package wp-bootstrap
 */

get_header(); ?>
<div class="container" id="category-title">
	<div class="row">
    	<div class="col-md-12">
        	<h1><?php single_cat_title(); ?> <?php if(isset($_GET['annee'])) echo $_GET['annee']; ?></h1>
		</div><!-- .col -->
	</div><!-- .row -->
</div><!-- .container -->
<div class="container">
	<div class="row">
<?php
$categories = get_the_category();
$category_id = $categories[0]->cat_ID;
global $wp_query; 
/* étendre la requete WP aux autres types de post */
$args = array_merge( $wp_query->query, array( 'post_type' => 'any' ) ); 
$current_cat_ID = get_query_var('cat');
if(isset($current_cat_ID) && $current_cat_ID==4) {
	$args = array_merge( $wp_query->query, array( 
		'post_type' => 'spectacle', 
		'posts_per_page' => '-1',
		'meta_key'=> 'details_date_de_representation',
		'orderby' => 'meta_value',
		'order'=>'DESC' ) ); 
}
/*--------------------------------------------------------
--					Affichage standard					--
--------------------------------------------------------*/

/*,
	'meta_key'			=> 'details_date_finale',
	'orderby'			=> 'meta_value',
	'order'				=> 'DESC'*/
query_posts( $args );
if ( have_posts() ) : ?>
	<?php
	// Start the Loop.
	$npost=0;
	$liste_annees=array();
	while ( have_posts() ) : the_post();
		$piece_meta=get_post_custom($post->ID); 
		$liste_dates = $piece_meta['details_date_de_representation']; 
		if (is_array($liste_dates)) $date_affichee = new DateTime($liste_dates[0]); 
		else $date_affichee = new DateTime($liste_dates); 
		$annee = $date_affichee->format('Y');
		ob_start();
	?>
    	<div class="col-md-4 col-sm-6 spectacle-<?php echo $npost; ?>">
		<?php get_template_part( 'content', 'spectacle' ); ?>
    	<?php $npost++; ?>
    	</div>
    <?php
		$contenu=ob_get_contents();
		$liste_annees[$annee][$post->ID]= $contenu;
		ob_end_clean();
	endwhile;
	
	//echo "<pre>".print_r($liste_annees,true)."</pre>";
	
		?>
        
        <?php
	$nonglet=0;
	foreach($liste_annees as $annee=>$contenuannee) {
		?>
    <a href="?annee=<?php echo $annee; ?>" aria-controls="home" role="tab" data-toggle="tab" class="button <?php if( ( !isset($_GET['annee']) && $nonglet!=0 ) || ( isset($_GET['annee']) && $annee!=$_GET['annee'] ) ) echo 'secondary'; ?>"><?php echo $annee . " <span class='badge'>".count($contenuannee)."</span>"; ?></a>
        <?php
		$nonglet++;
	}
		?>
        <!-- Tab panes -->
        <?php
	$nonglet=0;
	foreach($liste_annees as $annee=>$contenuannee) {
		if ( ( isset($_GET['annee']) && $annee==$_GET['annee'] ) || ( !isset($_GET['annee']) && $nonglet==0 ) ) {
		//echo "<pre>".print_r($contenuannee,true)."</pre>";
		?>
        	<div role="tabpanel" class="row" id="onglet<?php echo $annee; ?>"><?php foreach ($contenuannee as $iddiv=>$div) { ?><?php echo $div; ?><?php } ?></div>
        <?php
		}
		$nonglet++;
	}
		?>
        <?php
	
	
	
	
else :
	// If no content, include the "No posts found" template.
	get_template_part( 'content', 'none' );
endif;
?>
	</div><!-- .row -->
</div><!-- .container -->
<?php
//get_sidebar($type_du_post);
get_footer();