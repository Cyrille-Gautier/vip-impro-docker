jQuery(document).ready(function ($) {
    // événement clic sur bouton open-offcanvas
    jQuery(".open-offcanvas").on("click", function () {
        body.toggleClass("canvas-opened");
        body.addClass("canvas-visible");
        dimmer("open", "medium");

        // 1. masquer tous les contenus de la sidebar
        jQuery(".off-canvas .calendar-content").hide();


        // 3. ajouter le formulaire de participation
        var target_sidebar = jQuery(".off-canvas .calendar-content.calendar-content-"+jQuery(this).data("content-id"));
        var target_form = jQuery(this).data("participation-content");
        // TODO : remove formulaire précédent
        jQuery('#'+target_form).clone().show().appendTo(target_sidebar);


        // 2. TODO : ajouter la grille des participants
        var evenement_id = jQuery(this).data("evenement-id");
        var tableau_participants = target_sidebar.find('table#participants'+evenement_id+' .participants');
        var ligne_participants = tableau_participants.find('.participant.model');
        //each
        var preinscriptions = jQuery('input[name=pre-inscription').val();
        ligne_participants.clone().appendTo(tableau_participants).removeClass('model hide');
        ligne_participants.find('.nom').html(preinscriptions);
        ligne_participants.find('.participe').html(preinscriptions);
        ligne_participants.find('.commentaire').html(preinscriptions);

        // 4. afficher le contenu de la sidebar
        jQuery(".off-canvas .calendar-content.calendar-content-"+jQuery(this).data("content-id")).show();

        if(jQuery(this).hasClass('hide-mobile-menu'))
        {
            jQuery(".off-canvas .mobile-menu").hide();
            jQuery('canvas-close').on('click',function(){
                jQuery(".off-canvas .mobile-menu").show();
            });
        }
    });
    jQuery(".burger").on("click", function ()
    {
        jQuery(".off-canvas .mobile-menu").show();
        jQuery(".off-canvas .logo-wrapper").show();
        jQuery(".off-canvas .calendar-content").hide();
    });
    jQuery(".toggle-participation").on("click", function (e)
    {
        e.preventDefault();
        var participation_form = jQuery(this).attr("data-toggle-participation");
        jQuery(participation_form + " .show-on-toggle-participation").toggleClass('show');
    });
});
