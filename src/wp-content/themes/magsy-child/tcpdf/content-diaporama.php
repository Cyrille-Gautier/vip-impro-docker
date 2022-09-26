<?php
/**
 * @package arteck
 */
$nbImages=0;
$imageSuivante = get_image('photo_'.get_post_type().'_1',1,1,0,NULL, "zc=1&q=90");
for($nImage=1; $imageSuivante != ''; $nImage++) {
	$images[$nImage]['max'] = get_image('photo_'.get_post_type().'_'.$nImage,1,1,0,NULL, "zc=1&q=90"); 
	$images[$nImage]['large'] = get_image('photo_'.get_post_type().'_'.$nImage,1,1,1,NULL, "w=960h=300&zc=1&q=90"); 
	$images[$nImage]['small'] = get_image('photo_'.get_post_type().'_'.$nImage,1,1,1,NULL, "w=200&h=200&zc=1&q=90"); 
	if ($images[$nImage]['large'] != "") $nbImages++ ;
	$imageSuivante = get_image('photo_'.get_post_type().'_'.$nImage,1,1,0,NULL, "zc=1&q=90"); 
}
$onglets_specifications=array();
$specifications = get_group('specifications');
foreach($specifications as $idspecification=>$specification){
	$titrespec 		= get('specifications_titre',$idspecification);
	$titrespecalt 	= get('specifications_titre_autre',$idspecification);
	if(strlen($titrespecalt)>0) $titrespec = $titrespecalt;
	$description 	= get('specifications_description',$idspecification);
	$imagesspec		= array();
	$imageSuivante = get_image('specifications_image',$idspecification,1,0,NULL, "zc=1&q=90");
	for($nImage=1; $imageSuivante != ''; $nImage++) {
		$imagesspec[$nImage]['max'] = 	get_image($fieldName='specifications_image',$groupIndex=$idspecification,$fieldIndex=$nImage,$tag_img=0,$post_id=NULL, $override_params="zc=1&q=90"); 
		$imagesspec[$nImage]['large'] = get_image($fieldName='specifications_image',$groupIndex=$idspecification,$fieldIndex=$nImage,$tag_img=0,$post_id=NULL, $override_params="w=960h=300&zc=1&q=90"); 
		$imagesspec[$nImage]['small'] = get_image($fieldName='specifications_image',$groupIndex=$idspecification,$fieldIndex=$nImage,$tag_img=0,$post_id=NULL, $override_params="w=200&h=200&zc=1&q=90"); 
		$imageSuivante = get_image('specifications_image',$idspecification,$nImage+1,0,NULL, "zc=1&q=90");
	}
	//get_image ($fieldName='specifications_image', $groupIndex=1, $fieldIndex=1,$tag_img=1,$post_id=NULL,$override_params=NULL)  
	if(!empty($titrespec)){
		$onglets_specifications[$idspecification]=array("titre" => $titrespec, "description" => $description, "images"=>$imagesspec);
	}
}
	/*echo "<pre>".print_r($onglets_specifications, true)."</pre>";*/
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if (is_search()) echo $post->post_type; ?>
    
	<div class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
        <?php if ( has_excerpt( $post->ID ) ) : ?>
        	<h4><?php the_excerpt(); ?></h4>
        <?php endif ?> 	
	</div><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>    
        <div class="entry-content">
            
			<?php if ( $nbImages <= 1 ) : ?>
            	<div class="single-image">
					<?php foreach($images as $nImage => $image ) {
                        if($image['large'] != "") {
							echo '<a href="'.$image['max'].'" title="'.get_the_title().'" data-rel="lightbox-0" class="image-action">';
								echo '<i class="fa fa-search-plus" aria-hidden="true"></i>';
							echo '</a>';
							echo $image['large'];
						}
					} ?>
                 </div><!-- .single-image -->
                
            <?php else : ?>	
            	<div class="diaporama">
                     <!-- Nav tabs -->
                    
                    <ul class="nav col-sm-12" role="tablist">
                        <?php $classActive = "active";
                        foreach($images as $nImage => $image ) {
                            if($image['small'] != "") {
                                echo '<li role="presentation" class="'.$classActive.' col-sm-1"><a href="#image'.$nImage.'" aria-controls="image'.$nImage.'" role="tab" data-toggle="tab" data-hover="tab">'.$image['small'].'</a></li>';
                                $classActive = "";
                            }
                        } ?>
                    </ul>
                    <div class="clearfix clear-xs"></div>
                    <!-- Tab panes -->
                    <div class="tab-content col-sm-12 no-padding-sm-left">
                        <?php $classActive = "in active";
                        foreach($images as $nImage => $image ) {
                            if($image['large'] != "") {
                                echo '<div role="tabpanel" class="tab-pane fade '.$classActive.'" id="image'.$nImage.'">';
                                    echo '<a href="'.$image['max'].'" title="'.get_the_title().'" data-rel="lightbox-0" class="image-action">';
                                        echo '<i class="fa fa-search-plus" aria-hidden="true"></i>';
                                    echo '</a>';
                                    echo $image['large'];
                                echo '</div>';
                                $classActive = "";
                            }
                        } ?>
                    </div>
                    <div class="clearfix"></div>
                    
                </div><!-- .diaporama -->
            <?php endif; ?>
            
            
            <div class="col-sm-12">
            	<?php the_content( __( 'Lire la suite <span class="meta-nav">&rarr;</span>', 'office-concept') ); ?>
            </div>
        </div><!-- .entry-content -->
	<?php endif; ?>

	<?php // Bouton Favoris
		if ($_SESSION['favoris'][$post->ID]=='favori') { 
			$pre_fav = "Cet article est présent dans vos Favoris : ";
			$titre_bouton = __("Retirer des favoris",'office-concept'); 
			$action_bouton = "supprimer"; 
			$style="active";
		} else { 
			$pre_fav = "Pour obtenir un devis : ";
			$titre_bouton = __("Ajouter aux favoris",'office-concept'); 
			$action_bouton = "ajouter";  
			$style="";
		} ?>

		<?php if (get_post_type() == "produit") : ?>  
			<div class="produit favoris right">
				<span><?php echo $pre_fav; ?></span>
				<form class="favoris" name="favoris" action="" method="post">
					<input type="hidden" name="titre_produit" value="<?php echo $post->post_title; ?>" />
					<input type="hidden" name="id_produit" value="<?php echo $post->ID; ?>" />
					<input type="hidden" name="action_favoris" value="<?php echo $action_bouton; ?>" />
					<input type="submit" class="btn btn-primary btn-favoris <?php echo $style; ?>" value="<?php echo $titre_bouton; ?>" name="envoyer" ajaxproduit="<?php echo $post->ID; ?>" ajaxaction="<?php echo $action_bouton; ?>" />
				</form>
			</div>
		<?php endif; ?>


	<div class="col-sm-12 accord">
		<?php $surmesure = get('sur_mesure'); 
		if($surmesure){ ?>
			<span class="surmesure-label">Sur mesure</span>
		<?php } ?>

		<?php $garantie3 = get('garantie_3');
			if($garantie3){ ?>
				<span class="garantie-label">
					<img src="<?php echo get_template_directory_uri(); ?>/images/garantie_3.png" alt="Garantie 3 ans" width="90" height="90" />
				</span>
		<?php } ?>

		<?php $garantie5 = get('garantie_5');
			if($garantie5){ ?>
				<span class="garantie-label">
					<img src="<?php echo get_template_directory_uri(); ?>/images/garantie_5.png" alt="Garantie 5 ans" width="90" height="90" />
				</span>
		<?php } ?>

		<?php $garantie10 = get('garantie_10');
			if($garantie10){ ?>
				<span class="garantie-label">
					<img src="<?php echo get_template_directory_uri(); ?>/images/garantie_10.png" alt="Garantie 10 ans" width="90" height="90" />
				</span>
		<?php } ?>

		<?php
		/*--------------------------------------------------------
		--	SPECIFICATIONS : ONGLETS
		--------------------------------------------------------*/
		if (count($onglets_specifications)>0) { ?>
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" id="specTabs" role="tablist">
			<?php $nonglet =0; 
			foreach ($onglets_specifications as $idonglet=>$onglet) { ?>
		    <li role="presentation" class="<?php if ($nonglet == 0){echo 'active';} ?> hidden-xs"><a href="#specification<?php echo $idonglet; ?>" aria-controls="specification<?php echo $idonglet; ?>" role="tab" data-toggle="tab"><?php echo $onglet['titre']; ?></a></li>
			<?php $nonglet++;
			} ?>

			

			<li role="presentation" class="dropdown visible-xs">
				<a href="#" class="dropdown-toggle" id="specTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false">		<?php /*echo $onglets_specifications[1]['titre'];*/ ?> <?php _e('Spécifications','office-concept'); ?>
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu" aria-labelledby="specTabDrop1" id="specTabDrop1-contents">
				<?php foreach ($onglets_specifications as $idonglet=>$onglet) { ?>
		    		<li>
		    			<a href="#specification<?php echo $idonglet; ?>" id="dropdown<?php echo $idonglet; ?>-tab" aria-controls="specification<?php echo $idonglet; ?>" role="tab" data-toggle="tab">
		    				<?php echo $onglet['titre']; ?>
		    			</a>
		    		</li>
				<?php $nonglet++;
				} ?>
				</ul>
			</li>

		  </ul>
		<?php } ?>

		<?php 
		/*--------------------------------------------------------
		--	SPECIFICATIONS : CONTENUS
		--------------------------------------------------------*/
		if (count($onglets_specifications)>0) { ?>
		  <!-- Tab panes -->
		  <div class="tab-content">
			<?php $nonglet =0; 
			foreach ($onglets_specifications as $idonglet=>$onglet) {?>
		    <div role="tabpanel" class="tab-pane fade <?php if ($nonglet == 0){echo 'in active';} ?>" id="specification<?php echo $idonglet; ?>">
				
					<?php if (($onglet['titre']=="Nuancier") && (!$onglet['description']) && (!$onglet['images']) ) { ?>
						<img src="http://www.office-concept.fr/wp-content/uploads/sites/5/2017/01/Nuancier-Office-Concept-New-300x155.jpg"
							alt="Nuancier Office Concept - New" width="817" height="422"
							srcset="http://www.office-concept.fr/wp-content/uploads/sites/5/2017/01/Nuancier-Office-Concept-New-300x155.jpg 300w, http://www.office-concept.fr/wp-content/uploads/sites/5/2017/01/Nuancier-Office-Concept-New-768x398.jpg 768w, http://www.office-concept.fr/wp-content/uploads/sites/5/2017/01/Nuancier-Office-Concept-New.jpg 960w"
							sizes="(max-width: 817px) 100vw, 817px"/>
						<p><a href="http://www.office-concept.fr/contact/"><?php _e("Pour avoir plus d'informations sur le nuancier"); ?></a></p>
					<?php }elseif(($onglet['titre']=="Ergonomie") && (!$onglet['description']) && (!$onglet['images']) ){ ?>
						<img src="http://www.office-concept.fr/wp-content/uploads/sites/5/2017/03/conseil-ergonomie.png"
							alt="Nuancier Office Concept - New" width="969" height="1707"
							srcset="http://www.office-concept.fr/wp-content/uploads/sites/5/2017/03/conseil-ergonomie.png 300w, http://www.office-concept.fr/wp-content/uploads/sites/5/2017/03/conseil-ergonomie.png 768w, http://www.office-concept.fr/wp-content/uploads/sites/5/2017/03/conseil-ergonomie.png 960w"
							sizes="(max-width: 817px) 100vw, 817px"/>
					<?php }else{ ?>
						<p><?php echo $onglet['description']; ?></p>
						<?php if (count($onglet['images'])>0) { 
						foreach ($onglet['images'] as $idimage=>$image) { 
							//print_r($image); ?>
						<?php /*<img src="<?php echo $image['small']; ?>" class="img-thumbnail" title="thumbnail" />
						<img src="<?php echo $image['large']; ?>" title="large" />*/ ?>
						<img src="<?php echo $image['max']; ?>" title="max" />
				        <?php } ?>
					<?php } ?>

				<?php } ?>
		    </div>
			<?php $nonglet++;
			} ?>
		  </div>
		  <div class="back-top">
				<a href="" id="toTop"><?php _e('Retour haut de page','office-concept'); ?></a></p>
			</div>
		<?php } ?>
	</div>

	



	<div class="entry-footer">
		<?php edit_post_link( __( 'Editer', 'office-concept' ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-footer -->
</div><!-- #post-## -->