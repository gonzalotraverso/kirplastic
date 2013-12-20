<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
ob_start();
error_reporting(0);
// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'wearegro_kirplastic');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'wearegro_kir');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'sexpistols');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'LYia@?SuQyX-e@-&n{O7d++4IZDC1udrud,#YkIv Upbc2@~7wiC$^#@^0j:u-X3'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', 'jl{uKz^@.iE[C[D@7dk85ct2Y;S=1afRnpIRS[J]EhP)7@ [%jr9a9{bWR`gC2+t'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', ']0ar(,j,u;a</W( ;=Y kS5i,UUHGvw(=zCR30+u]IfR&jqC$&{7FR$>yb.R(D|h'); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', 'Tlien>1b|m5o4L)Z|rHiqN+ZM^z%niOO(-pyS<6Yez7/cu+2=cPzRXY~ T97vH>v'); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', '3{4+VTcbzQRN]}?8~KrrEAY>0-0h:+wz8@Kadfk@EDknF)(Br|9ofv&]IvrD#HaD'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', ',WzpY#S;TG*n2T&F1d1O8s2?MZo}w{Z|z3oQ-dm2LwYiy/I=N|$OhhuSc!,brTCp'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', 'cN/]bJ#oqK6~gB0Dy<_i+!<d0H{qlWUy:B[>}vz`/[draUIL*iDnp>(G20b_-/V^'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', 'x2#!P:9|g<UyCSLk;WrS{!G%An-xqc+U/ `XTI->vLSl~eu<u-ooDkZ>eg8|4<kL'); // Cambia esto por tu frase aleatoria.

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';

/**
 * Idioma de WordPress.
 *
 * Cambia lo siguiente para tener WordPress en tu idioma. El correspondiente archivo MO
 * del lenguaje elegido debe encontrarse en wp-content/languages.
 * Por ejemplo, instala ca_ES.mo copiándolo a wp-content/languages y define WPLANG como 'ca_ES'
 * para traducir WordPress al catalán.
 */
define('WPLANG', 'es_ES');

/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');