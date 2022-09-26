<?php
function magsy_child_scripts()
{
    wp_enqueue_style( 'magsy-style', get_template_directory_uri() . '/style.css', array(), MAGSY_VERSION );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'magsy-style' ), MAGSY_VERSION );
    wp_enqueue_script( 'child-script', get_stylesheet_directory_uri() . '/js/magsy-child.js', array( 'jquery' ) );
    // les action ajax sont dans le scripts.js
    wp_enqueue_script( 'ajax_insert_agenda', get_stylesheet_directory_uri() . '/js/ajax_insert_agenda.js', array('jquery') );
    wp_localize_script( 'ajax_insert_agenda', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}
add_action( 'wp_enqueue_scripts', 'magsy_child_scripts' );


function magsy_child_widgets_init()
{
    register_sidebar( array(
        'name' => esc_html__( 'Modular Page 2', 'magsy' ),
        'id' => 'modules2',
        'description' => esc_html__( 'Add modules here.', 'magsy' ),
        'before_widget' => '<div id="%1$s" class="section %2$s"><div class="container">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3 class="section-title"><span>',
        'after_title' => '</span></h3>',
    ) );
}
add_action( 'widgets_init', 'magsy_child_widgets_init' );
/* Theme customization starts here */
/*****************************************************
**	01.	Use antispambot as shortcode				**
**	02.	Date personalisée							**
**	03.	Ajouter lien vers redirections mail			**
**	04.	Espace réservé								**
**	05. Calendrier									**
**	06. Participation								**
**	07. Date personnalisée							**
**	08.	Add open graph to header					**
**													**
**	51.	Admin : login page							**
**	52.	Admin : colonnes projets & spectacles		**
**	53.	Admin : colonne Featured image 				**
**	54.	Contenu par défaut pour les Projets			**
/*****************************************************
**	01.	Use antispambot as shortcode			**
**			[email texte="cliquez ici" claas="btn btn-link" sujet="Demande de devis"]info@me.fr[/email]			**
*****************************************************/
function wpcodex_hide_email_shortcode( $atts , $content = null ) {
    $atts = shortcode_atts( array(
        'texte' 	=> '',
        'class' 	=> '',
        'sujet' 	=> ''
    ), $atts );
    if ( ! is_email( $content ) ) {
        return;
    }

    $maillink = '<a href="mailto:' . antispambot( $content );
        if( isset($atts['sujet']) && strlen($atts['sujet'])>0 ) $maillink.= '?subject='.rawurlencode($atts['sujet']);
    $maillink .=  '" class="'.$atts['class'].'" rel="nofollow">';
        if( isset($atts['texte']) && strlen($atts['texte'])>0 ) $maillink.= $atts['texte'];
        else $maillink .= antispambot( $content );
    $maillink .= '</a>';
    return $maillink;
}
add_shortcode( 'email', 'wpcodex_hide_email_shortcode' );
/************************************************/
/*	02. Date personnalisée						*/
/*	Choisir parmi liste de dates laquelle		*/
/*	afficher 									*/
/************************************************/

