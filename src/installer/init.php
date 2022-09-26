<?php

use Curl\CurlBuilder;
use ZIP\ZIPBuilder;

class init
{
    public function build(): void
    {
        define('INSTALLER_DIR', __DIR__);

        spl_autoload_register([__CLASS__, 'autoload']);

        echo('=> I. Vérification des variables globales'.PHP_EOL);
        $this->getProjectVariables();

        echo('=> II. Copie du wp-config dans le dossier racine'.PHP_EOL);
        $this->CopyWPConfig();

        echo('=> III. Téléchargement de WP-Cli'.PHP_EOL);
        $this->getWPCLI();

        echo('=> IV. Téléchargement de la dernière version de Wordpress'.PHP_EOL);
        $this->getWordpress();

        echo('=> V. Paramétrage de l\'environnement'.PHP_EOL);
        $this->setEnvironnement();

        echo('=> VI. Mise en place de la base de donnée'.PHP_EOL);
        $this->checkDatabase();

        echo('=> VII. Installation des ressources du projet (liste présente dans le fichier components.json)'.PHP_EOL);
        $this->installRessourcesProject();

        echo('=> VIII. Finalisation de l\'installation'.PHP_EOL);
        $this->setProject();

        echo(PHP_EOL.'=> SUCCESS'.PHP_EOL.PHP_EOL);
    }

    private function setProject()
    {
        $this->rewriteFlush();
        $this->deleteTransient();
    }

    private function rewriteFlush()
    {
        echo('   => Flush des URLs du site'.PHP_EOL);
        shell_exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root rewrite flush');
    }

    private function deleteTransient()
    {
        echo('   => Suppression des transients'.PHP_EOL);
        shell_exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root transient delete-all');
    }

    private function getProjectVariables()
    {
        global $argv;

        if(count($argv) < 4)
        {
            echo('   => Toutes les variables ne sont pas passées. Le script doit être lancé avec l\'environnement, l\'URL et le nom du projet.'.PHP_EOL.
                'Exemple :  php installer\install.php dev https://vegetal-concept.valeur-et-capital.localhost vegetal-concept'.PHP_EOL);
            die;
        }

        $this->args = [
            'action' => $argv[1],
            'environnement' => $argv[2],
            'projectName' => $argv[4],
            'domain' => parse_url($argv[3])['host'],
            'siteURL' => $argv[3],
        ];
    }

    public function installRessourcesProject(): void
    {
        $this->getProjectVariables();
        // Dans le cas où on passe depuis le deploy.php, il faut relancer l'autoload
        spl_autoload_register([__CLASS__, 'autoload']);

        $elements = json_decode(file_get_contents(__DIR__.'/components.json'), true);

        if(count($elements) === 0 && $this->args['action'] === 'init')
        {
            $this->installNewProject();
            return;
        }

        foreach($elements as $element)
        {
            switch($element['type'])
            {
                case 'plugin':
                    $this->activatePlugin($element);
                    break;
                case 'service':
                    $this->activateService($element);
                    break;
                case 'theme':
                    $this->activateTheme($element);
                    break;
//                case 'uploads':
//                    $this->activateUploads($element);
//                    break;
                default:
                    echo('   /!\ L\'élement '.$element['name'].' ne respecte pas les conventions'.PHP_EOL);
                    break;
            }
        }

        echo(PHP_EOL.'   => Activation de tous les plugins'.PHP_EOL.PHP_EOL);
        exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root plugin activate --all --quiet');
    }

    private function installNewProject()
    {
        echo('   => Aucune ressource n\'est présente. components.json est vide.'.PHP_EOL);

        echo('   !! INSTALLATION DU NOUVEAU PROJET '.strtoupper($this->args['projectName']).' !!'.PHP_EOL);

        exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root core install --url='.$this->args['domain'].' --title='.$this->args['projectName'].' --admin_user=devadmin --admin_password=hqvwfMLT**slz72gX9 --admin_email=wordpress@connected-company.fr');

        echo('      => Installation par défaut d\'un thème vierge (sous Webpack) !!'.PHP_EOL);

        $this->activateTheme([
            'name'         => $this->args['projectName'] ?? "new_theme",
            'type'         => "theme",
            'destination'  => $this->args['projectName'] ? "themes/".$this->args['projectName'] : "themes/new_theme",
            'url'          => "https://gitlab.com/cc-wordpress-themes/cc_theme_vierge_webpack/-/archive/master/cc_theme_vierge_webpack-master.zip",
            'extra-files'  => [],
            'post-install' => null
        ]);

        echo('      => Visitez votre site à l\'URL suivante : '.$this->args['domain'].PHP_EOL);
    }

