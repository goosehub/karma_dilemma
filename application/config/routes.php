<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';

// Views
$route['games_on_auction'] = 'main/games_on_auction';
$route['karma_on_auction'] = 'main/karma_on_auction';
$route['started_games'] = 'main/started_games';
$route['finished_games'] = 'main/finished_games';
$route['leaderboard'] = 'main/leaderboard';
$route['leaderboard/(:any)'] = 'main/leaderboard/$1';
$route['leaderboard/(:any)/(:any)'] = 'main/leaderboard/$1/$2';
$route['leaderboard/(:any)/(:any)/(:any)'] = 'main/leaderboard/$1/$2/$3';
$route['leaderboard/(:any)/(:any)/(:any)/(:any)'] = 'main/leaderboard/$1/$2/$3/$4';
$route['api_docs'] = 'main/api_docs';

// Cron
$route['cron/(:any)'] = "cron/index/$1";

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;