if (!function_exists('vip_date')) {
    function vip_date( $dates, $style_date="passe", $return_array=false) {

        $prochaine_date="0000-00-00";
        $derniere_date="0000-00-00";
        /*	Parcourir les dates							*/
        if (is_array($dates)) {
            foreach($dates as $ndate=>$date) {
                if ( $date>=date("Y-m-d") && ( $prochaine_date=="0000-00-00" || $prochaine_date > $date) ) $prochaine_date=$date;
                if ( $date<=date("Y-m-d") && ( $derniere_date=="0000-00-00" || $derniere_date < $date) ) $derniere_date=$date;
                //print_r($dates);
            }
        } else {
            $date=$dates;
            if ( $date>=date("Y-m-d") && ( $prochaine_date=="0000-00-00" || $prochaine_date > $date) ) $prochaine_date=$date;
            if ( $date<=date("Y-m-d") && ( $derniere_date=="0000-00-00" || $derniere_date < $date) ) $derniere_date=$date;
        }
        date_default_timezone_set('Europe/Paris');
        setlocale(LC_TIME, 'fr_FR.utf8','fra');// OK
        //echo "Date du jour : ", strftime("%A %d %B %Y");

        /*	Cas n°1 : pas de date à venir, on affiche la dernière	*/
        if ($prochaine_date=="0000-00-00") {
            $date_affichee_complete = new DateTime($derniere_date);
            $date_affichee = strtotime($derniere_date);
        /*	Cas n°2 : on affiche la date à venir					*/
        } else {
            $date_affichee_complete = new DateTime($prochaine_date);
            $date_affichee = strtotime($prochaine_date);
        }

        $tooltip = $date_affichee_complete->format('Y-m-dTH:i:sO');
        $day_of_week = strftime("%a",$date_affichee);// $time->format('D');
        $date_day = strftime("%d",$date_affichee); //$time->format('d');
        $date_month =  strftime("%b",$date_affichee); //$time->format('M');
        $date_monthnb =  $date_affichee_complete->format('m'); //$time->format('m');
        $date_year = strftime("%Y",$date_affichee); //$time->format('Y');
        $style_date = ($prochaine_date=="0000-00-00")?"passe":"a_venir";
        ob_start();	?>
        <div class="post-date time spectacle <?php echo $style_date; ?>">
            <span class="entry-date">
                <abbr class="published" title="<?php echo $tooltip; ?>">
                    <span class="post_date post_date_day_of_week"><?php echo $day_of_week; ?></span>
                    <span class="post_date post_date_day"><?php echo $date_day; ?></span>
                    <span class="post_date post_date_month"><?php echo $date_month; ?></span>
                    <span class="post_date post_date_year"><?php echo $date_year; ?></span>
                </abbr>
            </span>
        </div><!-- .entry-meta -->
        <?php
        $txtdate=ob_get_contents();
        ob_end_clean();
        if ($return_array==false ) return $txtdate;
        else if ($return_array==true ) return array($day_of_week,$date_day,$date_monthnb,$date_year);
    }
}
/****************************************************************/
/*	03.	Ajouter lien vers redirections mail						*/
/****************************************************************/
function antigone_admin_link_mailalias($wp_admin_bar) {
    if( current_user_can('edit_others_pages') ) {
        global $wp_admin_bar;
        $args = array(
            'id' => 'outils',
            'title' => '<span class="ab-icon dashicons-before dashicons-admin-generic"></span> Outils (BETA)',
            'href' => home_url('/redirections')
        );
        $wp_admin_bar->add_node($args);
        // add a child item to our parent item
        $args = array(
            'parent' => 'outils',
            'id'     => 'redirections',
            'title'  => 'Redirections',
            'href'   =>  home_url('/redirections'),
            'meta'   => false
        );
        $wp_admin_bar->add_node( $args );
    }
}
add_action('admin_bar_menu', 'antigone_admin_link_mailalias', 999);