    private function activateUploads($element)
    {
        $check = $this->checkSubmodule($element);

        if($check === false)
        {
            echo('   => Installation des '.ucfirst($element['type']).' du projet'.PHP_EOL);

            $this->getGITArchive($element['url']);
            $this->moveToDirectory('wp-content/'.$element['destination']);
        }
    }

    private function activatePlugin($element)
    {
        $check = $this->checkSubmodule($element);

        if($check === false)
        {
            $this->getGITArchive($element['url']);
            $this->moveToDirectory('wp-content/'.$element['destination']);
            echo('   => Téléchargement du '.ucfirst($element['type']).' '.$element['name'].PHP_EOL);
        }

        $exec = exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root plugin install '.$element['name'].' --activate --quiet');
    }

    private function checkSubmodule(array $element)
    {
        if(array_key_exists('cmdSubmodule', $element) && $this->args['environnement'] === 'dev')
        {
            $this->installSubmodule($element);
            return true;
        }

        return false;
    }

    private function installSubmodule(array $element)
    {
        echo('   => Installation du '.$element['type'].' '.$element['name'].' (submodule)'.PHP_EOL);
        exec($element['cmdSubmodule'].' wp-content/'.$element['destination']);
    }

    private function activateService($element)
    {
        $check = $this->checkSubmodule($element);

        if($check === false)
        {
            if(!is_dir('wp-content/'.$element['destination']))
            {
                mkdir('wp-content/'.$element['destination'], 777, true);
            }

            $this->getGITArchive($element['url']);
            $this->moveToDirectory('wp-content/'.$element['destination']);

            echo('   => Installation du '.$element['type'].' '.$element['name'].PHP_EOL);
        }
    }

    private function activateTheme($element)
    {
        $this->getGITArchive($element['url'].'?private_token=bgQNbsem-bvs1FFauuje');
        $this->moveToDirectory('wp-content/'.$element['destination']);

        echo('   => Installation du '.$element['type'].' '.$element['name'].PHP_EOL);
        exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root theme activate '.$element['name']);
    }

    private function checkDatabase()
    {
        if($this->args['action'] === 'init')
        {
            $this->getDatabaseInformations();
            $this->checkDatabaseTables();
        }

        $this->setURLSite();

        echo('   => Mise à jour de la base de donnée'.PHP_EOL);
        $this->updateDatabase();
    }

    private function setURLSite()
    {
        $siteURLInDatabase = shell_exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root option get siteurl');

        if(trim($siteURLInDatabase) !== trim($this->args['siteURL']))
        {
            echo('   => L\'URL en base de donnée n\'est pas correct... Remplacement en cours...'.PHP_EOL);
            echo('   => Remplacement de : '.trim($siteURLInDatabase).' vers : '.trim($this->args['siteURL']).PHP_EOL);
            shell_exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root search-replace "'.trim($siteURLInDatabase).'" "'.trim($this->args['siteURL']).'"');
            return;
        }

        echo('   => L\'URL en base de donnée est correct'.PHP_EOL);
    }

    private function getDatabaseInformations()
    {
        $this->dbName = exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root config get DB_NAME');
        $this->dbUser = exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root config get DB_USER');
        $this->dbPswd = exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root config get DB_PASSWORD');
        $this->dbHost = exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root config get DB_HOST');
    }

    private function checkDatabaseTables(): void
    {
        $tables = shell_exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root db tables --all-tables');

        if(!is_null($tables))
        {
            echo '   => Les tables présentes dans la base de données sont : '.str_replace(' ', ',', $tables).PHP_EOL;
            return;
        }

        $this->setDatabase();
    }

    private function updateDatabase()
    {
        exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root core update-db');
        echo(' Mise à jour de la base de donnée terminée.'.PHP_EOL);
    }

