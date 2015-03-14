<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/Users/ohthehugemanatee/Sites/michaelowens/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'michaelowens');

/** MySQL database username */
define('DB_USER', 'org_admin');

/** MySQL database password */
define('DB_PASSWORD', 'pr0Ab2lu');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Ds]8Kt^%]U;(S&Z8`Dr/>-uK:8>9!ER34^rsMKV?kzNR|-K~y6n(2{m{A,TB8IgH');
define('SECURE_AUTH_KEY',  '/g~1_U(gRz?3L(TIWdtEQhh,aT)fCDHitR{j{pWy+@`VVD }g3G.~y?:pw#[H9-F');
define('LOGGED_IN_KEY',    'sajrE|cE]5pb|Vb8KSr@<4N~?BTgK8edD59%1~3|:)~:]q#W|G4PKfTpDu|%u1._');
define('NONCE_KEY',        '_<vhXl=rlgG5e?N:(2mC9=*Msmay Udb-)&=xiy-m?Q+R:tb*;|8D>i IMq~#A#G');
define('AUTH_SALT',        'wb?L^E1C/>-x]vI6-RDvPQxNb7_NHR1j* +V<cM+eH%Zy}Q6FV@7u$JJk[{_x>$d');
define('SECURE_AUTH_SALT', ':T1lt6&9gOjut<}#=I2X;kFT=1Gub?gmvv%0|M>QrkpH!*VqH-H]<Llqp+{@6-P-');
define('LOGGED_IN_SALT',   ',|{.-|-wq4WiB{BV{?.) J_Lh|Y|2,[=JT{NuC}imap<|T-n{<md|FC[.Hxm~YF.');
define('NONCE_SALT',       '<@b>J`1D1BR1-=(OP[f:(sL~PM76|4h!L+I$ rcN/d!t~)+n1crZ_&CMn$d-k^%@');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
