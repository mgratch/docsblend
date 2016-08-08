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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'marcgrat_wp');

/** MySQL database username */
define('DB_USER', 'marcgrat_wp');

/** MySQL database password */
define('DB_PASSWORD', '9Ss48p2]-8');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'ed5ek89gp3dkscgedbpqnq2iexq6swhxnvlre8tswm5gilm4monrn1c84jqblpxu');
define('SECURE_AUTH_KEY',  'scwxaw3zrh8zhufn1txtqbocpgaziltvozfrzjrjnmpccoypt0ptnpcbaj58ykj0');
define('LOGGED_IN_KEY',    'wfntb4nvcoplsuaxumlxoekm7qrfxp5c1scujs7hutl1hkhli51nxc0tariy701g');
define('NONCE_KEY',        'blvhypn0hykm3mxvsjmq9iscefd2rsgrepuw6ujac7ms8t5wpblygfadmw063p3q');
define('AUTH_SALT',        'qgj713xlpu2fukqr2xdinvtik2todx6grcf9rmaxx7jpcquk5v3kqcc4x0ffyulm');
define('SECURE_AUTH_SALT', 'zouf3knbpqln55xq7ry8yel4un8ieu5mrdr5rjmvidinjuldnl8s301vtmxaautc');
define('LOGGED_IN_SALT',   'nybcmilffvtv7xrestqv7gv9zuhxxxvb9zstmoz8a4beliozuda0npmtb1jqvjkb');
define('NONCE_SALT',       'ct2kj3kuam3k6k6jktwtacka5zjm3lwq5iyppqwom8vumlfpuiiginnu7wue5anm');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
define( 'WP_MEMORY_LIMIT', '128M' );
define( 'WP_AUTO_UPDATE_CORE', false );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