add_action('admin_menu', 'antigone_admin_link_mailalias2');
function antigone_admin_link_mailalias2() {
    global $submenu;
    $url = home_url('/redirections/');
    $submenu['tools'][] = array('<i class="dashicons-before dashicons-cog"></i> Redirections', 'manage_options', $url);
}
// TODO : migrer vers API OVH v6 https://api.ovh.com/console/#/email/domain/%7Bdomain%7D/redirection#POST
/*
Your script credentials:
Script Name
emailredirectionlist
Script Description
action redirection email
Application Key
F1yYe0loEkqn2uI0
Application Secret
iqflFo0yiMDxAyiSelO4b8h93aw74PaM
Consumer Key
4vcfHSrBHkLDJOibMHedJR8c1NSbssbH
*/
function redirectionAdd($domain="www.vip-impro.fr", $prefix="cyr", $target="cyrillegautier@kommunikatsia.com", $subdomain="", $copy=false) {
    if (isset($_SESSION)) $_SESSION['flashbags']['redirections']=array();
    if( current_user_can('edit_others_pages') ) {
        try {
         $soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.63.wsdl");

         //login
         $session = $soap->login("gc100954-ovh", "Sky$3lf2009","fr", false);
         //echo "login successfull\n";

         //redirectedEmailAdd
         $soap->redirectedEmailAdd($session, $domain, $prefix, $target, $subdomain, $copy);
         $_SESSION['flashbags']['redirections'][]=array('class'=>'alert-success', 'message'=> "redirectedEmailAdd successfull\n");

         //logout
         $soap->logout($session);
         //echo "logout successfull\n";

        } catch(SoapFault $fault) {
         $_SESSION['flashbags']['redirections'][]=array('class'=>'alert-warning', 'message'=> '<strong>Erreur!</strong> '.$fault);
        }
    }
}
function redirectionDelete($domain= "www.vip-impro.fr", $prefix=NULL, $target=NULL, $subdomain=""){
    if (isset($_SESSION)) $_SESSION['flashbags']['redirections']=array();
    if( current_user_can('edit_others_pages') ) {
        try {
         $soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.63.wsdl");

         //login
         $session = $soap->login("gc100954-ovh", "Sky$3lf2009","fr", false);
         //echo "login successfull\n ";

         //redirectedEmailDel
         $soap->redirectedEmailDel($session, $domain, $prefix, $target, $subdomain);
         $_SESSION['flashbag']['redirections'][]=array('class'=>'alert-success', 'message'=>  "redirectedEmailDel successfull\n");

         //logout
         $soap->logout($session);
         //echo "logout successfull\n";

        } catch(SoapFault $fault) {
         $_SESSION['flashbag']['redirections'][]=array('class'=>'alert-warning', 'message'=> "<strong>Erreur!</strong> ".$fault);
        }

    } else {
         $_SESSION['flashbag']['redirections'][]=array('class'=>'alert-warning', 'message'=> "<strong>Erreur!</strong> Vous n'êtes pas autorisés.");
    }
    return $_SESSION['flashbag']['redirections'];
}
function redirectionEdit($domain= "www.vip-impro.fr", $prefix=NULL, $oldtarget=NULL, $newtarget=NULL, $subdomain=""){
    if (isset($_SESSION)) $_SESSION['flashbags']['redirections']=array();
    if( current_user_can('edit_others_pages') ) {
        try {
         $soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.63.wsdl");
         //login
         $session = $soap->login("gc100954-ovh", "Sky$3lf2009","fr", false);
         //$_SESSION['flashbag']['redirections'].= "login successfull\n";

         //redirectedEmailModify
         $soap->redirectedEmailModify($session, $domain, $prefix, $oldtarget, $newtarget, $subdomain);
         $_SESSION['flashbags']['redirections'][]=array('class'=>'alert-success', 'message'=> "redirectedEmailModify successfull\n");

         //logout
         $soap->logout($session);
         //$_SESSION['flashbag']['redirections'].= "logout successfull\n";

        } catch(SoapFault $fault) {
         $_SESSION['flashbag']['redirections'][]=array('class'=>'alert-warning', 'message'=> '<strong>Erreur!</strong> '.$fault);
        }
    } else {
         $_SESSION['flashbag']['redirections'][]=array('class'=>'alert-warning', 'message'=> "<strong>Erreur!</strong> Vous n'êtes pas autorisés.");
    }
    return $_SESSION['flashbag']['redirections'];
}
add_shortcode('liste_redirections', 'redirectionListing');
function redirectionListing($atts){
    if (isset($_SESSION)) $_SESSION['flashbags']['redirections']=array();

    if( current_user_can('edit_others_pages') ) {
        if(isset($_POST['action']) && ( $_POST['action']=="ajouter" || $_POST['action']=="modifier" ) ) {
            $_SESSION['redirections']['selected']=$_POST['local'];
            if($_POST['action']=="modifier"){
            $flashbag = redirectionEdit($domain= "www.vip-impro.fr", $prefix=$_POST['local'], $oldtarget=$_POST['oldtarget'], $newtarget=$_POST['target'], $subdomain="");
            } else if($_POST['action']=="ajouter"){
            $flashbag = redirectionAdd($domain="www.vip-impro.fr", $prefix=$_POST['local'], $target=$_POST['target'], $subdomain="", $copy=false);
            }
        } else if(isset($_POST['action']) && $_POST['action']=="supprimer") {
            $_SESSION['redirections']['selected']=$_POST['local'];
            $flashbag = redirectionDelete($domain= "www.vip-impro.fr", $prefix=$_POST['local'], $target=$_POST['target'], $subdomain="");
        }
        $atts = shortcode_atts( array( 'domain'	=> 'www.vip-impro.fr' ), $atts );
        $return="";
        try {
         $soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.63.wsdl");

         //login
         $session = $soap->login("gc100954-ovh", "Sky$3lf2009","fr", false);
         //$return .=  "login successfull : $domain\n";

         //redirectedEmailList
         $results = $soap->redirectedEmailList($session, $atts['domain']);
         //$return .=  "redirectedEmailList successfull\n";
         /*$result=array(
            0 => stdClass Object(
                    [target] => cecile.vivant@laposte.net
                    [local] => informations
                    [subdomain] =>
                    [dnsRedirection] => 1
                )*/
         $return .=  "<pre>".print_r($results,true)."</pre>"; // your code here ...
         $liste_redirections=array();
         foreach ($results as $nresult=>$redirection) {
             $liste_redirections[$redirection->local][$nresult]=$redirection;
         }
        ob_start();
        include(locate_template('content-redirections.php'));
        $return.=ob_get_contents();
        ob_end_clean();

         //logout
         $soap->logout($session);
         //$return .=  "logout successfull\n";

        } catch(SoapFault $fault) {
         $return .=  $_SESSION['flashbag']['redirections'][]=array('class'=>'alert-warning', 'message'=> '<strong>Erreur!</strong> '.$fault);
        }
    } else {
         $_SESSION['flashbag']['redirections'][]=array('class'=>'alert-warning', 'message'=> "<strong>Erreur!</strong> Vous n'êtes pas autorisés.");
    }
    return $return;
}
/****************************************************************/
/*	04.	Espace réservé											*/
/****************************************************************/

