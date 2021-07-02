<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'joinhpkh_wp237' );

/** MySQL database username */
define( 'DB_USER', 'joinhpkh_wp237' );

/** MySQL database password */
define( 'DB_PASSWORD', '9K1.C4kS@pi@r@' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '54yzqg27g8ehndgfuublou7l2ifcyr4kab0ya4zqiymipxzklgb2bzv5nuxbj6gq' );
define( 'SECURE_AUTH_KEY',  'glx5r23mzdu6uhcci3zrf9madgn7nzdofatlgwcrqj1yllazacwwvixj5yvt1gta' );
define( 'LOGGED_IN_KEY',    'wlgcocuckhzhwy7g39drm6p9vyq3sltzaqm0rkpgqmeuuktv7lxjqze9ergzpma7' );
define( 'NONCE_KEY',        'gbt9wffkxuyxau0hzsuiddtlzif15tngoxzw0mtsoizxv7aynv9dr4kdie8yfoks' );
define( 'AUTH_SALT',        'snt9suzra0hpjx1ov4kaa4p3lllthvywl3ov9ffyglj6rb6xtndib91hesxpnsct' );
define( 'SECURE_AUTH_SALT', 'abn2zib66oqxuqrzo5tudpjj2rtapjphx29st8nyaiz3g7bdbfnfdxjudfkjv0uy' );
define( 'LOGGED_IN_SALT',   'tdw5pcw8umrv6i3d75sfn5cuki7hyxwyrngrjyphn6frdfmirrutfhjyy0livngl' );
define( 'NONCE_SALT',       'dflsmvio9pwtncjlvq3qpajc3emt9ujdmxqa0prk7mwghdvlmsrpy0nkmw45ou9h' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpnq_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
