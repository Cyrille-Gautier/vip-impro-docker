<?php
/**
 * @package wp-bootstrap
 */
global $force_mini_spectacle;
//if (isset ($force_mini_spectacle) && intval($force_mini_spectacle) > 0 ) echo $force_mini_spectacle;
/*if (is_page('atelier-impro')) $args = array(
					'post_type'=>'spectacle',
					'post_status' => 'publish',
					'category__and' => array( 5,11 ),
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'posts_per_page' => -1
				);

else if (isset ($force_mini_spectacle) && intval($force_mini_spectacle) > 0 ) $args = array(
					'post_type'=>'any',
					'post_status' => 'publish', 
					'p' => $force_mini_spectacle
				);
else */$args = array(
					'post_type'=>'spectacle',
					'post_status' => 'publish',
					'cat' => 5,
					'meta_key'=> 'details_date_de_representation',
					'orderby' => 'meta_value',
					'order' => 'ASC',
					'posts_per_page' => 1
				);
?>
<?php
$query = new WP_Query( $args );
$cat = get_category( 5 ); ?>
<?php
if ( $query->have_posts() ) : 
	while ( $query->have_posts() ) : 
	$query->the_post();			
	$idDiapo=get_the_ID();	
	$elements = get_group('image'); 
	$nbslides=count($elements);
	//$imageAttributes = "w=978&h=350&q=90";
	?>
<!--div class="col-xs-6 col-sm-12"-->
<div class="col-md-4 col-sm-6">
	<?php 
    $attr_small="h=446&w=315&zc=1&q=100";
    $attr_large="wl=1000&hp=600&q=90";
    //$settings = array("w"=> 500, "zc" => 1, "q" =>80);
    $urlimage=get_image('details_affiche',1,1,0,NULL,$attr_small);
    //echo get_image('details_affiche',1);
    //echo get_image ($fieldName='details_affiche', $groupIndex=1, $fieldIndex=1,$tag_img=1,$post_id=get_the_ID(),$override_params=NULL);
    if (strlen($urlimage)>0) {
        // get_image ($fieldName, $groupIndex=1, $fieldIndex=1,$tag_img=1,$post_id=NULL,$override_params=NULL) ?>
    <a href="<?php echo get_permalink($post->ID); ?>" target="_blank"><img src="<?php echo $urlimage; ?>" class="affiche front img-responsive ombre" border="0"/></a>
    <?php } ?>
</div>
<div class="col-md-8 col-md-offset-4 col-sm-6 col-sm-offset-6 text-left">
<h1 class=""><?php echo $cat->name; ?></h1>
	<?php the_title( '<h2>', '</h2>' ); ?>


<!--div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php _e("Détails", "wp-bootstrap"); ?></h3>
    </div-->
    <?php 
    $piece_meta=get_post_custom(get_the_ID()); 
    $liste_meta=array(
		'details_salle'=>array('titre'=>"Salle",'mdi'=>"mdi mdi-map-marker"),
		'details_date_de_representation'=>array('titre'=>"Dates",'mdi'=>"mdi mdi-calendar"),
		'details_horaire'=>array('titre'=>"Horaire",'mdi'=>"mdi mdi-calendar-clock"),
		'details_tarif'=>array('titre'=>"Tarifs",'mdi'=>"mdi mdi-cash-multiple"),
		'details_reservation'=>array('titre'=>"Réservation",'mdi'=>"mdi mdi-send"));
    ?>
    <!--div class="panel-body"-->
    <br/>
        <div class="row">
        <?php
        foreach($liste_meta as $champ=>$details) {
            if (strlen($piece_meta[$champ][0])>0) { ?>
            <div class="col-sm-1 col-xs-1"><i class="<?php echo $details['mdi']; ?>" title="<?php echo $details['titre']; ?>"></i></div>
            <div class="col-sm-11 col-xs-5"><?php
                if ($champ=='details_salle') { echo get_the_title( $piece_meta[$champ][0] ); }
                else if ($champ=='details_date_de_representation') { foreach($piece_meta[$champ] as $ndate=>$date) $time = new DateTime($date); echo $time->format('d / m / Y'); }
                else { echo $piece_meta[$champ][0]; }
                ?></div>
        <?php } // if (strlen($piece_meta[$champ][0])>0) {
        } ?>
        </div>
    <!--/div>
</div-->




<br />
<a href="<?php echo get_permalink($post->ID); ?>" class="button secondary" target="_blank"><i class="mdi mdi-hand-pointing-right
"></i> En savoir plus</a> 
<br />

</div>

<div class="col-md-12">
<?php edit_post_link( __( 'Editer', 'wp-bootstrap' ), '<span class="edit-link">', '</span>' ); ?>
</div>

<?php
	endwhile;
endif;
?>
<br />
