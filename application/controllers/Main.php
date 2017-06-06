<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('main_model', '', TRUE);
        $this->load->model('user_model', '', TRUE);
        $this->load->model('game_model', '', TRUE);
        $this->load->model('karma_model', '', TRUE);

        $this->main_model->record_request();
    }

    public function index()
    {
        // Authentication
        $data['user'] = $this->user_model->get_this_user();

        // Include api key in user array
        if ($data['user']) {
            $user_auth = $this->user_model->get_user_auth_by_id($data['user']['id']);
            $data['user']['api_key'] = $user_auth['api_key'];
        }

        // Return error for API
        if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
            echo api_error_response('no_api_path_provided', 'You did not include a path in your api call.');
            return false;
        }

        // A/B testing
        $ab_array = array('', '');
        $data['ab_test'] = $ab_array[array_rand($ab_array)];

        // Flashdata
        $data['validation_errors'] = $this->session->flashdata('validation_errors');
        $data['failed_form'] = $this->session->flashdata('failed_form');
        $data['just_registered'] = $this->session->flashdata('just_registered');

        // Load view
        $data['page_title'] = site_name();
        $this->load->view('templates/header', $data);
        $this->load->view('main', $data);
        $this->load->view('templates/footer', $data);
    }

    public function games_on_auction()
    {
        $data['user'] = $this->user_model->get_this_user();

        $data['games_on_auction'] = $this->game_model->get_games_by_status($started_flag = false, $finished_flag = false);
        foreach ($data['games_on_auction'] as &$game)
        {
            $game['payoffs'] = $this->game_model->get_payoff_by_game_key($game['id']);

            $game['has_bid_by_you'] = false;
            if ($data['user']) {
                $game['has_bid_by_you'] = $this->game_model->get_bid_by_game_and_user_key($game['id'], $data['user']['id']) ? true : false;
            }
        }

        // Return here for API
        if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
            unset($data['user']);
            echo api_response($data);
            return false;
        }

        // Load view
        $data['page_title'] = 'Games on Auction';
        $this->load->view('templates/header', $data);
        $this->load->view('games_on_auction', $data);
        $this->load->view('templates/footer', $data);
    }

    public function started_games()
    {
        $data['user'] = $this->user_model->get_this_user();
        if (!$data['user']) {
            $this->output->set_status_header(401);
            echo 'Must be logged in';
            return false;
        }

        $data['started_games'] = $this->game_model->get_games_by_status_and_user_key(true, false, $data['user']['id']);
        foreach ($data['started_games'] as $key => &$game) {

            // Keep current choices private
            unset($game['primary_choice']);
            unset($game['secondary_choice']);

            // Detect which choices have been submitted
            $game['primary_choice_made'] = $game['secondary_choice_made'] = false;
            if ($game['start_timestamp'] < $game['primary_choice_timestamp']) {
                $game['primary_choice_made'] = true;
            }
            if ($game['start_timestamp'] < $game['secondary_choice_timestamp']) {
                $game['secondary_choice_made'] = true;
            }

            // Get payoffs
            $game['payoffs'] = $this->game_model->get_payoff_by_game_key($game['id']);

            // Logic depending on if current user is primary or secondary
            if ($game['primary_user_key'] === $data['user']['id']) {
                // Bool for if user already made a choice
                $game['your_choice_made'] = $game['other_player_choice_made'] = false;
                if ($game['primary_choice_made']) {
                    $game['your_choice_made'] = true;
                }
                if ($game['secondary_choice_made']) {
                    $game['other_player_choice_made'] = true;
                }

                // Get users
                $game['primary_player'] = $data['user'];
                $game['secondary_player'] = $this->user_model->get_user_extended_by_id($game['secondary_user_key']);

                // Set other player for easier view logic and api
                $game['your_player_type'] = 1;
                $game['other_player'] = $game['secondary_player'];
            }
            else {
                // Bool for if user already made a choice
                $game['your_choice_made'] = $game['other_player_choice_made'] = false;
                if ($game['primary_choice_made']) {
                    $game['other_player_choice_made'] = true;
                }
                if ($game['secondary_choice_made']) {
                    $game['your_choice_made'] = true;
                }

                // Get users
                $game['primary_player'] = $this->user_model->get_user_extended_by_id($game['primary_user_key']);
                $game['secondary_player'] = $data['user'];

                // Set other player for easier view logic and api
                $game['your_player_type'] = 0;
                $game['other_player'] = $game['primary_player'];
            }
        }

        // Return here for API
        if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
            unset($data['user']);
            echo api_response($data);
            return false;
        }

        // Load view
        $data['page_title'] = 'Started Games';
        $this->load->view('templates/header', $data);
        $this->load->view('started_games', $data);
        $this->load->view('templates/footer', $data);
    }

    public function finished_games($limit = DEFAULT_FINISHED_GAMES_LIMIT, $offset = 0)
    {
        $data['user'] = $this->user_model->get_this_user();
        if (!$data['user']) {
            $this->output->set_status_header(401);
            echo 'Must be logged in';
            return false;
        }

        $data['finished_games'] = $this->game_model->get_games_by_status_and_user_key(true, true, $data['user']['id'], $limit, $offset);
        foreach ($data['finished_games'] as $key => &$game) {
            // Get payoffs
            $game['payoffs'] = $this->game_model->get_payoff_by_game_key($game['id']);

            // Choosen payoff flag
            foreach ($game['payoffs'] as $key => &$payoff) {
                $payoff['choosen_payoff'] = false;
                if ($game['primary_choice'] === $payoff['primary_choice'] && $game['secondary_choice'] === $payoff['secondary_choice']) {
                    $payoff['choosen_payoff'] = true;
                }
            }

            // Logic depending on if current user is primary or secondary
            if ($game['primary_user_key'] === $data['user']['id']) {
                // Get users
                $game['primary_player'] = $data['user'];
                $game['secondary_player'] = $this->user_model->get_user_extended_by_id($game['secondary_user_key']);

                // Set utility variables for easier view logic and api
                $game['your_player_type'] = 0;
                $game['other_player_type'] = 1;
                $game['other_player'] = $game['secondary_player'];
            }
            else {
                // Get users
                $game['primary_player'] = $this->user_model->get_user_extended_by_id($game['primary_user_key']);
                $game['secondary_player'] = $data['user'];

                // Set utility variables for easier view logic and api
                $game['your_player_type'] = 1;
                $game['other_player_type'] = 0;
                $game['other_player'] = $game['primary_player'];
            }
        }

        // Return here for API
        if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
            unset($data['user']);
            echo api_response($data);
            return false;
        }

        // Load view
        $data['page_title'] = 'Finished Games';
        $this->load->view('templates/header', $data);
        $this->load->view('finished_games', $data);
        $this->load->view('templates/footer', $data);
    }

    public function karma_on_auction()
    {
        $data['user'] = $this->user_model->get_this_user();

        $data['karma_on_auction'] = $this->karma_model->get_karma_on_auction();
        foreach ($data['karma_on_auction'] as &$karma) {
            $karma['bids'] = $this->karma_model->get_bids_by_karma($karma['id']);
            $karma['highest_bid'] = isset($karma['bids'][0]['amount']) ? (int) $karma['bids'][0]['amount'] : 0;
        }

        // Return here for API
        if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
            unset($data['user']);
            echo api_response($data);
            return false;
        }

        // Load view
        $data['page_title'] = 'Karma on Auction';
        $this->load->view('templates/header', $data);
        $this->load->view('karma_on_auction', $data);
        $this->load->view('templates/footer', $data);
    }

    public function leaderboard($column = 'score', $sort = 'DESC', $limit = DEFAULT_LEADERBOARD_LIMIT, $offset = 0)
    {
        $data['column'] = $column;
        $data['sort'] = $sort;
        $data['limit'] = $limit;
        $data['offset'] = $offset;

        if ($limit > MAX_LEADERBOARD_LIMIT) {
            echo api_error_response('leaderboard_limit_too_high', 'Your limit parameter must be ' . MAX_LEADERBOARD_LIMIT . ' or less.');
            return false;
        }

        // Get leaders
        $data['leaders'] = $this->game_model->get_leaderboard($column, $sort, $limit, $offset);

        $rank = 1;
        foreach ($data['leaders'] as &$leader) {
            $leader['rank'] = $rank;
            $rank++;
        }

        // Return here for API
        if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
            echo api_response($data);
            return false;
        }

        // Load view
        $data['page_title'] = site_name();
        $this->load->view('templates/header', $data);
        $this->load->view('leaderboard', $data);
        $this->load->view('templates/footer', $data);
    }

    public function single_game($game_id = false)
    {
        $data['user'] = $this->user_model->get_this_user();

        if (!$game_id) {
            echo api_error_response('game_id_missing', 'Game id is a required parameter and was not provided.');
            return false;
        }

        $game_id = (int) $game_id;
        if (!is_int($game_id) || $game_id < 1) {
            echo api_error_response('game_id_not_positive_int', 'Your game id was not a positive int.');
            return false;
        }

        $data['game'] = $this->game_model->get_game_by_id($game_id);

        if (empty($data['game'])) {
            echo api_error_response('game_not_found', 'Game with that id was not found.');
            return false;
        }

        if ($data['game']['started_flag'] && $data['game']['primary_user_key'] != $data['user']['id'] && $data['game']['secondary_user_key'] != $data['user']['id']) {
            echo api_error_response('game_is_started_and_is_not_yours', 'You can not get games that are started and are not yours.');
            return false;
        }

        $data['game']['payoffs'] = $this->game_model->get_payoff_by_game_key($data['game']['id']);

        if ($data['game']['finished_flag']) {
            foreach ($data['game']['payoffs'] as $key => &$payoff) {
                $payoff['choosen_payoff'] = false;
                if ($data['game']['primary_choice'] === $payoff['primary_choice'] && $data['game']['secondary_choice'] === $payoff['secondary_choice']) {
                    $payoff['choosen_payoff'] = true;
                }
            }
        }

        if ($data['game']['primary_user_key'] === $data['user']['id']) {
            $data['game']['primary_player'] = $data['user'];
            $data['game']['secondary_player'] = $this->user_model->get_user_extended_by_id($data['game']['secondary_user_key']);
        }
        else {
            $data['game']['primary_player'] = $this->user_model->get_user_extended_by_id($data['game']['primary_user_key']);
            $data['game']['secondary_player'] = $data['user'];
        }

        // Return here for API
        if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
            unset($data['user']);
            echo api_response($data);
            return false;
        }
    }

    public function single_karma($karma_id = false)
    {
        if (!$karma_id) {
            echo api_error_response('karma_id_missing', 'Karma id is a required parameter and was not provided.');
            return false;
        }

        $karma_id = (int) $karma_id;
        if (!is_int($karma_id) || $karma_id < 1) {
            echo api_error_response('karma_id_not_positive_int', 'Your karma id was not a positive int.');
            return false;
        }

        $data['karma'] = $this->karma_model->get_karma_by_id($karma_id);
        $data['karma']['bids'] = $this->karma_model->get_bids_by_karma($data['karma']['id']);
        $data['karma']['highest_bid'] = isset($data['karma']['bids'][0]['amount']) ? (int) $data['karma']['bids'][0]['amount'] : 0;

        if (empty($data['karma'])) {
            echo api_error_response('karma_not_found', 'Karma with that id was not found.');
            return false;
        }

        // Return here for API
        if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
            unset($data['user']);
            echo api_response($data);
            return false;
        }
    }

    public function user($user_id = false)
    {
        $user_id = (int) $user_id;
        if ($user_id) {
            if (!is_int($user_id) || $user_id < 1) {
                echo api_error_response('user_id_not_positive_int', 'Your user id was not a positive int.');
                return false;
            }

            $data['user'] = $this->user_model->get_user_extended_by_id($user_id);
            if (!$data['user']) {
                echo api_error_response('user_not_found', 'User not found.');
            }
        }
        else {
            $data['user'] = $this->user_model->get_this_user();
            if (!$data['user']) {
                echo api_error_response('user_auth', 'You must be logged in or authenticated with the API to take this action.');
            }
        }

        // Return here for API
        if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
            echo api_response($data);
            return false;
        }

        // Load view
        $data['page_title'] = $data['user']['username'];
        $this->load->view('templates/header', $data);
        $this->load->view('user', $data);
        $this->load->view('templates/footer', $data);
    }

    public function api_docs()
    {
        // Authentication
        $data['user'] = $this->user_model->get_this_user();

        // Include api key in user array
        if ($data['user']) {
            $user_auth = $this->user_model->get_user_auth_by_id($data['user']['id']);
            $data['user']['api_key'] = $user_auth['api_key'];
        }

        // Return error for API
        if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
            echo api_error_response('not_a_valid_api_path', 'This is not a supported api path.');
            return false;
        }

        // Load view
        $data['page_title'] = site_name();
        $this->load->view('templates/header', $data);
        $this->load->view('api_docs', $data);
        $this->load->view('templates/footer', $data);
    }
}
