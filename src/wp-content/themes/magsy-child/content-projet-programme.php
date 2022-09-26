<?php
/**
 * @package wp-bootstrap
 */
/*
if (isset($_SESSION['flashbag'])) {
	foreach ($_SESSION['flashbag'] as $flashbag) {
		echo '<div class="alert alert-'.$flashbag['status'].'">'.$flashbag['text'].'</div>';
		unset($flashbag);
	}
}
*/
?>
<?php  
//s:327:"s:318:"a:3:{i:0;a:3:{s:4:"name";s:7:"Cyrille";s:7:"id_post";s:4:"1560";s:5:"choix";a:3:{i:1;s:1:"1";i:2;s:1:"1";i:3;s:1:"1";}}i:1;a:3:{s:4:"name";s:8:"Emmanuel";s:7:"id_post";s:4:"1560";s:5:"choix";a:3:{i:1;N;i:2;N;i:3;s:1:"1";}}i:2;a:3:{s:4:"name";s:6:"Alexis";s:7:"id_post";s:4:"1560";s:5:"choix";a:3:{i:1;N;i:2;N;i:3;N;}}}";";
?>
<?php
/****************************************************************/
/*	TABLEAU DES FICHES DU PROGRAMME								*/
/****************************************************************/
if( have_rows('fiche') ): 
	require_once("tcpdf/tcpdf_vip.php");
	$pdf = new TCPDF_VIP(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetTitle('Programme VIP Projet '.get_the_ID()." ".get_the_title());
	$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 200)));
	
	?>
<!-- Modal -->
<div class="modal fade" id="modalProgramme" tabindex="-1" role="dialog" aria-labelledby="modalProgrammeLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalProgrammeLabel">Programme</h4>
      </div>
      <div class="modal-body">
	<table class="table table-striped table-hover" width="100%">
		<thead>
			<tr>
				<th>Début</th>
				<th>Durée</th>
				<th>Durée Animation</th>
				<th>Fin</th>
				<th>Catégorie</th>
				<th>Type</th>
				<th>Nb joueurs</th>
				<th>Nb joueurs scène</th>
				<th>Nb public</th>
				<th>Memento</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$nfiche=0;
		$duree_totale=0;
		$debut_row=0;
		$fin_row=0;
		$hauteur=59.4;
		$largeur=105;
		while( have_rows('fiche') ): the_row(); 
			$debut_row=(isset($fin_row))?$fin_row:intval(get_sub_field('debut'));
			$fin_row=$debut_row+intval(get_sub_field('duree'))+intval(get_sub_field('duree_animation'));
			?>
			<tr>
				<td><?php echo $debut_row; ?> '</td>
				<td><?php echo $duree=			get_sub_field('duree'); ?> '</td>
				<td><?php echo $duree_animation=get_sub_field('duree_animation'); ?> '</td>
				<td><?php echo $fin_row; ?> '</td>
				<td><?php echo $categorie=		get_sub_field('categorie'); ?></td>
				<td><?php echo $type=			get_sub_field('type'); ?></td>
				<td><?php $nb_joueurs=		get_sub_field('nb_joueurs'); 
							echo ($nb_joueurs>0)?$nb_joueurs:"illimité"; ?></td>
				<td><?php echo $nb_joueurs_scene=get_sub_field('nb_joueurs_scene'); ?></td>
				<td><?php echo $nb_public=		get_sub_field('nb_public'); ?></td>
				<td><?php echo $memento=		get_sub_field('memento'); ?></td>
			</tr>
			<?php
			$text_type=(isset($type) && strlen($type)>0)?" (".$type.")":"";
			$linktext="<p></p><h4>".$debut_row."' - ".$fin_row."' ".$categorie.$text_type."</h4>";
			$linktext.="<p>Durée : ".$duree." minutes<br>";
				$text_nbjoueurs=(isset($nb_joueurs) && strlen($nb_joueurs)>0)?"Nombre de joueurs : ".$nb_joueurs:"";
				$text_nbjoueurs_scene=(isset($nb_joueurs_scene) && $nb_joueurs_scene>0)?" (".$nb_joueurs_scene." sur scène)":"";
			$linktext.="".$text_nbjoueurs." ".$text_nbjoueurs_scene." <br>";
				$text_nbpublic=(isset($nb_public) && $nb_public>0)?$nb_public." public":"";
			$linktext.="".$text_nbpublic."</p>";
				$text_memento=(isset($memento) && strlen($memento)>0)?"NB : ".$memento:"";
			$linktext.="<p><i>".$text_memento."</i></p>";
			$posX=($nfiche%2==0)?0:$largeur;
			$posY+=($nfiche>0 && $nfiche%2==0)?$hauteur:0;
			
			if($nfiche%10==0) {
				$pdf->addPage();
				$posX=$posY=0;
			}
			$pdf->writeHTMLCell( $w=$largeur, $h=$hauteur, 	$x=$posX, $y=$posY, $html=$linktext, $border=1, $ln=0, $fill=false, $reseth=true, $align='C', $autopadding = true ); 
			//$pdf->MultiCell(80, 0, $right_column, 1, 'J', 1, 1, '', '', true, 0, false, true, 0);	
			$nfiche++;
		endwhile; 
		?>
		</tbody>
		<tfoot>
			<tr><td colspan="100"></td></tr>
		</tfoot>
	</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="button secondary " data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<!--button type="button" class="button bookmark" data-toggle="modal" data-target="#modalProgramme">
  Voir programme
</button-->
	<?php 
	global $post;
	$nom_dossier = "programme_".get_the_ID()."_".$post->post_name;
	$sortie=$_SERVER['DOCUMENT_ROOT']."wp-content/themes/".get_stylesheet()."/fiches_pdf/".$nom_dossier.".pdf";
	$url_sortie=get_stylesheet_directory_uri()."/fiches_pdf/".$nom_dossier.".pdf";
	$pdf->Output($sortie,'F');
	chmod ($sortie, 644);
endif;

if (strlen($url_sortie)>0) { ?>
<a href="<?php echo $url_sortie."?ver=".rand(0, 1000); ?>" class="button secondary" target="_blank">Télécharger les fiches</a>
<?php   
} ?>
