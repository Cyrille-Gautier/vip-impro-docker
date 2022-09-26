<?php

define('WP_CACHE', true); // Added by WP Rocket
define('APP_VERSION', '1.2.0');

$environnement = getenv('ENVIRONMENT');
if (php_sapi_name() !== 'cli') {
    $_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'];
    $_SERVER['REQUEST_SCHEME'] = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? $_SERVER['REQUEST_SCHEME'];

    if ($_SERVER['REQUEST_SCHEME'] === 'https') {
        $_SERVER['HTTPS'] = 'on';
    }
}
if (!$environnement && php_sapi_name() !== 'cli') {

    $environnement = 'production';
    $url = ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? $_SERVER['REQUEST_SCHEME']) . '://' . ($_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST']);
    if (strpos($url, 'staging-') !== false || strpos($url, '.qualif') !== false) {
        $environnement = 'qualif';
    }

    if (strpos($url, '.local') !== false || strpos($url, '.localhost') !== false) {
        $environnement = 'dev';
    }
}

if (!$environnement) {
    echo '/!\ Pour utiliser WordPress en ligne de commande, il faut définir l\'environnement (production, qualif, dev) à l\'aide de la variable d\'environnement `ENVIRONMENT`.' . PHP_EOL;
    echo '    Exemple (PHP) : <?php putenv(\'ENVIRONMENT=dev\'); ?>' . PHP_EOL;
    echo '    Exemple (DOS) : set ENVIRONMENT=dev' . PHP_EOL;
    die;
}

if (!getenv('ENVIRONMENT')) {
    putenv("ENVIRONMENT=$environnement");
}

if ($environnement === 'production') {
    define('DB_NAME', 'vegetalconcept');
    define('DB_USER', 'vegetalconcept');
    define('DB_PASSWORD', 'tjTr3MEpknJKaoS');
    define('DB_HOST', 'localhost');

    define('WP_ENVIRONMENT_TYPE', $environnement);
} else if ( $environnement === 'qualif') {
    define('DB_NAME', 'vegetalconcept');
    define('DB_USER', 'vegetalconcept');
    define('DB_PASSWORD', 'tjTr3MEpknJKaoS');
    define('DB_HOST', 'localhost');

    define('WP_ENVIRONMENT_TYPE', $environnement);
} else {
    define('DB_NAME', 'vegetal_concept_docker');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
    define('DB_HOST', 'host.docker.internal');

    define('WP_ENVIRONMENT_TYPE', 'local');
}


if ( php_sapi_name() === 'cli' ) {
    define('WP_DEBUG_DISPLAY', false);
    define('SCRIPT_DEBUG', false);
    define('WP_DEBUG', false);
    define('WP_DEBUG_LOG', false);
} else if ($environnement === 'production') {
    define('WP_DEBUG_DISPLAY', false);
    define('SCRIPT_DEBUG', false);
    define('WP_DEBUG', false);
    define('WP_DEBUG_LOG', false);
} else if ( $environnement === 'qualif') {
    define('WP_DEBUG_DISPLAY', false);
    define('SCRIPT_DEBUG', false);
    define('WP_DEBUG', false);
    define('WP_DEBUG_LOG', false);
} else {
    define('WP_DEBUG_DISPLAY', true);
    define('SCRIPT_DEBUG', true);
    define('WP_DEBUG', true);
    define('WP_DEBUG_LOG', true);
}

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');
/** Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'v43g{@LZ#L,%S^^!vK89U{mQP%LIemtY`s(7<4z}1V`%<1a^R<@Pz$YPH/_0?(-2');
define('SECURE_AUTH_KEY', 'o_I_XYU&Gw^cH5Nz!N%U9NQS&fsD(OlF<_ lzx q,mgT3rlfAL8U!Sb[{ZL1K`aa');
define('LOGGED_IN_KEY', 'Q/<O,N?qS*k{8EBM3E{=snni}&(Nl4H }Q!HaHYH__W:^H7m`3X]ZoT&uez |n?O');
define('NONCE_KEY', ' K]x21wY!X9[`Zs36<)2[>`U?{Q%X:nky;oiy=gK{Cvg>(;gr_k9fguZgn1h04[}');
define('AUTH_SALT', '{En7?&MbCH6}Q+,Ki_OinMGvgYFIeox+1qek^*z-GG]L{)?772c^/sw`4# !|/36');
define('SECURE_AUTH_SALT', 'z1Pr8I2 6t+71s<EzwKmxPgOd0+.d~&F2vTC0]agwEZ,g1d+%%}|F,bnt5=wKNlR');
define('LOGGED_IN_SALT', 'tmcj_Z-NIg./OY8,Lkn1nSqEntz>v^4i-+[@;(/XgQgAG43S}gXXi-33q.fTj1sU');
define('NONCE_SALT', '$n*ICs0=>@P[ry]s;MYV$3.qQCnxtEVP[N{*?cKuP$s*t1Ylkn!-|K+$H9Bb-`/R');
/**#@-*/
/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';
/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
//define('WP_DEBUG', false);
/* C’est tout, ne touchez pas à ce qui suit ! */
/** Chemin absolu vers le dossier de WordPress. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

define('APP_COMPONENTS_PATH', ABSPATH . 'installer/components.json');
/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
