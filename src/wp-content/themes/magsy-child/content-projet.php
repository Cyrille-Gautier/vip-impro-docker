<?php
/**
 * @package wp-bootstrap
 */
//var_dump($_SESSION);

global $hide_footer, $hide_header;
//delete_post_meta($post_id=get_the_ID(), $meta_key='agenda_resultat');
?>
<?php  
//s:327:"s:318:"a:3:{i:0;a:3:{s:4:"name";s:7:"Cyrille";s:7:"id_post";s:4:"1560";s:5:"choix";a:3:{i:1;s:1:"1";i:2;s:1:"1";i:3;s:1:"1";}}i:1;a:3:{s:4:"name";s:8:"Emmanuel";s:7:"id_post";s:4:"1560";s:5:"choix";a:3:{i:1;N;i:2;N;i:3;s:1:"1";}}i:2;a:3:{s:4:"name";s:6:"Alexis";s:7:"id_post";s:4:"1560";s:5:"choix";a:3:{i:1;N;i:2;N;i:3;N;}}}";";
/*********************************************************
**	Affichage des miniatures pour la page catégorie		**
*********************************************************/
if(!is_single()) { 
	$liste_dates=get_post_meta(get_the_ID(), 'details_date_finale', false);
	$vip_date=vip_date($dates=$liste_dates); 
	$color=(preg_match("/a_venir/", $vip_date))?'beige3':'gris';
	$statut = get_post_meta( get_the_ID(), 'details_statut', true ); 
	$referent = get_post_meta( get_the_ID(), 'details_referent', true );  ?>
    <!-- content-projet -->
<div class="row no-margin fond <?php echo $color; ?> statut-<?php echo $statut; ?>">
   	<?php if ( isset($statut) && strlen($statut)>0) { ?><div class="signet_statut"><h3><?php echo $statut; ?></h3></div><?php } ?>
	<?php
	$idrelated = get_post_meta( get_the_ID(), 'details_spectacle', true );//get_post_meta( $post_id, $key, $single ); 
    if( isset($idrelated) && is_array($idrelated) && count( $idrelated )>0 ) $idrelated=$idrelated[0]; 
    if( isset($idrelated) && strlen( $idrelated )>0 ) { ?>
    <div class="col-md-6">
		<?php 
        $attr_small="h=446&w=315&zc=1&q=100";
        $attr_large="wl=1000&hp=600&q=90";
        //$settings = array("w"=> 500, "zc" => 1, "q" =>80);
        $urlimage=get_image ($fieldName='details_affiche', $groupIndex=1, $fieldIndex=1,$tag_img=0,$post_id=$idrelated,$override_params=$attr_small);
		//echo 'image:'.print_r($idrelated,true)." ".$urlimage; ?>
        <?php 
        if (strlen($urlimage)>0) {
            // get_image ($fieldName, $groupIndex=1, $fieldIndex=1,$tag_img=1,NULL,$override_params=NULL) ?>
        <a href="<?php the_permalink(); ?>" target="_self"><img src="<?php echo $urlimage; ?>" class="img-responsive" border="0"/></a>
        <?php } ?>
    </div>
    <div class="col-md-6">
    <?php } else { ?>
    <div class="col-md-6">
    <?php
        $urlimage=get_stylesheet_directory_uri()."/images/les_VIP_affiche_generique.jpg";
		//echo 'image:'.print_r($idrelated,true)." ".$urlimage; ?>
        <?php 
        if (strlen($urlimage)>0) {
            // get_image ($fieldName, $groupIndex=1, $fieldIndex=1,$tag_img=1,NULL,$override_params=NULL) ?>
        <a href="<?php the_permalink(); ?>" target="_self"><img src="<?php echo $urlimage; ?>" class="img-responsive" border="0"/></a>
        <?php } ?>
    </div>
    <div class="col-md-6">
    <?php } ?>
	<?php
	echo $vip_date; ?>
        <a href="<?php the_permalink(); ?>" target="_self"><?php the_title( '<h1 class="entry-title">', '</h1>' ); ?></a>
        <p><?php the_excerpt(); ?></p>
        <?php if (isset($referent) && strlen($referent)>0) { ?><p><i class="mdi mdi-account"></i> <?php echo $referent; ?></p><?php } ?>
        <p class="text-center"><a href="<?php the_permalink(); ?>" target="_self" class="button"><i class="mdi mdi-star"></i> Lire le projet</a></p>
    </div>
    <div class="col-md-12"><?php edit_post_link( '<i class="mdi mdi-pencil"></i> '.__( 'Editer', 'wp-bootstrap' ), '<span class="edit-link">', '</span>' ); ?></div>
</div>
<?php 

/*********************************************************
**	Affichage single									**
*********************************************************/
} else { ?>
<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
<?php	
	$liste_dates=get_post_meta(get_the_ID(), 'details_date_finale', false);
	$vip_date=vip_date($dates=$liste_dates); 
	$color=(preg_match("/a_venir/", $vip_date))?'beige3':'gris';
	$statut = get_post_meta( get_the_ID(), 'details_statut', true ); 
	$referent = get_post_meta( get_the_ID(), 'details_referent', true );  ?>
    <div class="clearfix"></div>
<div class="row fond <?php echo $color; ?> statut-<?php echo $statut; ?>" style="position:relative">
   	<?php if ( isset($statut) && strlen($statut)>0) { ?><div class="signet_statut"><h3><?php echo $statut; ?></h3></div><?php } ?>
	<?php
	$idrelated = get_post_meta( get_the_ID(), 'details_spectacle', true );//get_post_meta( $post_id, $key, $single ); 
    if( isset($idrelated) && is_array($idrelated) && count( $idrelated )>0 ) $idrelated=$idrelated[0]; 
    if( isset($idrelated) && strlen( $idrelated )>0 ) { ?>
    <div class="col-md-4">
		<?php 
        $attr_small="h=446&w=315&zc=1&q=100";
        $attr_large="wl=1000&hp=600&q=90";
        //$settings = array("w"=> 500, "zc" => 1, "q" =>80);
        $urlimage=get_image ($fieldName='details_affiche', $groupIndex=1, $fieldIndex=1,$tag_img=0,$post_id=$idrelated,$override_params=$attr_small);
		//echo 'image:'.print_r($idrelated,true)." ".$urlimage; ?>
        <?php 
        if (strlen($urlimage)>0) {
        ?>
        <img src="<?php echo $urlimage; ?>" class="img-responsive" border="0"/>
        <?php } ?>
    </div>
    <div class="col-md-8">
    <?php } else { ?>
    <div class="col-md-4">
    <?php
        $urlimage=get_stylesheet_directory_uri()."/images/les_VIP_affiche_generique.jpg";
		//echo 'image:'.print_r($idrelated,true)." ".$urlimage; ?>
        <?php 
        if (strlen($urlimage)>0) {
            // get_image ($fieldName, $groupIndex=1, $fieldIndex=1,$tag_img=1,NULL,$override_params=NULL) ?>
        <a href="<?php the_permalink(); ?>" target="_self"><img src="<?php echo $urlimage; ?>" class="img-responsive" border="0"/></a>
        <?php } ?>
    </div>
    <div class="col-md-8">
    <?php } ?>
	<?php
	echo $vip_date; ?>
        <p><?php the_content('Lire la suite', true); ?></p>
        <p class="text-center"><?php edit_post_link( '<i class="mdi mdi-pencil"></i> '.__( 'Editer', 'wp-bootstrap' ), NULL, NULL, $id=NULL, $class="button secondary" ); ?></p>
    </div>
</div>
<div class="row">
<?php 
global $current_user;
get_currentuserinfo();
if (is_user_logged_in() && ( $current_user->ID == $post->post_author || current_user_can( 'manage_options' ) ) ) { ?>
	<div class="col-md-12">
	<?php get_template_part( 'content', 'projet-programme' ); ?>
    </div>
    <?php
}
//echo "if (is_user_logged_in() =".is_user_logged_in()." && ( $current_user->ID =".$current_user->ID ." == $post->post_author =".$post->post_author." || current_user_can( 'manage_options' ) =".current_user_can( 'manage_options' ).") ";
?>

<?php
	
	$liste_custom_fields=array( 
								'agenda'=>						array("legende"=>"Agenda", "groupe"=>1, "type"=>"agenda", "duplicable"=>1, "elements"=>array(
										'agenda_date' => 		array("legende"=>"Date"),
										'agenda_heure' => 		array("legende"=>"Heure"), 
									)
								),
								'details_date_finale'=>			array("legende"=>"Date finale", 	"type"=>"date"),
								'details_spectacle' => 			array("legende"=>"Spectacle", "type"=>"related"),
								'details_salle' => 				array("legende"=>"Salle", "type"=>"related"),
								'details_referent' => 			array("legende"=>"Référent"), 
								'details_accessoires' => 		array("legende"=>"Accessoires"), 
								'details_costumes_et_maquillages' => array("legende"=>"Costumes / Maquillage"), 
								'details_decors' => 			array("legende"=>"Décors"), 
								'details_equipe' => 			array("legende"=>"Equipe"), 
								'details_autres' => 			array("legende"=>"Autres"), 
								'details_statut' => 			array("legende"=>"Statut"), 
								'document_de_travail'=>			array("legende"=>"Documents", "groupe"=>1, "type"=>"fichiers", "duplicable"=>1, "elements"=>array(
										'document_de_travail_fichier' => 		array("legende"=>"Fichier"),
										'document_de_travail_legende' => 		array("legende"=>"Legende"), 
									)
								), 
							); ?>
	<?php
    /*------------------------------------------------------------
    --			Traitement par groupe des custom fields			--
    ------------------------------------------------------------*/
    foreach($liste_custom_fields as $idfield=>$donneesfield) { 
        /*------------------------------------------------------------
        --					Groupes de custom fields				--
        ------------------------------------------------------------*/
        if($donneesfield['groupe']==1 && $donneesfield['type']=="fichiers") { 
			/* magic fields */
            $listefichiers=get_post_meta(get_the_ID(), $idfield."_fichier", false);
            $listelegendes=get_post_meta(get_the_ID(), $idfield."_legende", false);
			/* acf */
            if (have_rows('document_de_travail') ): 
				while( have_rows('document_de_travail') ): the_row();
					$fichier = get_sub_field('document_de_travail_fichier');
					$legende = get_sub_field('document_de_travail_legende');
				//Array ( [0] => [1] => Array ( [id] => 1766 [alt] => [title] => Contrat_improvisationABIVIS (1) [caption] => [description] => [mime_type] => application/msword [url] => http://www.vip-impro.fr/wp-content/uploads/2018/02/Contrat_improvisationABIVIS-1.doc ) )
					$listefichiers[]=$fichier['url'];
					$listelegendes[]=$legende;
					//echo "<pre>".print_r($listefichiers,true)."</pre>";
				endwhile;
			endif;
            if (count($listefichiers[0])>0) { ?>
	<div class="col-md-12">
        
        <div class="panel panel-default">
          <div class="panel-heading"><?php echo $donneesfield['legende']; ?></div>
          <div class="panel-body" style="min-height:110px;">
        	<ul>
            <?php
                //$listefichiers=get_post_meta(get_the_ID(), $idfield."_fichier", false);
                //$listelegendes=get_post_meta(get_the_ID(), $idfield."_legende", false);
                foreach($listefichiers as $idfichier=>$donneesfichier) { 
					if(isset($donneesfichier) && strlen($donneesfichier)>0) {
						if(preg_match("#http#", $donneesfichier)) { ?>
                <li><a href="<?php echo $donneesfichier; ?>" target="_blank" class="button"><?php echo (strlen($listelegendes[$idfichier])>0)?$listelegendes[$idfichier]:$donneesfichier; ?></a></li>
                <?php 	} else { ?>
                <li><a href="<?php echo get_bloginfo('url'); ?>/wp-content/files_mf/<?php echo $donneesfichier; ?>" target="_blank" class="button"><?php echo (strlen($listelegendes[$idfichier])>0)?$listelegendes[$idfichier]:$donneesfichier; ?></a></li>
                <?php 	} ?>
                <?php }
                }// fin foreach($donneesfield['elements'] as $idelement=>$donneeselement)
            ?>
        	</ul>
        	</div>
        </div>
        
    </div>
    <?php	} 
        /*------------------------------------------------------------
        --					AGENDA									--
        ------------------------------------------------------------*/
        } else if($donneesfield['groupe']==1 && $donneesfield['type']=="agenda") { 
			global $liste_colonnes_agenda;
            //$liste_colonnes_agenda= get_group ('agenda');    //  héritage MagicFields     
			//echo "<pre>".print_r($liste_colonnes_agenda,true)."</pre>";     
            //if (!isset($liste_colonnes_agenda) || !is_array($liste_colonnes_agenda)) { 
				if( have_rows('agenda') ): 
					while( have_rows('agenda') ): the_row();
						$datetext=get_sub_field('agenda_date');
						$heure=get_sub_field('agenda_heure');
						$time = new DateTime($datetext);
						$datetext=$time->format('d/m/Y');
						$datebrute=$time->format('Y-m-d');
						$liste_colonnes_agenda[$datebrute."-".trim($heure)]=array(	'agenda_type'=>array(1=>get_sub_field('agenda_type')),
														'agenda_date'=>array(1=>$datetext),
														'agenda_date_brute'=>array(1=>get_sub_field('agenda_date')),
														'agenda_heure'=>array(1=>get_sub_field('agenda_heure')),
													);
					endwhile;
				endif;
			//}           
			//echo "<pre>".print_r($liste_colonnes_agenda,true)."</pre>";   
            if (isset($liste_colonnes_agenda) && is_array($liste_colonnes_agenda)) { 
				global $agenda_resultat, $agenda_roles;
				/* magic fields */
				$agenda_resultat=get_post_meta( $post_id  = get_the_ID(), $key = 'agenda_resultat', $single = true );
				$agenda_roles=get_post_meta( $post_id  = get_the_ID(), $key = 'details_agenda_roles', $single = true );
				/* acf */
				if( !isset($agenda_resultat) || !strlen($agenda_resultat)>0 ) $agenda_resultat=get_field( $key = 'agenda_resultat', $post_id  = get_the_ID() );
				if( !isset($agenda_roles) || !count($agenda_roles)>0 ) $agenda_roles=get_field( $key = 'details_agenda_roles', $post_id  = get_the_ID() );
				if(!isset($agenda_resultat)) $agenda_resultat="";
				//echo "<h1>resultat</h1><pre>".print_r($agenda_resultat,true)."</pre>"; 
				?>
			<div class="col-md-12">
			<?php get_template_part( 'content', 'projet-agenda' ); ?>
            </div>
            <?php
            }
        /*------------------------------------------------------------
        --						Custom fields seuls					--
        ------------------------------------------------------------*/
        } else { 
		?>
        
    	<?php
			/* magic fields */
            $contenufield = get_post_meta( get_the_ID(), $idfield, true );
			//echo "<pre>".$idfield.get_the_ID()."\n".print_r($contenufield, true)."</pre>";
			/* acf */
			if (!isset($contenufield) || !count($contenufield)>0) $contenufield = get_field( $idfield, get_the_ID() ); 
			//echo "<pre>".$idfield.get_the_ID()."\n".print_r($contenufield, true)."</pre>";
            if ( ( is_array($contenufield) && count($contenufield)>0 ) || ( isset($contenufield) && strlen($contenufield)>0 ) ) { ?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                      <div class="panel-heading"><?php echo $donneesfield['legende']; ?></div>
                      <div class="panel-body" style="min-height:110px;">
                        <?php 
						if ($donneesfield['type']=="date") {	
							$time = new DateTime($contenufield);
							echo $time->format('d / m / Y');
						} else if ($donneesfield['type']=="related") { 
							$idrelated = get_post_meta( get_the_ID(), $idfield, true );//get_post_meta( $post_id, $key, $single ); 
							if( !isset($idrelated) || !count($idrelated)>0 ) $idrelated=get_field( $key = $idfield, $post_id  = get_the_ID() );
							if( is_array( $idrelated )  ) { 
								$idrelated=$idrelated[0];
							}
							//print_r($idrelated);
							if( strlen( $idrelated )>0 ) { 
								global $force_mini_spectacle;
								$force_mini_spectacle=$idrelated;  ?>
							<a href="<?php echo get_permalink($idrelated); ?>" target="_blank" class="button"><?php echo get_the_title($idrelated); ?></a>
							<?php /**/
							}
						} else { ?>
							<?php echo nl2br($contenufield); ?>
						<?php
						}
						?>
                      </div>
                    </div>
                </div>
	<?php 	}
        } 
    }
}
?>