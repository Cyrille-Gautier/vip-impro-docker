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
 
/*,$args = array_merge( $wp_query->query, array( 'post_type' => 'projet' ) );
	'meta_key'			=> 'details_date_finale',
	'orderby'			=> 'meta_value',
	'order'				=> 'DESC'*/
$args = array_merge( $wp_query->query, array( 
	'post_type' 		=> 'projet',
	'posts_per_page' 	=> '-1',
	'meta_key'			=> 'details_date_finale',
	'orderby'			=> 'meta_value',
	'order'				=> 'DESC' ) ); 
query_posts( $args );
if ( have_posts() ) : ?>
	<?php
	// Start the Loop.
	$liste_projets_par_date=array('annee'=>array());
	$npost=0;
	$liste_annees=array();
	while ( have_posts() ) : the_post();
		$projet_meta=get_post_custom($post->ID); 
		$liste_dates = $projet_meta['details_date_finale']; 
		if (is_array($liste_dates)) $date_affichee = new DateTime($liste_dates[0]); 
		else $date_affichee = new DateTime($liste_dates); 
		$annee = $date_affichee->format('Y');
		// ----- afficher date finale ----
		list($day_of_week,$date_day,$date_month,$date_year) = vip_date( $dates=$liste_dates, $style_date="passe", $return_array=true);
		ob_start();
	?>
    	<div class="col-md-6 projet">
		<?php if($post->post_type=='projet') { ?>
		<?php get_template_part( 'content', 'projet' ); ?>
        <?php }  ?>
    	<?php $npost++; ?>
    	</div>
    <?php
		
		$contenu=ob_get_contents();
		$liste_annees[$annee][$post->ID]= $contenu;
		
		ob_end_clean();
		$liste_projets_par_date['annee'][$date_year]['mois'][$date_month]['jour'][$date_day]['projet'][get_the_ID()]=get_the_title(); //$content;
	endwhile;
	
       
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
else :
	// If no content, include the "No posts found" template.
	get_template_part( 'content', 'none' );
endif;
if($_GET['demo']=="ok") {
	//echo "<pre>".print_r($liste_projets_par_date,true)."</pre>";
	/*Array
(
    [annee] => Array
        (
            [2018] => Array
                (
                    [mois] => Array
                        (
                            [04] => Array
                                (
                                    [jour] => Array
                                        (
                                            [12] => Array
                                                (
                                                    [projet] => Array
                                                        (
                                                            [1764] => Match d'improvisation VIP TIFF
                                                        )

                                                )

                                            [21] => Array
                                                (
                                                    [projet] => Array
                                                        (
                                                            [1704] => Impro Serezin 21 avril
                                                        )

                                                )*/
	/* */?>
    <table class="agenda" width="100%" cellpadding="0" cellspacing="0">
    	<tbody>
        	<?php
			$pair=1;
			$start_table=false;
			$currenty=NULL;
			$currentm=NULL;
			$nprojet=0;
			for ($y=date('Y')+1; $y>=date('Y')-1; $y--) { 
				for ($m=12; $m>=1; $m--) {
					$nbjours=cal_days_in_month ( CAL_GREGORIAN, $m, $y );
					for ($d=$nbjours; $d>=1; $d--) { 
						$checkprojet=$liste_projets_par_date['annee'][$y]['mois'][substr('0'.$m,-2)]['jour'][substr('0'.$d,-2)];
						if (isset($checkprojet)) $start_table=true;
						if ($start_table==true) { 
							?>
            		<?php if ($y!=$currenty) { $currenty=$y; ?><tr><th colspan="3"><h2 class="text-center"><?php echo $y; ?></h2></th></tr><?php } ?>
            		<?php if ($m!=$currentm) { $currentm=$m; ?><tr><th colspan="3"><h3 class="text-center"><?php $monthName = date('F', mktime(0, 0, 0, $m, 10)); echo $monthName; ?></h3></th></tr><?php } ?>
                    <tr>
                    	<td width="40%" align="left"><?php if($pair==1 && isset($checkprojet)) { foreach($checkprojet['projet'] as $idprojet=>$projet) echo '<a href="'.get_permalink($idprojet).'" class="button secondary bulle bulle-right"><i class="mdi mdi-calendar"></i> '.$projet.'</a>'; }//"<pre>".print_r($checkprojet,true)."</pre>"; ?></td>
                        <td width="20%" align="center"><span class="badge"><?php if(isset($checkprojet)) echo "<b>".substr('0'.$d,-2)."</b>"; else echo substr('0'.$d,-2); ?></span><?php //echo $nprojet."/".$npost; ?></td>
                    	<td width="40%" align="right"><?php if($pair==-1 && isset($checkprojet)) { foreach($checkprojet['projet'] as $idprojet=>$projet) echo '<a href="'.get_permalink($idprojet).'" class="button secondary bulle bulle-left"><i class="mdi mdi-calendar"></i> '.$projet.'</a>'; } //"<pre>".print_r($checkprojet,true)."</pre>"; ?></td>
                    </tr>
                    <?php
						if (isset($checkprojet)) $pair*=-1;
						if (isset($checkprojet)) $nprojet++;
						if($nprojet>=$npost) $start_table=false;
						}
					}
				}
			}
			?>
                        
        </tbody>
    </table>
    <?php /**/
}
?>
	</div><!-- .row -->
</div><!-- .container -->
<?php
//get_sidebar($type_du_post);
get_footer();