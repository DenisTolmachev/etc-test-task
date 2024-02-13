<?php
define( 'WP_CACHE', true );
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u340379824_ZxxjJ' );

/** Database username */
define( 'DB_USER', 'u340379824_NAQS9' );

/** Database password */
define( 'DB_PASSWORD', 'Os5Qp8yfm7' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'Zh>jqzUpT]xpu)U2L;NX2(rG,@erNi9=q>Id{S?A:MUD/an`[w6[^u2y62[OLwD:' );
define( 'SECURE_AUTH_KEY',   '.k$n1lNP-xsM76U[mLAsGyXM]x|{@z;E4p3C-w|)c]SB&JWERc>RdeQc#2(e{uXR' );
define( 'LOGGED_IN_KEY',     'An(7ii/U;aI2/NG5$%U& _K.-S4&9 S_7@Gs@op$Jic`&tzQbo($|8?;hudgXaYB' );
define( 'NONCE_KEY',         'LNMtD*cPh^l1ZHrM4.{8Mi*677:mq3; zN0xg$ekJ6un@:R[|SqDb!?9>w4MN!{R' );
define( 'AUTH_SALT',         'jWOlwnh^gJ|zuj6Y&h#$- Uthqq5+{U8o;}Qea[PwZT?IEUE4Yi Y+nGF9nOHgHh' );
define( 'SECURE_AUTH_SALT',  'bLn)<)A!wylX+5BL[NxTVKDrqyN!*}hakJ`%?SE? *nCnpN gC/D)?3[h~sv0|_r' );
define( 'LOGGED_IN_SALT',    'o_%&2s[x(#=L8$jN1@%/h/d}(F<rV}{WkBDCv2R,<LO0thkkAv R8g(/F(#=c_Cw' );
define( 'NONCE_SALT',        'wt/kmg!?SyK3+4#i$~}oOjN82*YLbV.Q]/x@`Ky9lOZ~dUzNd0a!Nks>}JHv?D55' );
define( 'WP_CACHE_KEY_SALT', '=tB)!TB2g_9<UFf8aJOul0wTXehL3u?srRQxa@ix!TmZy?MJ4}?AUf3Kz%p<sA{9' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
