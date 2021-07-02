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
define( 'DB_NAME', 'joinhpkh_wp459' );

/** MySQL database username */
define( 'DB_USER', 'joinhpkh_wp459' );

/** MySQL database password */
define( 'DB_PASSWORD', 'S(b38@I5-Ip9(8' );

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
define( 'AUTH_KEY',         'qvydqrekwnn8njzdkmgar8chp7jdka986powy3vyilybo7209grbi6tp8e3pqs8r' );
define( 'SECURE_AUTH_KEY',  'qdqj35eluwd7ot4ukui5m7yv0itne4qkhc0nzq69hqyzkxf747zyp28s0py7r58s' );
define( 'LOGGED_IN_KEY',    'ryujwetoaunkhaeltwqawf9xn18sdm9kr3hc2pe02zmxsgbhwgjozrjhvh955h7b' );
define( 'NONCE_KEY',        'gfq17i71tcrq4dmrhimq38wkvumj0jfazty5ezenulzfhcjnuqcjstcqxhzkj9i6' );
define( 'AUTH_SALT',        'qo57kbiubrls611ljnrzaocl4u1jgxpzobfz2eqpc7g8ycnwhu7yatzgvyzqke9z' );
define( 'SECURE_AUTH_SALT', 'ip5vakh5h9tlgqfscyk52kvyporkkxvxufloihhmso2lc1rlgfhtszcu5f4g39rb' );
define( 'LOGGED_IN_SALT',   '2enp37wiibtiatmnnyi4ertjaqzev89jili9v1ydvyvayoyaihofvogo2wkjvy3p' );
define( 'NONCE_SALT',       'c9wjmnikexhfhbzknua7haxvlb77mzzquaqr9bpy9th14o50qzaiwrinf83pns85' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpoq_';

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
