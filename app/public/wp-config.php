<?php
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
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          'F!l[pWYI,w>v]xBQX;Eue/_.yb<M{_!hOgc/a3wt=%^(?>nE$_-0-xz=]-z_Q@V|' );
define( 'SECURE_AUTH_KEY',   'R~)3By>0c2|MHoU~igz)2qn[8l/L8xxIJO>p9Xp9;(1A1Wck0%`GBcy kg+j(1C3' );
define( 'LOGGED_IN_KEY',     '#&Cpfl,U|2Ph!i{JyBkQQ(YSOK;ie7>Uoz*BJeQ5[z4%o1of6s@nZp03-}0V/v3t' );
define( 'NONCE_KEY',         'hDX1_[LCwP6=[vIJ@gi88>-Q^qwYK<x[0n{#u9lmw.Rys^Qj)nWs2)dYdmxZ P;>' );
define( 'AUTH_SALT',         '2Z)?alnG/]bcb(o~%JlUuw9UJ*Cf6IJzPP!X5?(Nel[k:?d~dni/#KI~/oCE_c`%' );
define( 'SECURE_AUTH_SALT',  'eRsIt$8<;hBDQ;!bNmZN-j}*a]I=),q.S4*05dLT6ub5%k%ZM~zzZ;bOG{qIHeP)' );
define( 'LOGGED_IN_SALT',    'n|&p~.|&^;tIdo*mQvEa*U3_>Ji9UG|`94 o*3*dpAP+GCJ~:*1pAbs^>{=k%$Q&' );
define( 'NONCE_SALT',        'z$i-`%RnJmI^^VrK^w+gU(`KIrhRsJt1V~.qy3C=>ydE/toFCd]{Mo)zDI`e)cXZ' );
define( 'WP_CACHE_KEY_SALT', 'q4R-JC)9[`}wSIfsoy=MN3<Q(2y[yDl<T^O)?B3VDSNf!X?OW]W%TI[oaxweM$Yf' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
