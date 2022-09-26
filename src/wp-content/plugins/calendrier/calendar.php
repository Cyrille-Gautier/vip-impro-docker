<?php
/**
*@author  Xu Ding
*@email   thedilab@gmail.com
*@website http://www.StarTutorial.com
* https://www.startutorial.com/articles/view/how-to-build-a-web-calendar-in-php
**/
class Calendar {

    /**
     * Constructor
     */

    public function __construct(){
        $this->naviHref = htmlentities($_SERVER['SCRIPT_URI']);
        //$this->naviHref = htmlentities("/calendrier/");
    }

    /********************* PROPERTY ********************/
    //private $dayLabels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
    private $dayLabels = array("L","M","M","J","V","S","D");

    private $currentYear=0;

    private $currentMonth=0;

    private $currentDay=0;

    private $agendas=null;

    private $currentDate=null;

    private $daysInMonth=0;

    private $naviHref= null;

    /********************* PUBLIC **********************/

    /**
    * print out the calendar
    */
    public function show( $cal_year = null, $cal_month = null, $with_agendas = true, $class=NULL ) {

        if(null==$class){
			$class="";
		}

        if(null==$cal_year&&isset($_GET['cal_year'])){

            $cal_year = $_GET['cal_year'];

        }else if(null==$cal_year){

            $cal_year = date("Y",time());

        }

        if(null==$cal_month&&isset($_GET['cal_month'])){

            $cal_month = $_GET['cal_month'];

        }else if(null==$cal_month){

            $cal_month = date("m",time());

        }

        $this->currentYear=$cal_year;

        $this->currentMonth=$cal_month;

        $this->daysInMonth=$this->_daysInMonth($cal_month,$cal_year);

		$this->agendas=array();
		if ($with_agendas==true || $with_agendas=="true") $this->agendas = $this->_retrieveAgendas( $idPage=146 );
		//echo "<pre>".print_r($this->agendas,true)."</pre>";
		//$additionnalInfo.="<pre>".print_r($agendas,true)."</pre>";
        /*<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Détails</h3>
			</div>
				<div class="panel-body">

					</div>
		</div>*/
        $content='<div id="calendar" class="panel panel-default '.$class.'">'.
                        '<div class="box panel-heading">'.
                        $this->_createNavi().
                        '</div>'.
                        '<div class="box-content panel-body">'.
                                '<ul class="label">'.$this->_createLabels().'</ul>';
                                $content.='<div class="clear"></div>';
                                $content.='<ul class="dates">';

                                $weeksInMonth = $this->_weeksInMonth($cal_month,$cal_year);
                                // Create weeks in a cal_month
                                for( $i=0; $i<$weeksInMonth; $i++ ){

                                    //Create days in a week
                                    for($j=1;$j<=7;$j++){
                                        $content.=$this->_showDay($i*7+$j);
                                    }
                                }

                                $content.='</ul>';

                                $content.='<div class="clear clearfix"></div>';

                        $content.='</div>';

        $content.='</div>';
        return $content;
    }

    /********************* PRIVATE **********************/
    /**
    * get Spectacles custom post type
    */
    private function _retrieveSpectacles($spectacleDate){
		$elements=array();
		$args = array(
					'post_type'=>'spectacle',
					'post_status' => 'publish',

					'meta_key'=> 'details_date_de_representation',
					'orderby' => 'meta_value',
					'order' => 'ASC',

					'meta_query' => array(
						array(
							'key'     => 'details_date_de_representation',
							'value'   => $spectacleDate,
							'compare' => '=',
						),
					)
				);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) : $query->the_post();

    			$attr_small="h=80&w=80&q=80";
				$urlimage=get_image('details_affiche',1,1,0,NULL,$attr_small);
				$elements[get_the_ID()] = array('title'=>get_the_title(), 'description'=>get_the_content(), 'meta'=>get_post_custom(get_the_ID()), 'urlimage'=>$urlimage );
			endwhile;
		endif;

