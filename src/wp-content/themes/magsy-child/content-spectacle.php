<?php
/**
 * @package wp-bootstrap
 */
$attr_small="h=446&w=315&zc=1&q=100";
$attr_large="wl=1000&hp=600&q=90";
$piece_meta=get_post_custom(get_the_ID()); 
$liste_dates = $piece_meta['details_date_de_representation']; 
?>
<?php edit_post_link( __( 'Edit', 'wp-bootstrap' ), '<span class="edit-link">', '</span>' ); ?>
<?php if (is_category()) { ?>
<a href="<?php the_permalink(); ?>"><?php the_title( '<h2 class="entry-title">', '</h2>' ); ?></a>
<?php } else { ?>
<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
<?php } ?>
<?php
echo vip_date($dates=$liste_dates); ?>
        
<?php $urlimage=get_image('details_affiche',1,1,0,NULL,$attr_small); ?>

<?php
/*****************************************************
**	SINGLE SPECTACLE								**
*****************************************************/
?>
<?php if (!is_category()) {?>
<div class="row">
    <div class="col-md-6 col-lg-4">
        <?php if (strlen($urlimage)>0) { ?>
        <a href="<?php echo get_image('details_affiche',1,1,0,NULL,$attr_large); ?>" rel="lightbox" targe="_blank"><img src="<?php echo $urlimage; ?>" class="img-responsive" border="0"/></a>
        <?php } ?>
    </div>
    <div class="col-md-6 col-lg-8">
    <?php the_content();  ?>
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php _e("Détails", "wp-bootstrap"); ?></h3>
    </div>
    <?php 
    $piece_meta=get_post_custom(get_the_ID()); 
    $liste_meta=array(
		'details_salle'=>array('titre'=>"Salle",'mdi'=>"mdi mdi-map-marker"),
		'details_date_de_representation'=>array('titre'=>"Dates",'mdi'=>"mdi mdi-calendar"),
		'details_horaire'=>array('titre'=>"Horaire",'mdi'=>"mdi mdi-clock-outline"),
		'details_tarif'=>array('titre'=>"Tarifs",'mdi'=>"mdi mdi-cash-100"),
		'details_reservation'=>array('titre'=>"Réservation",'mdi'=>"mdi mdi-book-plus"));
    ?>
    <div class="panel-body">
        <?php
        foreach($liste_meta as $champ=>$details) {
            if (strlen($piece_meta[$champ][0])>0) { ?>
        <div class="row">
            <div class="col-md-3"><i class="<?php echo $details['mdi']; ?>" title="<?php echo $details['titre']; ?>"></i> <?php echo $details['titre']; ?></div>
            <div class="col-md-9"><?php
                if ($champ=='details_salle') { echo get_the_title( $piece_meta[$champ][0] ); }
                else if ($champ=='details_date_de_representation') { foreach($piece_meta[$champ] as $ndate=>$date) $time = new DateTime($date); echo $time->format('d / m / Y'); }
                else { echo $piece_meta[$champ][0]; }
                ?></div>
            <div class="clearfix"></div>
        </div>
        <?php } // if (strlen($piece_meta[$champ][0])>0) {
        } ?>
    </div>
</div>

      <?php
        wp_link_pages( 'before=<div class="page-links">&after=</div>&link_before=<span>&link_after=</span>' );
        get_template_part( 'inc/partials/entry-tags' );
        magsy_ads( array( 'location' => 'after_post_content', 'container' => false ) );
        get_template_part( 'inc/partials/entry-action' );
        get_template_part( 'inc/partials/entry-navigation' );
        get_template_part( 'inc/partials/author-box' );
	  ?>
<?php
/*****************************************************
**	CATEGORY SPECTACLE								**
*****************************************************/
?>
<?php } else { ?>

<?php if (strlen($urlimage)>0) { ?>
	<a href="<?php echo get_image('details_affiche',1,1,0,NULL,$attr_large); ?>" rel="lightbox" targe="_blank"><img src="<?php echo $urlimage; ?>" class="img-responsive" border="0"/></a>
<?php } ?>

<?php 
the_excerpt();  ?>
<a href="<?php the_permalink(); ?>" class="button"><?php _e("Voir le spectacle", "wp-bootstrap"); ?></a>
<?php } ?>

      
<?php if (is_category()) { ?>
<?php } else { ?>
<?php /*if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
<span class="comments-link"><?php comments_popup_link( $zero=__( 'Laisser un commentaire', 'wp-bootstrap' ), $one=__( '1 Commentaire', 'wp-bootstrap' ), $more=__( '% Commentaires', 'wp-bootstrap' ),$css_class='button secondary' ); ?></span>
<?php endif; */ ?>
<?php } ?>