//interdire l'accès aux non admins
add_action( 'current_screen', 'redirect_non_authorized_user' );
function redirect_non_authorized_user() {
    // Si t'es pas admin, tu vires
    if ( is_user_logged_in() && ! current_user_can( 'edit_posts' ) ) {
        wp_redirect( home_url( '/' ) );
        exit();
    }
}

// Proposer un contenu uniques aux utilisateurs autorisés
// shortcode [private-content]
// Limité : ne masque que le contenu texte, pas adapté aux Custom Post Types
add_shortcode( 'private-content', 'private_content' );
function private_content( $atts, $content ) {
    if ( is_user_logged_in() ) {
        return do_shortcode($content);
    } else {
        // Affiche un lien vers la page login de WordPress,
        // puis redirige ensuite automatiquement vers la page précédente
        return '<h2>Contenu Confidentiel</h2><p><a href="' . wp_login_url( get_permalink() ) . '" class="button secondary">Connectez-vous pour lire ce contenu</a></p>';
        //wp_redirect( wp_login_url(get_permalink()) );
    //wp_redirect( home_url( '/login/' ) );
    }
}

// Vérouiller l'accès à une catégorie
// catégorie Projets : 2
add_action( 'template_redirect', 'private_page' );
function private_page() {
    $liste_categories_privees=array( 2=>'projets', 8=>'exercices' );
    //--------------------------------------------
    //--	VERROUILLER PAGES CATEGORIES		--
    //--------------------------------------------
    if(is_category()) {
        if (
            ( is_category(8) || is_category(2) )
            && ( !is_user_logged_in() || ( isset($current_user) && $current_user->roles[0] != 'adherent' ) )
            ) {
            if ( is_category(2) ) wp_redirect( wp_login_url(get_category_link( 2 )) );
            else wp_redirect( wp_login_url(get_category_link( 8 )) );
            // redirection : wp_redirect( wp_login_url( get_permalink(5) ) );
            exit();
        }
    } else if (is_single()) {
        if ( ( in_category(8) || in_category(2) ) && ! is_user_logged_in() && $current_user->roles[0] != 'adherent') {
            wp_redirect( wp_login_url(get_category_link( 2 )) );
            // redirection : wp_redirect( wp_login_url( get_permalink(5) ) );
            exit();
        }
    }
}

