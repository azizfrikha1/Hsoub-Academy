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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp-ecommerce' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'P!NYxq*N]Svx1> [Hec.fi.f]Bx`g@g5qf!CLc+8&G*NxqgY8UbuPPq/%04*%&pN' );
define( 'SECURE_AUTH_KEY',  'Pyz7:V*s:ZC#]Z5Q:&{F8jAY@@YMK Q+Gs}g@jqf<xB4l`^U2gy<ht&Jr:KvPVVx' );
define( 'LOGGED_IN_KEY',    ',e^QRa@7$6vM-Q}%uJ]|&h281Q`=3}lT+WitdA;5U;Z4y:--Y&#%8sbIh!M{a(vT' );
define( 'NONCE_KEY',        '$BB>5TGIpj_N%YO<BSIbY?piw]qrCZJ2#*!!|3uKycN::O$tIRco9SjTZA.>?;d+' );
define( 'AUTH_SALT',        'X6{zcqf@3u_Ma}Unk>|D~nI3/d9qG}Q2^nP@p0}M|c{zO]_Aqt=<G/k[! RvG.k*' );
define( 'SECURE_AUTH_SALT', 'js`8)p(vm[<IbU,&2S.7`vFb`I<{ZbyN5_FP`,03;br9~&ZwB&S*}7E3kk{sV0Bc' );
define( 'LOGGED_IN_SALT',   'Wi:..E0gEeeeId{6S!=GMS}Pf&dL)ac-!N153I|])P7ogI>f*t;VMx tWx^Eo^]X' );
define( 'NONCE_SALT',       '<h$gDTLS].Y]_me==* mePER;n%T~uO3C>RFK7U:uz6,g~Zx&tDsGjaBf?oa9C8N' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
