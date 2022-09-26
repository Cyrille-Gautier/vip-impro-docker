<?php
$menu_class = 'mobile-menu';
if (magsy_compare_options(magsy_get_option('magsy_navbar_hidden', false), rwmb_meta('magsy_navbar_hidden')) == false) {
    $menu_class .= ' hidden-lg hidden-xl';
}
?>

<div class="off-canvas">
    <div class="canvas-close"><i class="mdi mdi-close"></i></div>
    <?php magsy_logo(); ?>
    <div class="<?php echo esc_attr($menu_class); ?>"></div>

    <div class="calendar-contents">
        <?php
        global $liste_calendar_contents;
        if (isset($liste_calendar_contents) && count($liste_calendar_contents) > 0) {
            foreach ($liste_calendar_contents as $datecalendarcontent => $calendarcontents) {
        ?>
                <div class="calendar-content calendar-content-<?php echo $datecalendarcontent; ?>" style="padding:0 15px;">
                    <?php foreach ($calendarcontents as $ncalendarcontent => $calendarcontent) { ?>
                        <h2><?php echo $calendarcontent['intitule']; ?></h2>
                        <h3>Animateur : <?php echo $calendarcontent['animateur']; ?></h3>
                        <?php echo $calendarcontent['description']; ?>
                    <?php } ?>
                </div>
        <?php }
        }
        function formulaireParticipation($nparticipation, $participation, $post)
        {
            global $agenda_roles, $liste_colonnes_agenda, $current_user;
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
        ?>
    </div>

    <aside class="widget-area">
        <?php dynamic_sidebar('off_canvas'); ?>
    </aside>
</div>