        return $elements;
    }

    /**
    * get Projets custom post type
    */
    private function _retrieveProjets($projetDate){
		$elements=array();
		$args = array(
					'post_type'=>'projet',
					'post_status' => 'publish',

					'meta_key'=> 'details_date_finale',
					'orderby' => 'meta_value',
					'order' => 'ASC',

					'meta_query' => array(
						array(
							'key'     => 'details_date_finale',
							'value'   => $projetDate,
							'compare' => '=',
						),
					)
				);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) : $query->the_post();

    			$attr_small="h=80&w=80&q=80";
				//$urlimage=get_image('details_affiche',1,1,0,NULL,$attr_small);
				$elements[get_the_ID()] = array('title'=>get_the_title(), 'description'=>get_the_content(), 'meta'=>get_post_custom(get_the_ID()) );//, 'urlimage'=>$urlimage );
			endwhile;
		endif;

        return $elements;
    }


    /**
<<<<<<< HEAD
    * get Agendas post type
    */
    private function _retrieveAgendas($idPage){
		$elements=array();

		if (have_rows('calendrier', $idPage)) {
			$nelement=0;
		  	while (have_rows('calendrier', $idPage)) {
			  the_row();
			  $elements[$nelement]=array(
			  	'titre'=>get_sub_field('titre'),
			  	'evenement'=>array()
			  );
			  if (have_rows('evenement')) {
				while (have_rows('evenement')) {
				  the_row();
				  $elements[$nelement]['evenement'][]=array(
					'date' => get_sub_field('date'),
					'intitule' => get_sub_field('intitule'),
					'couleur' => get_sub_field('couleur'),
					'animateur' => get_sub_field('animateur'),
					'description'=>get_sub_field('description')
				  );
				}
			  }
			  $nelement++;
		  	}
		}

        return $elements;
=======
     * get Agendas post type
     */
    public function _retrieveAgendas($idPage)
    {
        $elements = array();

        if (have_rows('calendrier', $idPage)) {
            $ncalendrier = 0;
            while (have_rows('calendrier', $idPage)) {
                the_row();
                $elements[] = array(
                    'titre' => get_sub_field('titre'),
                    'evenement' => array()
                );
                if (have_rows('evenement')) {
                    $nevenement = 0;
                    while (have_rows('evenement')) {
                        the_row();
                        $elements[]['evenement'][$nevenement] = array(
                            'postid' => $idPage,
                            'date' => get_sub_field('date'),
                            'intitule' => get_sub_field('intitule'),
                            'couleur' => get_sub_field('couleur'),
                            'animateur' => get_sub_field('animateur'),
                            'description' => get_sub_field('description'),
                            'pre-inscription' => get_sub_field('pre-inscription'),
                            'idevenement' => $nevenement+1,
                            'idcalendrier' => $ncalendrier+1,
                        );
                        $nevenement++;
                    }
                }
                $ncalendrier++;
            }
        }

        return $elements;
>>>>>>> 60c8aa3... modifs ajax
    }

    /**
     * get Agendas post type
     */
    private function _retrieveAgenda($agendaDate, $agendas)
    {
        $elements = array();

        if (isset($agendas) && is_array($agendas) && count($agendas) > 0)
        {
            foreach ($agendas as $nagenda => $agenda)
            {

                if (isset($agenda['evenement']) && is_array($agenda['evenement']) && count($agenda['evenement']) > 0)
                {
                    foreach ($agenda['evenement'] as $nevenement => $evenement)
                    {
                        if ($agendaDate == $evenement['date']) $elements[] = $evenement;
                    }
                }
            }
        }
        /*
            Array
            (
                [0] => Array
                    (
                        [titre] => 2018-2019
                        [evenement] => Array
                            (
                                [0] => Array
                                    (
                                        [date] => 20180905
                                        [intitule] => Journées d'intégration
                                        [couleur] => danger
                                        [animateur] => Cyrille
                                        [description] => Ouvert à tous pour tester l'improvisation. En fonction du nombre de places disponibles, une sélection pourra être effectuée par les animateurs
                                    )

                                [1] => Array
                                    (
                                        [date] => 20180912
                                        [intitule] => Journées d'intégration
                                        [couleur] => danger
                                        [animateur] => Cyrille
                                        [description] => Ouvert à tous pour tester l'improvisation. En fonction du nombre de places disponibles, une sélection pourra être effectuée par les animateurs
                                    )
                  …*/

        return $elements;
    }
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber){
		$listeicones=array('danger'=>'mdi mdi-sunglasses', 'info'=>'mdi mdi-school', 'success'=>  'mdi mdi-white-balance-sunny', 'warning'=>'mdi mdi-theater' );
        if($this->currentDay==0){

            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));

            if(intval($cellNumber) == intval($firstDayOfTheWeek)){

                $this->currentDay=1;

            }
        }

        if (($this->currentDay != 0) && ($this->currentDay <= $this->daysInMonth)) {

            $this->currentDate = date('Y-m-d', strtotime($this->currentYear . '-' . $this->currentMonth . '-' . ($this->currentDay)));

            $cellContent = $this->currentDay;

            $date = date('Y-m-d', strtotime($this->currentYear . '-' . $this->currentMonth . '-' . ($this->currentDay)));
            $additionnalInfo = "";
            if ((isset($current_user) &&  $current_user->roles[0] == 'adherent') || current_user_can('edit_others_pages')) {
                $projets = $this->_retrieveProjets($date);
                //var_dump($projets);
                foreach ($projets as $id => $projet) {
                    $additionnalInfo .= "<div class='agenda projet'><a href='" . get_the_permalink($id) . "' target='_blank' class='button secondary button-sm button-default'><small>" . $projet['title'] . "</small></a></div>";
                }
            }
            $spectacles = $this->_retrieveSpectacles($date);
            foreach ($spectacles as $id => $spectacle) {
                if (isset($spectacle['urlimage']) && strlen($spectacle['urlimage']) > 0) $additionnalInfo .= "<div class='affiche'><a href='" . get_the_permalink($id) . "' target='_blank'><img src='" . $spectacle['urlimage'] . "' class=''></a></div>";
            }

            $date2 = date('Ymd', strtotime($this->currentYear . '-' . $this->currentMonth . '-' . ($this->currentDay)));
            $evenements = $this->_retrieveAgenda($date2, $this->agendas);
            //$additionnalInfo.="<div class='affiche'>".$date2." ".$this->agendas."</div>";
            global $liste_calendar_contents;
            if (!isset($liste_calendar_contents) || !is_array($liste_calendar_contents)) $liste_calendar_contents = array();
            if (isset($evenements) && is_array($evenements) && count($evenements) > 0)
            {
                foreach ($evenements as $nevenement => $evenement)
                {
                    $liste_calendar_contents[$date][] = $evenement;
                    ?>
                    <?php
                    if (isset($evenement['couleur']) && strlen($evenement['couleur']) > 0) $additionnalInfo .= '
                    <div class="agenda ' . $evenement['couleur'] . '">
                        <button type="button" class="button secondary button-sm button-' . $evenement['couleur'] . ' open-offcanvas"
                            data-container="body"
                            data-toggle="popover"
                            data-placement="top"
                            data-content="' . $evenement['description'] . '"
                            data-participation-content="form-evenement' . $evenement['idevenement'] . '"
                            title="' . $evenement['intitule'] . '"
                            data-content-id="' . $date . '"
                            data-evenement-id="' . $evenement['idevenement'] . '"
                        ><i class="' . $listeicones[$evenement['couleur']] . '"></i></button>
                    <form class="form-inline js-ajax-form form-participation-adherent" style="display:none;" id="form-evenement' . $evenement['idevenement'] . '">
                        <h2>Participants</h2>
                        <table width="100%" cellpadding="0" cellspacing="0" id="participants' . $evenement['idevenement'] . '">
                            <thead>
                                <tr>
                                    <th>Nom / email</th>
                                    <th>Participe</th>
                                    <th>Commentaire</th>
                                </tr>
                            </thead>
                            <tbody class="participants">
                                <tr class="participant model hide">
                                    <td class="nom"></td>
                                    <td class="participe"></td>
                                    <td class="commentaire"></td>
                                </tr>
                            </tbody>
                        </table>
                        <h3>Participerez-vous ?</h3>
                        <div class="form-group">
                            <input type="hidden" name="agenda-date" value="' . $date . '">
                            <input type="hidden" name="postid" value="' . $evenement['postid'] . '">
                            <input type="hidden" name="idevenement" value="' . $evenement['idevenement'] . '" data-evenement="'.serialize($evenement).'">
                            <input type="hidden" name="idcalendrier" value="' . $evenement['idcalendrier'] . '">
                            <input type="hidden" name="pre-inscription" value="'. $evenement['pre-inscription'] . '">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" value="" class="form-control " placeholder="Votre email">
                        </div>
                        <div class="form-group">
                            <label><input type="radio" name="participe" value="1" class=""> Oui</label>
                            <label><input type="radio" name="participe" value="0" class=""> Non</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="commentaire" value="" class="form-control" placeholder="Votre commentaire">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="button btn btn-primary"><i class="mdi mdi-send"></i> Envoyer</button>
                        </div>
                    </form>
                    <div class="flashbag-container"></div>
                </div>';
                }
            }
            $cellContent .= $additionnalInfo;

            //$cellContent .= $agendaDate;

            $this->currentDay++;
        } else {

            $this->currentDate = null;

            $cellContent = null;
        }


        return '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                ($cellContent==null?'mask':'').'">'.$cellContent.'</li>';
    }

    /**
    * create navigation
    */
    private function _createNavi(){

        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;

        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;

        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;

        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;

        return
            '<div class="header">'.
                '<a class="prev" href="'.$this->naviHref.'?cal_month='.sprintf('%02d',$preMonth).'&cal_year='.$preYear.'"><i class="glyphicon glyphicon-menu-left"></i></a>'.
                    '<h3 class="panel-title">'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</h3>'.
                '<a class="next" href="'.$this->naviHref.'?cal_month='.sprintf("%02d", $nextMonth).'&cal_year='.$nextYear.'"><i class="glyphicon glyphicon-menu-right"></i></a>'.
            '</div>';
    }

    /**
    * create calendar week labels
    */
    private function _createLabels(){

        $content='';

        foreach($this->dayLabels as $index=>$label){

            $content.='<li class="'.($index==6?'end title':'start title').' '.strtolower($label).'">'.$label.'</li>';

        }

        return $content;
    }



    /**
    * calculate number of weeks in a particular cal_month
    */
    private function _weeksInMonth($cal_month=null,$cal_year=null){

        if( null==($cal_year) ) {
            $cal_year =  date("Y",time());
        }

        if(null==($cal_month)) {
            $cal_month = date("m",time());
        }

        // find number of days in this cal_month
        $daysInMonths = $this->_daysInMonth($cal_month,$cal_year);

        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);

        $monthEndingDay= date('N',strtotime($cal_year.'-'.$cal_month.'-'.$daysInMonths));

        $monthStartDay = date('N',strtotime($cal_year.'-'.$cal_month.'-01'));

        if($monthEndingDay<$monthStartDay){

            $numOfweeks++;

        }

        return $numOfweeks;
    }

    /**
    * calculate number of days in a particular cal_month
    */
    private function _daysInMonth($cal_month=null,$cal_year=null){

        if(null==($cal_year))
            $cal_year =  date("Y",time());

        if(null==($cal_month))
            $cal_month = date("m",time());

        return date('t',strtotime($cal_year.'-'.$cal_month.'-01'));
    }

}