<?php

/**
 * @package wp-bootstrap
 */
//var_dump($_SESSION);
//delete_post_meta($post_id=get_the_ID(), $meta_key='agenda_resultat');
?>
<?php
//s:327:"s:318:"a:3:{i:0;a:3:{s:4:"name";s:7:"Cyrille";s:7:"id_post";s:4:"1560";s:5:"choix";a:3:{i:1;s:1:"1";i:2;s:1:"1";i:3;s:1:"1";}}i:1;a:3:{s:4:"name";s:8:"Emmanuel";s:7:"id_post";s:4:"1560";s:5:"choix";a:3:{i:1;N;i:2;N;i:3;s:1:"1";}}i:2;a:3:{s:4:"name";s:6:"Alexis";s:7:"id_post";s:4:"1560";s:5:"choix";a:3:{i:1;N;i:2;N;i:3;N;}}}";";
?>
<?php
global $liste_colonnes_agenda, $agenda_resultat, $agenda_roles, $current_user;
//echo "<pre>".print_r($liste_colonnes_agenda, true)."</pre>";
$participations = unserialize($agenda_resultat);
if (!isset($participations) || !is_array($participations)) $participations = array();
//echo "<h1>resultat</h1><pre>".print_r($agenda_resultat,true)."</pre>";
/****************************************************************/
/*	ENREGISTREMENT DES NOUVEAUX PARTICIPANTS					*/
/****************************************************************/
if (isset($_POST['action']) && ($_POST['action'] == "ajouter" || $_POST['action'] == "modifier" || $_POST['action'] == "supprimer")) {
	$agenda_update = $liste_colonnes_agenda[$_POST['id_meta']];
	$objetagenda = array(
		'name' => $_POST['name'],
		'id_post' => $_POST['id_post'],
		'id_user' => $_POST['id_user'],
		'choix' => array(),
		'roles' => array()
	);
	$message = "";
	$message2 = "Projet : " . get_the_title() . "<br/>";
	$message2 = "Nom : " . $_POST['name'] . "<br/>";
	if (is_array($liste_colonnes_agenda) && count($liste_colonnes_agenda) > 0) {
		foreach ($liste_colonnes_agenda as $idagenda => $agenda) {
			$objetagenda['choix'][$idagenda] = $_POST['choix' . $idagenda];
			$message2 .= "Choix " . $idagenda . " : " . $_POST['choix' . $idagenda] . "<br/>";
		}
	}
	$message2 .= "Rôles acceptés " . "<br/>";
	if (is_array($agenda_roles) && count($agenda_roles) > 0) {
		foreach ($agenda_roles as $role) {
			$objetagenda['roles'] = $_POST['role'];
		}
		if (isset($_POST['role'])) foreach ($_POST['role'] as $nrole => $role) $message2 .= $role . " OK" . "<br/>";
	}
	$message2 .= "<br/>" . "<br/>" . "Pour voir le projet : " . get_the_permalink();
	// modification
	if (isset($_POST['id_participation']) && strlen($_POST['id_participation']) > 0 && $_POST['action'] == "modifier") $participations[$_POST['id_participation']] = $objetagenda;
	else if (isset($_POST['id_participation']) && strlen($_POST['id_participation']) > 0 && $_POST['action'] == "supprimer") unset($participations[$_POST['id_participation']]);
	else $participations[] = $objetagenda;
	if (isset($participations) && is_array($participations)) {
		$message .= "<table width='100%'><thead>";
		$message .= "<tr>";
		$message .= "<th>Nom</th>";
		foreach ($liste_colonnes_agenda as $idagenda => $agenda) {
			$style = ($agenda['agenda_type'][1] == "Spectacle") ? "style='background:#eee;'" : "";
			$message .= "<th class='agenda' $style>" . $agenda['agenda_type'][1] . "<br/>" . substr($agenda['agenda_date'][1], 0, 5) . "<br/>" . $agenda['agenda_heure'][1] . "</th>";
		}
		if (isset($agenda_roles) && is_array($agenda_roles)) {
			foreach ($agenda_roles as $nrole => $role) {
				$message .= "<th>" . $role . "</th>";
			}
		}
		$message .= "</tr></thead><tbody>";

		foreach ($participations as $nparticipation => $participation) {
			$message .= "<tr>";
			if (isset($nparticipation)) {
				$message .= "<td>";
				$message .= (isset($participation['name']) && strlen($participation['name']) > 0) ? $participation['name'] : $current_user->display_name;
				$message .= "</td>";
				foreach ($liste_colonnes_agenda as $idagenda => $agenda) {
					$style = ($agenda['agenda_type'][1] == "Spectacle") ? "style='background:#eee;'" : "";
					$message .= "<td align='center' $style>";
					$message .= ($participation['choix'][$idagenda] == 1) ? "oui" : "";
					$message .= "</td>";
				}
				if (isset($agenda_roles) && is_array($agenda_roles)) {
					foreach ($agenda_roles as $role) {
						$message .= "<td align='center'>";
						$message .= (is_array($participation['roles']) && count($participation['roles']) > 0 && in_array($role, $participation['roles'])) ? "oui" : "";
						$message .= "</td>";
					}
				}
			}
			$message .= "</tr>";
		}
		$message .= "</tbody></table>";
	}
	$message .= "<br/><br/>" . $message2;
	//serialize();
	//echo "<pre>".print_r($participations[$_POST['id_participation']],true)."</pre>";
	//if ($_GET['demo']=='ok') echo "<pre>".print_r($objetagenda,true)."</pre>";
	if (!isset($agenda_resultat)) {
		$meta = add_post_meta($post_id = $_POST['id_post'], $meta_key = 'agenda_resultat', $meta_value = serialize($participations));
		$flashbag = array('status' => "success", 'text' => "Votre participation a bien été ajoutée.");
		if (!wp_mail(
			$to = array(get_the_author_meta('user_email'), "cyrillegautier@kommunikatsia.com"),
			$subject = "Agenda VIP : " . html_entity_decode(get_the_title()) . " : La participation de " . $_POST['name'] . " a été ajoutée.",
			$message,
			$headers = array('Content-Type: text/html; charset=UTF-8', "From: VIP <informations@vip-impro.fr>"),
			$attachments = NULL
		))
			$flashbag['text'] .= "ERREUR : L'auteur n'a pas été notifié.";
		//echo "<pre>add".$meta."</pre>";
	} else {
		$meta = update_post_meta($post_id = $_POST['id_post'], $meta_key = 'agenda_resultat', $meta_value = serialize($participations));
		$flashbag = array('status' => "success", 'text' => "Votre participation a bien été mise à jour.");
		if (!wp_mail(
			$to = array(get_the_author_meta('user_email'), "cyrillegautier@kommunikatsia.com"),
			$subject = "Agenda VIP : " . html_entity_decode(get_the_title()) . " : La participation de " . $_POST['name'] . " a été mise a jour.",
			$message,

			$headers = array('Content-Type: text/html; charset=UTF-8', "From: VIP <informations@vip-impro.fr>"),
			$attachments = NULL
		))
			$flashbag['text'] .= "ERREUR : L'auteur n'a pas été notifié.";
		//echo "<pre>update".$meta."</pre>";
	}
	if (isset($flashbag)) $_SESSION['flashbag'][] = $flashbag;
}