    private function setDatabase()
    {
        echo '   => Aucune table de présente dans la base de donnée du projet... Mise en place de la base de données présente dans installer/.dump.sql'.PHP_EOL;
        exec('mysql --host='.$this->dbHost.' --user='.$this->dbUser.' --password='.$this->dbPswd.' '.$this->dbName.' < '.__DIR__.DIRECTORY_SEPARATOR.'.dump.sql');

        echo '   => Importation de la base de données terminée. (depuis le installer/.dump.sql)'.PHP_EOL;
    }

    private function setEnvironnement()
    {
        $environnement = $this->args['environnement'];
        if(!getenv('ENVIRONMENT'))
        {
            putenv("ENVIRONMENT=$environnement");
        }

        echo('Le site est installé en environnement de : '.$environnement.PHP_EOL);
        exec('set ENVIRONMENT="'.$environnement.'"');
    }

    private function getWordpress()
    {
        exec('ENVIRONMENT='.$this->args['environnement'].' php wp-cli.phar --path="./" --allow-root core download --locale=fr_FR');

        $unusedElements = [
            'themes' => ['twentynineteen', 'twentytwenty', 'twentytwentyone', 'twentytwentytwo'],
            'plugins' => ['akismet'],
        ];

        foreach($unusedElements as $elementkey => $elements)
        {
            foreach($elements as $element)
            {
                $directoryPath = 'wp-content/'.$elementkey.'/'.$element;
                if(is_dir($directoryPath))
                {
                    $directory = escapeshellarg($directoryPath);
                    exec("rm -Rf $directory");
                    echo('   => Suppression du '.$elementkey.' Wordpress inutile : '.$element.PHP_EOL);
                }
            }
        }

        exec('rm '.escapeshellarg('hello.php'));
        echo('   => Suppression du plugins Wordpress inutile : hello.php'.PHP_EOL);
    }

    private function getWPCLI()
    {
        exec('curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar');
    }

    private function CopyWPConfig()
    {
        copy(INSTALLER_DIR.'/wp-config.php', 'wp-config.php');
        copy(INSTALLER_DIR.'/.htaccess', '.htaccess');
    }

    public static function autoload($class): void
    {
        $path = __DIR__;
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        if(is_file($path.DIRECTORY_SEPARATOR.$class.'.php'))
        {
            require_once($path.DIRECTORY_SEPARATOR.$class.'.php');
        }
    }

    private function moveToDirectory($directoryDestination): void
    {
        $directoriesTemp = glob('temp/*' , GLOB_ONLYDIR);

        self::recurseCopy($directoriesTemp[0], $directoryDestination);

        self::removeTempDirectory();
    }

    public static function removeTempDirectory(): void
    {
        $directory = escapeshellarg('temp/');
        exec("rm -rf $directory");
    }

    public static function recurseCopy(string $sourceDirectory, string $destinationDirectory, string $childFolder = ''): void
    {
        $directory = opendir($sourceDirectory);

        if ((is_dir($destinationDirectory) === false) && !mkdir($destinationDirectory) && !is_dir($destinationDirectory))
        {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $destinationDirectory));
        }

        if ($childFolder !== '') {
            if ((is_dir("$destinationDirectory/$childFolder") === false) && !mkdir("$destinationDirectory/$childFolder") && !is_dir("$destinationDirectory/$childFolder"))
            {
                throw new RuntimeException(sprintf('Directory "%s" was not created', "$destinationDirectory/$childFolder"));
            }

            while (($file = readdir($directory)) !== false) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                if (is_dir("$sourceDirectory/$file") === true) {
                    self::recurseCopy("$sourceDirectory/$file", "$destinationDirectory/$childFolder/$file");
                } else {
                    copy("$sourceDirectory/$file", "$destinationDirectory/$childFolder/$file");
                }
            }

            closedir($directory);

            return;
        }

        while (($file = readdir($directory)) !== false)
        {
            if ($file === '.' || $file === '..')
            {
                continue;
            }

            if (is_dir("$sourceDirectory/$file") === true)
            {
                self::recurseCopy("$sourceDirectory/$file", "$destinationDirectory/$file");
            }
            else
            {
                copy("$sourceDirectory/$file", "$destinationDirectory/$file");
            }
        }

        closedir($directory);
    }

    private function getGITArchive($urlArchive)
    {
        (new ZIPBuilder())->build($urlArchive, 'temp');
    }
}
