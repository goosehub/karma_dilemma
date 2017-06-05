<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Homepage
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
$route['user/register'] = 'user/register';
$route['user/login'] = 'user/login';
$route['user/avatar'] = 'user/avatar';
$route['user/logout'] = 'user/logout';
$route['user'] = 'main/user';
$route['user/(:any)'] = 'main/user/$1';
$route['api_docs'] = 'main/api_docs';

// API Paths Views
$route['api'] = 'main';
$route['api/user'] = 'main/user';
$route['api/user/(:any)'] = 'main/user/$1';
$route['api/games_on_auction'] = 'main/games_on_auction';
$route['api/karma_on_auction'] = 'main/karma_on_auction';
$route['api/started_games'] = 'main/started_games';
$route['api/finished_games'] = 'main/finished_games';
$route['api/leaderboard'] = 'main/leaderboard';
$route['api/leaderboard/(:any)'] = 'main/leaderboard/$1';
$route['api/leaderboard/(:any)/(:any)'] = 'main/leaderboard/$1/$2';
$route['api/leaderboard/(:any)/(:any)/(:any)'] = 'main/leaderboard/$1/$2/$3';
$route['api/leaderboard/(:any)/(:any)/(:any)/(:any)'] = 'main/leaderboard/$1/$2/$3/$4';
$route['api/single_game'] = 'main/single_game';
$route['api/single_game/(:any)'] = 'main/single_game/$1';
$route['api/single_karma'] = 'main/single_karma';
$route['api/single_karma/(:any)'] = 'main/single_karma/$1';

// API Paths Actions
$route['api/game/bid'] = 'game/bid';
$route['api/game/play'] = 'game/play';
$route['api/karma/bid'] = 'karma/bid';
$route['api/karma/give'] = 'karma/give';
$route['api/karma/sell'] = 'karma/sell';

// Cron
$route['cron/(:any)'] = "cron/index/$1";

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;