// Ajouter un rôle pour les Adhérents
add_role('adherent', 'Adherent', array(
    'read' => true, // true : aurtorise la lecture des page et article
    'edit_posts' => false, // false : Interdit d'ajouter des articles ou des pages
    'delete_posts' => false, // false : Interdit de supprimer des articles ou des pages
));

// Limiter la barre d'admin aux utilisateurs Editeur, Auteur et Admin
if (!current_user_can('edit_posts')) {
    add_filter('show_admin_bar', '__return_false');
}


/************************************************/
/*	05. Calendrier								*/
/************************************************/

function calendrier_shortcode( $atts, $content = "" ) {
    $atts = shortcode_atts( array(
        'cal_year' => NULL,
        'cal_month' => NULL,
        'with_agendas' => true,
        'class' => NULL
    ), $atts, 'calendrier' );
    include_once WP_PLUGIN_DIR.'/calendrier/calendar.php';
    $calendar = new Calendar();
    return $calendar->show( $atts['cal_year'], $atts['cal_month'], $atts['with_agendas'], $atts['class'] );
}

add_shortcode( 'calendrier', 'calendrier_shortcode' );


/************************************************/
/*	06. Participation							*/
/************************************************/


// préfixe : wp_ajax puis nom de la fonction ajax : participation_insert
add_action( 'wp_ajax_participation_insert', 'participation_insert' );
add_action( 'wp_ajax_nopriv_participation_insert', 'participation_insert' );
function participation_insert() {
    include_once WP_PLUGIN_DIR.'/participation/participation.php';
    $participation = new Participation();
    try {
        $participations_existantes = $participation->getParticipations(
            $idcalendrier = $_POST['values']['idcalendrier'],
            $idevenement = $_POST['values']['idevenement'],
            $post_ID = 146
        );
    } catch (Exception $e) {
        $erreur = 'Exception reçue : '.  $e->getMessage(). "\n";
    }
    // on prépare la participation
    if (isset($participations_existantes) && is_array($participations_existantes)) {
        $participations = $participations_existantes;
    } else {
        $participations = [];
    }
    $participation = [
        'agenda-date'   => $_POST['values']['agenda-date'],
        'idevenement'   => $_POST['values']['idevenement'],
        'idcalendrier'  => $_POST['values']['idcalendrier'],
        'email'         => $_POST['values']['email'],
        'participe'     => $_POST['values']['participe'],
        'commentaire'   => $_POST['values']['commentaire'],
    ];
    $participations[] = $participation;
    // TODO ajouter $participations_existantes
    $participations_serialized = serialize($participations);
    $result_update = update_sub_field(
        array(
            $repeater =     'calendrier',
            $nrepeater =    $_POST['values']['idcalendrier'],
            $subrepeater =  'evenement',
            $nsubrepeater = $_POST['values']['idevenement'],
            $subfield =     'pre-inscription'
        ),
        $value =            $participations_serialized,
        $postid =           $_POST['values']['postid']
    );

    if ( $result_update ) {
        $retour_json = [
            'action'=>                      'calendrier update',
            'idevenement'=>                 $_POST['values']['idevenement'],
            'postid'=>                      $_POST['values']['postid'],
            'participations' =>             $participations,
            'participations_existantes' =>  $participations_existantes,
            'erreur' =>                     $erreur,
            'formid' =>                     $_POST['form'],
        ];
        wp_send_json_success( $retour_json );
    } else {
        $retour_json = [
            'error' =>                      $result_update,
            'action'=>                      'calendrier update',
            'idevenement'=>                 $_POST['values']['idevenement'],
            'postid'=>                      $_POST['values']['postid'],
            'participations' =>             $participations,
            'participations_existantes' =>  $participations_existantes,
            'erreur' =>                     $erreur,
            'formid' =>                     $_POST['form'],
        ];
        wp_send_json_error( $retour_json );
    }
}

