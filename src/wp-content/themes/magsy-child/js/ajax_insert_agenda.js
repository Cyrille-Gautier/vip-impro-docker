
jQuery(document).ready(function(){
    jQuery('.js-ajax-form').submit(function(e){
        e.preventDefault();
		var values = {};
		values['postid'] =          jQuery(this).find('input[name=postid]').val();
		values['idevenement'] =     jQuery(this).find('input[name=idevenement]').val();
		values['idcalendrier'] =    jQuery(this).find('input[name=idcalendrier]').val();
		values['agenda-date'] =     jQuery(this).find('input[name=agenda-date]').val();
		values['email'] =           jQuery(this).find('input[name=email]').val();
		values['participe'] =       jQuery(this).find('input[name=participe]').val();
		values['commentaire'] =     jQuery(this).find('input[name=commentaire]').val();
		console.log(jQuery(this), values);
		jQuery(this).addClass('loading');
        jQuery.ajax({
            url : ajaxurl,
            method : 'POST',
            data : {
                action : 'participation_insert',
				values : values,
				form : jQuery(this).attr('id'),
            },
            success : function( data ) {
				jQuery('#' + data.data.formid).removeClass('loading');
				// TODO : afficher flashbag success
                if ( data.success ) {
                    // TODO : mettre à jour
                    console.log( data.data );
                } else {
                    console.log( 'erreur', data.data );
                }
            },
            error : function( data ) {
                console.log(data.data.formid);
				jQuery('#' + data.data.formid).removeClass('loading');
				// TODO : afficher flashbag error
                console.log( 'Erreur…' );
            }
        });
	});
});