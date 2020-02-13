<?php
/**
 * Configuration overrides for WP_ENV === 'development'
 */

use Roots\WPConfig\Config;

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DEBUG_LOG', true);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
Config::define('SCRIPT_DEBUG', true);
Config::define('GOOGLE_MAP_API','AIzaSyA5pdShpGLoC1YRRNiGiyM_bDAuGwLHcCg');
Config::define('MAPBOX_API', 'pk.eyJ1IjoicGFuZGFicmFuZCIsImEiOiJjaWg2cGcyOHAwM2RsdWtrdHQ4bWU1dW53In0.Ey23wcFG2-wFAR-I-0HwlQ');

ini_set('display_errors', '1');

// Enable plugin and theme updates and installation from the admin
Config::define('DISALLOW_FILE_MODS', false);
