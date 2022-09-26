<?php

namespace Curl;

class CurlBuilder
{
    public function build($url, $options)
    {
        $wpcli_ch = curl_init($url);

        if( $wpcli_ch === false )
        {
            echo 'ERREUR : Une erreur interne est survenue (ligne #'.__LINE__.') :('.PHP_EOL;
            return( false );
        }

        $wpcli_ch_options = $options;

        foreach( $wpcli_ch_options as $wpcli_ch_option_key => $wpcli_ch_option_value )
        {
            $wpcli_ch_setopt = curl_setopt($wpcli_ch, $wpcli_ch_option_key, $wpcli_ch_option_value);

            if( $wpcli_ch_setopt === false )
            {
                echo 'ERREUR : Une erreur interne est survenue (ligne #'.__LINE__.') :('.PHP_EOL;
                return( false );
            }
        }

        $wpcli_ch_exec = curl_exec($wpcli_ch);

        if( $wpcli_ch_exec === false )
        {
            echo 'ERREUR : Une erreur est survenue lors du téléchargement => '.curl_error($wpcli_ch).' (ligne #'.__LINE__.') :('.PHP_EOL;
            return( false );
        }

        $wpcli_ch_http_status = curl_getinfo($wpcli_ch, CURLINFO_HTTP_CODE);

        if( $wpcli_ch_http_status !== 200 )
        {
            echo 'ERREUR : Le téléchargement a échoué avec le code HTTP '.$wpcli_ch_http_status.' (ligne #'.__LINE__.') :('.PHP_EOL;
            return( false );
        }

        curl_close($wpcli_ch);

        if( isset($options[CURLOPT_RETURNTRANSFER]) && $options[CURLOPT_RETURNTRANSFER] )
        {
            return( $wpcli_ch_exec );
        }

        return true;
    }
}
