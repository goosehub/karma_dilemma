<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';

// Views
$route['games_on_auction'] = 'main/games_on_auction';
$route['started_games'] = 'main/started_games';
$route['api_docs'] = 'main/api_docs';

// Cron
$route['cron/(:any)'] = "cron/index/$1";

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;