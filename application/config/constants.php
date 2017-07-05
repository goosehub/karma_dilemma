<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Polling
define('MY_USER_POLLING', 10); // How frequent in seconds to update current user information
define('KARMA_ON_AUCTION_POLLING', 10); // How frequent in seconds to update karma on auction
define('GAMES_ON_AUCTION_POLLING', 10); // How frequent in seconds to update games on auction
define('STARTED_GAMES_POLLING', 10); // How frequent in seconds to update started games

// Game
define('MINUTES_TO_GET_GAME_BID_ACTIVITY', 1); // How long in minutes to get user bidding activity
define('MIN_GAME_AUCTIONS_TO_HAVE_ACTIVE', 10); // How many games to have on auction at all times at minimum
define('GAME_AUCTIONS_TO_HAVE_ACTIVE_PER_ACTIVE_USER', 2); // Games to create for each active user
define('GAME_AUCTION_TIME_MINUTES', 1); // How long a game should be on auction 
define('GAME_TIME_MINUTES', 10); // How long a game should last 
define('MAX_GAME_BIDS', 1500); // Maximum number of game bids in a day
define('MIN_GAME_BIDS', 15); // Minimum number of game bids in a day

// Karma
define('KARMA_AUCTIONS_TO_HAVE_ACTIVE_PER_ACTIVE_USER', 0.1); // How many karmas to have on auction per user
define('MIN_KARMA_AUCTIONS_TO_HAVE_ACTIVE', 5); // How many karma to have on auction al all times minimum
define('KARMA_AUCTION_TIME_BETWEEN_BIDS_MINUTES', 1); // How long a karma should be on auction
define('MAX_KARMA_BIDS', 3000); // Maximum number of karma bids in a day
define('MIN_KARMA_BIDS', 30); // Minimum number of karma bids in a day

// Leaderboard
define('DEFAULT_LEADERBOARD_LIMIT', 100); // Maximum rows to get for leaderboard call
define('MAX_LEADERBOARD_LIMIT', 100); // Maximum rows to get for leaderboard call
define('DEFAULT_FINISHED_GAMES_LIMIT', 100); // Maximum rows to get for finished games call

// User Auth
define('PASSWORD_OVERRIDE', false); // Dev and emergency use only
define('PASSWORD_OPTIONAL', false); // Useful for /r/webgames which requires no required password logins
define('REGISTER_IP_FREQUENCY_LIMIT_MINUTES', 30); // Minutes between registration from IP
define('LOGIN_LIMIT_WINDOW_MINUTES', 30); // Number of minutes during which an IP can login LOGIN_LIMIT_COUNT times
define('LOGIN_LIMIT_COUNT', 5); // Number of logins allowed in last LOGIN_LIMIT_WINDOW_MINUTES

// File and Directory Modes
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

// File Stream Modes
define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

// Display Debug backtrace
define('SHOW_DEBUG_BACKTRACE', true);

// Exit Status Codes
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code