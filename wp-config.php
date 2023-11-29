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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'data_it_ctec' );

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
define( 'AUTH_KEY',         'eM0Nl)3QCdwB#n1z*PO=2&P0G1%TcN^OK>[L?G:H_#$oxvh;)rgskGkzG1lOGzAD' );
define( 'SECURE_AUTH_KEY',  'D&Lg}rPbKb]gcR^~vcGB3s)9==nQEF[-e[daPUa0c%lE2PVktLVlnv-FafNrt7wH' );
define( 'LOGGED_IN_KEY',    't4:hB@vZ~$aC+eBEA7DOuUoAbiI>w2%({L<:l9%?*]9YC+,TU2N-&Bqh5Q4Ir&wp' );
define( 'NONCE_KEY',        '%f|>7LB;BXpl8f3I(kHtO33G8);4r]-!WZD)}jvPzLi(L`C`NS}]}akCO.2,_*a%' );
define( 'AUTH_SALT',        'KCO3/vJ:>>t_=Pf#txpRb*eUx1;p:++p#y-~_KSXB223.=8(LrU2&xqQ2R5@T*Z(' );
define( 'SECURE_AUTH_SALT', 'z%t34+sf]ufF4]dPq.D3Q@L5#@NGVY;|?|1GC_azl.HUiWV`0Jv`{HMr[[1*/.Zr' );
define( 'LOGGED_IN_SALT',   'z4ql1^kITBE$l@rTB-6_4%R}IRBExO+}@#i&)mwnH)3Is$lT7:0`3kRnCAfqP!ag' );
define( 'NONCE_SALT',       'Gk-x(66g$aRf:c$r9?RgDM?1K97A_2|Z>q>E+Fl3Beaj@&eN3)._lmv%S3P&w`u:' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