/************************************************/
/*	06. Date personnalisée						*/
/************************************************/

if (!function_exists('vip_date')) {
    function vip_date( $dates, $style_date="passe", $return_array=false) {

        $prochaine_date="0000-00-00";
        $derniere_date="0000-00-00";
        /*	Parcourir les dates							*/
        if (is_array($dates)) {
            foreach($dates as $ndate=>$date) {
                if ( $date>=date("Y-m-d") && ( $prochaine_date=="0000-00-00" || $prochaine_date > $date) ) $prochaine_date=$date;
                if ( $date<=date("Y-m-d") && ( $derniere_date=="0000-00-00" || $derniere_date < $date) ) $derniere_date=$date;
                //print_r($dates);
            }
        } else {
            $date=$dates;
            if ( $date>=date("Y-m-d") && ( $prochaine_date=="0000-00-00" || $prochaine_date > $date) ) $prochaine_date=$date;
            if ( $date<=date("Y-m-d") && ( $derniere_date=="0000-00-00" || $derniere_date < $date) ) $derniere_date=$date;
        }
        date_default_timezone_set('Europe/Paris');
        setlocale(LC_TIME, 'fr_FR.utf8','fra');// OK
        //echo "Date du jour : ", strftime("%A %d %B %Y");

        /*	Cas n°1 : pas de date à venir, on affiche la dernière	*/
        if ($prochaine_date=="0000-00-00") {
            $date_affichee_complete = new DateTime($derniere_date);
            $date_affichee = strtotime($derniere_date);
        /*	Cas n°2 : on affiche la date à venir					*/
        } else {
            $date_affichee_complete = new DateTime($prochaine_date);
            $date_affichee = strtotime($prochaine_date);
        }

        $tooltip = $date_affichee_complete->format('Y-m-dTH:i:sO');
        $day_of_week = strftime("%a",$date_affichee);// $time->format('D');
        $date_day = strftime("%d",$date_affichee); //$time->format('d');
        $date_month =  strftime("%b",$date_affichee); //$time->format('M');
        $date_monthnb =  $date_affichee_complete->format('m'); //$time->format('m');
        $date_year = strftime("%Y",$date_affichee); //$time->format('Y');
        $style_date = ($prochaine_date=="0000-00-00")?"passe":"a_venir";
        ob_start();	?>
        <div class="post-date time spectacle <?php echo $style_date; ?>">
            <span class="entry-date">
                <abbr class="published" title="<?php echo $tooltip; ?>">
                    <span class="post_date post_date_day_of_week"><?php echo $day_of_week; ?></span>
                    <span class="post_date post_date_day"><?php echo $date_day; ?></span>
                    <span class="post_date post_date_month"><?php echo $date_month; ?></span>
                    <span class="post_date post_date_year"><?php echo $date_year; ?></span>
                </abbr>
            </span>
        </div><!-- .entry-meta -->
        <?php
        $txtdate=ob_get_contents();
        ob_end_clean();
        if ($return_array==false ) return $txtdate;
        else if ($return_array==true ) return array($day_of_week,$date_day,$date_monthnb,$date_year);
    }
}
if ( !function_exists('strip_shortcode_gallery') ) {
    function strip_shortcode_gallery( $content, $enable_button=false, $id=NULL ) {
        preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER );
        $ngalleries=0;
        if ( ! empty( $matches ) ) {
            foreach ( $matches as $shortcode ) {
                if ( 'gallery' === $shortcode[2] ) {
                    $pos = strpos( $content, $shortcode[0] );
                    if( false !== $pos ) {
                        $ngalleries++;
                        $content = substr_replace( $content, '', $pos, strlen( $shortcode[0] ) );
                    }
                }
            }
        }
        if( isset($enable_button) && $enable_button==true && $ngalleries>0 ) {
            $content.='<a class="button secondary" href="'.get_permalink($id).'" target="_blank" rel="noopener">Voir la galerie</a>';
        }

        return $content;
    }
}
/*****************************************************
**	07.	Add open graph to header					**
*****************************************************/
function add_opengraph_doctype($output)
{
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}

