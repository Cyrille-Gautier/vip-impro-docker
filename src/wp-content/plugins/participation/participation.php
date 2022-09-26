<?php

/**
 *@author  Xu Ding
 *@email   thedilab@gmail.com
 *@website http://www.StarTutorial.com
 * https://www.startutorial.com/articles/view/how-to-build-a-web-calendar-in-php
 **/
class Participation
{

    /**
     * Constructor
     */

    private $participant = null;

    private $date = null;

    private $participe = 0;

    public $idcalendrier = null;

    public $idevenement = null;

    /********************* PUBLIC **********************/

    public function getParticipations($idcalendrier = null, $idevenement = null, $post_ID = 146)
    {
        if(!$idcalendrier || !$idevenement)
        {
            throw new Exception('Erreur getParticipations : idcalendrier = '.$idcalendrier.' & idevenement = '.$idevenement);
        }
        $participation = $this->getParticipationsUnserialized($idcalendrier, $idevenement, $post_ID);
        return $participation;
    }


    /********************* PRIVATE **********************/
    private function getParticipationsSerialized($idcalendrier = null, $idevenement = null, $post_ID = 146)
    {
        $participations=[];
        if (have_rows('calendrier', $post_ID)) {
            while (have_rows('calendrier', $post_ID)) {
                the_row();
                $ncalendrier=get_row_index();
                if ($ncalendrier == $idcalendrier && have_rows('evenement')) {
                    while (have_rows('evenement')) {
                        the_row();
                        $nevenement=get_row_index();
                        if ( $nevenement == $idevenement ) {
                            $participations = get_sub_field('pre-inscription');
                        }
                    }
                }
            }
        }
        return $participations;
    }

    private function getParticipationsUnserialized($idcalendrier = null, $idevenement = null, $post_ID = 146)
    {
        if( !$idcalendrier || !$idevenement )
        {
            throw new Exception('Erreur getParticipationsUnserialized : idcalendrier = '.$idcalendrier.' & idevenement = '.$idevenement);
        }
        $participation = $this->getParticipationsSerialized($idcalendrier, $idevenement, $post_ID);
        $participation = unserialize($participation);
        return $participation;
    }

}
