<?php

namespace ZIP;

use Curl\CurlBuilder;

class ZIPBuilder
{
    private string $tmpfile_path;
    private $tmpfile;

    public function build($url, $tempPathToExtract): bool
    {
        $this->getZip($url);

        $zip = new \ZipArchive;

        $zip_open = $zip->open($this->tmpfile_path, $zip::CHECKCONS);

        if( $zip_open !== true )
        {
            echo 'ERREUR : L\'ouverture de l\'archive du projet GitLab avec ZipArchive a échoué (ligne #'.__LINE__.') :('.PHP_EOL;
        }

        $zip_extract = $zip->extractTo($tempPathToExtract);

        if( $zip_extract === false )
        {
            echo 'ERREUR : L\'extraction de l\'archive du projet GitLab avec ZipArchive a échoué (ligne #'.__LINE__.') :('.PHP_EOL;
        }

        return $zip->close();
    }

    private function getZip($url)
    {
        $this->tmpfile = tmpfile();
        $tmpfile_meta = stream_get_meta_data($this->tmpfile);

        $this->tmpfile_path = $tmpfile_meta['uri'];

        (new CurlBuilder())->build($url,
        [
            CURLOPT_SSL_VERIFYHOST => 81,
            CURLOPT_SSL_VERIFYPEER => 64,
            CURLOPT_FILE           => $this->tmpfile,
        ]);
    }
}