add_filter('language_attributes', 'add_opengraph_doctype');

//add Open Graph Meta Info
function insert_fb_in_head()
{
    global $post;
    if (!is_singular()) //if it is not a post or a page
        return;

    if ($excerpt = $post->post_excerpt)
    {
        $excerpt = strip_tags($post->post_excerpt);
    }
    else
    {
        $excerpt = get_bloginfo('description');
    }

    //echo '<meta property="fb:app_id" content="YOUR APPID"/>'; //<-- this is optional
    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
    echo '<meta property="og:description" content="' . $excerpt . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    echo '<meta property="og:site_name" content="' . get_bloginfo() . '"/>';

    echo '<meta name="twitter:title" content="' . get_the_title() . '"/>';
    echo '<meta name="twitter:card" content="summary" />';
    echo '<meta name="twitter:description" content="' . $excerpt . '" />';
    echo '<meta name="twitter:url" content="' . get_permalink() . '"/>';
    $attr_small=NULL;
    $urlimage=get_image($fieldName='details_affiche',$groupid=1,$fieldid=1,$tag=0,$postid=$post->ID,$attr_small);
    if (strlen($urlimage)>0)
    {
        echo '<meta property="og:image" content="' . $urlimage . '"/>';
        echo '<meta name="twitter:image" content="' . $urlimage . '"/>';
    }
    else if (!has_post_thumbnail($post->ID))
    {
        //the post does not have featured image, use a default image
        $default_image = get_bloginfo('stylesheet_directory') . '/images/logovip.png'; //<--replace this with a default image on your server or an image in your media library
        echo '<meta property="og:image" content="' . $default_image . '"/>';
        echo '<meta name="twitter:image" content="' . $default_image . '"/>';
    }
    else
    {
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
        echo '<meta property="og:image" content="' . esc_attr($thumbnail_src[0]) . '"/>';
        echo '<meta name="twitter:image" content="' . esc_attr($thumbnail_src[0]) . '"/>';
    }
}

add_action('wp_head', 'insert_fb_in_head', 5);



/****************************************************************/
/*	51.	Admin : login page										*/
/****************************************************************/
// logo personnalise
function childtheme_custom_login() {
 echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/style-login.css" />';
}

add_action('login_head', 'childtheme_custom_login');
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
/*****************************************************
**	52.	Admin : colonnes projets & spectacles		**
*****************************************************/

function custom_manage_spectacle_posts_columns($columns) {
    $position=2;
    $columns_avant = array_slice($columns, 0, $position);
    $columns_apres = array_slice($columns, $position);
    return array_merge(
        $columns_avant,
        array('details_affiche' => __('Image','wp-bootstrap')),
        array('details_date_de_representation' => __('Représentation','wp-bootstrap')) ,
        $columns_apres
    );
}
add_filter('manage_spectacle_posts_columns' , 'custom_manage_spectacle_posts_columns');

// Affichage des données

add_action('manage_spectacle_posts_custom_column', 'colonnes_spectacles_vip');
function colonnes_spectacles_vip($column) {
    global $post;
    switch ($column) {
        case 'details_date_de_representation':
            $date = get_post_meta($post->ID, 'details_date_de_representation', false);
            echo $date[0];
            break;
        case 'details_affiche':
            $image = get_post_meta($post->ID, 'details_affiche', false);
            if (strlen($image[0])>0) echo '<img src="/wp-content/files_mf/'.$image[0].'" height="100px"/>';
            break;
    }
}

// Tri de la colonne de données

function spectacles_column_register_sortable( $columns )
{
    $columns['details_date_de_representation'] = 'details_date_de_representation';
    return $columns;
}

add_filter("manage_edit-spectacle_sortable_columns", "spectacles_column_register_sortable" );