if (isset($_SESSION['flashbag'])) {
	foreach ($_SESSION['flashbag'] as $flashbag) {
		echo '<div class="col-md-12"><div class="alert alert-' . $flashbag['status'] . '">' . $flashbag['text'] . '</div></div>';
		unset($flashbag);
	}
	unset($_SESSION['flashbag']);
}
/****************************************************************/
/*	TABLEAU DES PARTICIPANTS									*/
/****************************************************************/
$liste_icones = array('Spectacle' => "mdi mdi-theater", 'Animation Stage' => "mdi mdi-school", 'Répétition' => "mdi mdi-account-multiple");
if (isset($liste_colonnes_agenda) && is_array($liste_colonnes_agenda) && count($liste_colonnes_agenda) > 0) {
?>
	<div class="clearfix"></div>
	<h2>Agenda</h2>
	<div class="table-responsive">
		<table class="table table-striped table-hover table-projet-agenda" width="100%">
			<thead>
				<tr>
					<th>Nom</th>
					<?php
					$liste_calendriers_a_afficher = array();
					foreach ($liste_colonnes_agenda as $idagenda => $agenda) {
						list($j, $m, $y) = explode('/', $agenda['agenda_date'][1]);
						$liste_calendriers_a_afficher[$y][$m][$j] = $agenda['agenda_type'][1];
						$icone = $liste_icones[$agenda['agenda_type'][1]];
						if (!isset($icone) || !strlen($icone) > 0) $icone = $agenda['agenda_type'][1];
						else $icone = "<i class='" . $icone . "' title='" . $agenda['agenda_type'][1] . "'></i>"; ?>
						<th title="<?php echo $idagenda; ?>" <?php if ($agenda['agenda_type'][1] == "Spectacle") echo 'class="info"'; ?>><?php echo $icone . "<br/>" . substr($agenda['agenda_date'][1], 0, 5) . "<br/>" . $agenda['agenda_heure'][1]; ?></th>
					<?php } ?>
					<?php
					if (isset($agenda_roles) && is_array($agenda_roles)) {
						foreach ($agenda_roles as $nrole => $role) { ?>
							<th><?php echo $role; ?></th>
					<?php }
					} ?>
					<th><i class="mdi mdi-check"></i></th>
				</tr>
			</thead>
			<tbody>
				<?php function formulaireParticipation($nparticipation, $participation, $post)
				{
					global $agenda_roles, $liste_colonnes_agenda, $current_user;
					//print_r($current_user);
				?>
					<tr <?php if (!isset($nparticipation)) echo 'class="info"'; ?>>
						<?php if (!isset($nparticipation)) {
							$participation['id_user'] = $current_user->ID; ?>
							<td colspan="1000">
								<h4><?php _e("Participerez-vous ?", 'wp-bootstrap'); ?></h4>
							</td>
					</tr>
					<tr class="info">
					<?php } ?>
					<?php if (isset($nparticipation)) {
						$togglefield = "show-on-toggle-participation"; ?>
						<td class="first"><a href="#" class="toggle-participation" data-toggle-participation="#p-<?php echo $post->ID; ?>-<?php echo $nparticipation; ?>"><i class="mdi mdi-pencil"></i></a><?php echo (isset($participation['name']) && strlen($participation['name']) > 0) ? $participation['name'] : $current_user->display_name; ?>
						</td>
						<?php foreach ($liste_colonnes_agenda as $idagenda => $agenda) { ?>
							<td align="center" <?php if ($agenda['agenda_type'][1] == "Spectacle") echo 'class="info"'; ?>><?php if ($participation['choix'][$idagenda] == 1) echo "<i class='mdi mdi-check'></i>"; ?></td>
						<?php } ?>
						<?php
						if (isset($agenda_roles) && is_array($agenda_roles)) {
							foreach ($agenda_roles as $role) { ?>
								<td align="center"><?php if (is_array($participation['roles']) && count($participation['roles']) > 0 && in_array($role, $participation['roles'])) echo "<i class='mdi mdi-check'></i>"; ?></td>
							<?php } ?>
						<?php
						}
						if (isset($nparticipation) && strlen($nparticipation) > 0 && current_user_can('manage_options')) { ?>
							<td>
								<form action="" method="post" name="form-suppr-<?php echo $post->ID; ?>" id="form-suppr-<?php echo $post->ID; ?>" class="form-group">
									<input type="hidden" name="action" value="supprimer" />
									<input type="hidden" name="id_post" value="<?php echo $post->ID; ?>" />
									<input type="hidden" name="id_participation" value="<?php echo $nparticipation; ?>" />
									<button type="submit" name="submit" class="delete" onclick="if(!window.confirm('Supprimer la participation ?')) return false;"><i class="mdi mdi-delete"></i></button>
								</form>
							</td>
					<?php }
					} ?>
					</tr>
					<tr id="p-<?php echo $post->ID; ?>-<?php echo $nparticipation; ?>" class="info">
						<form action="" method="post" name="form-<?php echo $post->ID; ?>" id="form-<?php echo $post->ID; ?>" class="form-group ">
							<input type="hidden" name="action" value="<?php if (isset($nparticipation) && strlen($nparticipation) > 0) echo 'modifier';
																		else echo 'ajouter'; ?>" />
							<input type="hidden" name="id_post" value="<?php echo $post->ID; ?>" />
							<input type="hidden" name="id_participation" value="<?php echo $nparticipation; ?>" />
							<td class="first">
								<?php if (current_user_can('manage_options')) { ?>
									<select name="id_user" class="<?php echo $togglefield; ?>">
										<?php $users = get_users('orderby=nicename');
										foreach ($users as $user) { ?>
											<option value="<?php echo $user->ID; ?>" <?php echo (isset($participation['id_user']) && $participation['id_user'] == $user->ID) ? ' selected="selected"' : ''; ?>><?php echo $user->display_name; ?></option>
										<?php } ?>
									</select>
									<input type="text" value="<?php echo (isset($participation['name']) && strlen($participation['name']) > 0) ? $participation['name'] : $current_user->display_name; ?>" name="name" class="form-control <?php echo $togglefield; ?>" placeholder="Votre nom" />
								<?php } else { ?>
									<input type="hidden" name="id_user" value="<?php echo (isset($participation['id_user']) && strlen($participation['id_user']) > 0) ? $participation['id_user'] : $current_user->ID; ?>" />
									<input type="text" value="<?php echo (isset($participation['name']) && strlen($participation['name']) > 0) ? $participation['name'] : $current_user->display_name; ?>" name="name" class="form-control <?php echo $togglefield; ?>" placeholder="Votre nom" />
								<?php } ?></td>
							<?php foreach ($liste_colonnes_agenda as $idagenda => $agenda) { ?>
								<td align="center" <?php if ($agenda['agenda_type'][1] == "Spectacle") echo 'class="info"'; ?>><input type="checkbox" name="choix<?php echo $idagenda; ?>" value="1" <?php if ($participation['choix'][$idagenda] == 1) echo "checked" ?> class="<?php echo $togglefield; ?>" /></td>
							<?php } ?>
							<?php
							if (isset($agenda_roles) && is_array($agenda_roles)) {
								foreach ($agenda_roles as $role) { ?>
									<td align="center"><input type="checkbox" name="role[]" value="<?php echo $role; ?>" <?php if (is_array($participation['roles']) && count($participation['roles']) > 0 && in_array($role, $participation['roles'])) echo "checked" ?> class="<?php echo $togglefield; ?>" title="<?php echo $role; ?>" /></td>
							<?php }
							} ?>
							<td colspan="20"><button type="submit" name="submit" class="button <?php if (isset($nparticipation) && strlen($nparticipation) > 0) echo 'secondary';
																								else echo ''; ?> <?php echo $togglefield; ?>"><i class="mdi <?php if (isset($nparticipation) && strlen($nparticipation) > 0) echo 'mdi-check';
																																																											else echo 'mdi-send'; ?>"></i> <?php if (isset($nparticipation) && strlen($nparticipation) > 0) echo 'Modifier';
																																																																																							else echo 'Envoyer'; ?></button>
							</td>
						</form>
					</tr>
				<?php } ?>

				<?php
				$dejaparticipe = false;
				//if ($_GET['demo']=='ok') echo "<pre>".print_r($participations,true)."</pre>";
				if (isset($participations) && is_array($participations)) {
					foreach ($participations as $nparticipation => $participation) {
						formulaireParticipation($nparticipation, $participation, $post);
						if ($current_user->ID == $participation['id_user']) $dejaparticipe = true;
						//echo $current_user->ID."==". $participation['id_user'] ;
					}
				}
				if ($dejaparticipe == false || current_user_can('manage_options')) formulaireParticipation(NULL, NULL, $post);
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="100"></td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="calendar">
		<?php
		$y_displayed = 0;
		$m_displayed = 0;
		foreach ($liste_calendriers_a_afficher as $y => $ydata) {
			foreach ($ydata as $m => $mdata) {
				if ($y !== $y_displayed) {
					$y_displayed = $y;
				}
				if ($m !== $m_displayed) {
					$m_displayed = $m;
					echo do_shortcode('[calendrier class="" cal_month="' . $m . '" cal_year="' . $y . '" with_spectacles="true" with_agendas="true"]');
				}
			}
		}
		?>
	</div>
<?php
}
?>