function details_date_de_representation_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'details_date_de_representation' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'details_date_de_representation',
            'orderby' => 'meta_value'
        ) );
    }
    return $vars;
}
add_filter( 'request', 'details_date_de_representation_column_orderby' );

function custom_manage_projet_posts_columns($columns) {
    $position=2;
    $columns_avant = array_slice($columns, 0, $position);
    $columns_apres = array_slice($columns, $position);
    return array_merge(
        $columns_avant,
        array('details_referent' => __('Référent','wp-bootstrap')),
        array('details_date_finale' => __('Représentation','wp-bootstrap')) ,
        $columns_apres
    );
}
add_filter('manage_projet_posts_columns' , 'custom_manage_projet_posts_columns');

// Affichage des données

add_action('manage_projet_posts_custom_column', 'colonnes_projets_vip');
function colonnes_projets_vip($column) {
    global $post;
    switch ($column) {
        case 'details_date_finale':
            $date = get_post_meta($post->ID, 'details_date_finale', false);
            echo $date[0];
            break;
        case 'details_referent':
            $referent = get_post_meta($post->ID, 'details_referent', false);
            echo $referent[0];
            break;
    }
}

// Tri de la colonne de données

function projets_column_register_sortable( $columns )
{
    $columns['details_date_finale'] = 'details_date_finale';
    $columns['details_referent'] = 'details_referent';
    return $columns;
}

add_filter("manage_edit-projet_sortable_columns", "projets_column_register_sortable" );

function details_projets_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'details_date_finale' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'details_date_finale',
            'orderby' => 'meta_value'
        ) );
    } else if ( isset( $vars['orderby'] ) && 'details_referent' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'details_referent',
            'orderby' => 'meta_value'
        ) );
    }
    return $vars;
}
add_filter( 'request', 'details_projets_column_orderby' );

/*************************************************************
**	53.	Admin : colonne Featured image 						**
*************************************************************/
// GET FEATURED IMAGE
function vip_get_featured_image($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'thumbnail');
        return $post_thumbnail_img[0]; //$post_ID.' '.print_r($post_thumbnail_id, true); //
    }
}
// ADD NEW COLUMN
function vip_columns_head($defaults) {
    $nouvelle_colonne=array('featured_image' => 'Featured Image');
    return array_merge($defaults, $nouvelle_colonne);
}

// SHOW THE FEATURED IMAGE
function vip_columns_content($column_name, $post_ID) {
    //echo get_the_ID()." : ".$post_ID;
    if ($column_name == 'featured_image') {
        $post_featured_image = vip_get_featured_image($post_ID);
        if ($post_featured_image) {
            echo '<img src="' . $post_featured_image . '" width="50" />';
        }
    }
}
add_filter('manage_posts_columns', 'vip_columns_head');
add_action('manage_posts_custom_column', 'vip_columns_content', 10, 2);

add_image_size( 'large-thumbnail', 1280, 500, true );
/****************************************************************/
/*	54.	Contenu par défaut pour les Projets						*/
/****************************************************************/
add_filter( 'default_content', 'my_editor_content', 10, 2 );

function my_editor_content( $content, $post ) {

    switch( $post->post_type ) {
        case 'projet':
            $content = '<h3>Checklist</h3>
            <ul>
                <li>Salle :</li>
                <li>Technique en place :</li>
                <li>Matérial à amener :</li>
                <li>Jouer en maillots VIP :</li>
                <li>Collation/repas :</li>
                <li>Type de spectacle :</li>
                <li>Animateur/MC/arbitre :</li>
                <li>Type de public :</li>
                <li>Tarif :</li>
                <li>Rémunération :</li>
                <li>Communication à faire :</li>
            </ul>';
        break;
        /*default:
            $content = 'your default content';
        break;*/
    }

    return $content;
}
function has_gallery($post_id = false) {
    if (!$post_id) {
        global $post;
    } else {
        $post = get_post($post_id);
    }
    return ( strpos($post->post_content,'[gallery') !== false);
}