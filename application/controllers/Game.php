<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('main_model', '', TRUE);
        $this->load->model('user_model', '', TRUE);
        $this->load->model('game_model', '', TRUE);

        $this->main_model->record_request();
    }

    public function bid($game_key, $amount)
    {
        $user = $this->user_model->get_this_user();

        if (!$user) {
            echo api_error_response('user_auth', 'You must be logged in or authenticated with the API to take this action.');
            return false;
        }

        if (!ctype_digit($game_key) || $game_key < 0) {
            echo api_error_response('game_id_not_positive_int', 'Your game id was not a positive int.');
            return false;
        }

        if (!ctype_digit($amount)) {
            echo api_error_response('game_bid_amount_not_int', 'Your bid amount was not an int.');
            return false;
        }

        if ($amount > 100 || $amount < -100) {
            echo api_error_response('game_bid_amount_out_of_range', 'Your bid amount was not between -100 and 100.');
            return false;
        }

        $game = $this->game_model->get_game_by_id($game_key);

        if (empty($game)) {
            echo api_error_response('game_bid_amount_out_of_range', 'Game with that id was not found.');
            return false;
        }

        $game_bid = $this->game_model->get_bid_by_game_and_user_key($game['id'], $user['id']);

        if (!empty($game_bid)) {
            echo api_error_response('game_bid_already_exists', 'You already have a bid for this game.');
            return false;
        }

        $bids_in_last_day = $this->game_model->get_bids_by_user_in_last_day($user['id']);

        if (count($bids_in_last_day) >= MAX_GAME_BIDS) {
            echo api_error_response('global_maximum_game_bids', 'You have reached the global limit of ' . MAX_GAME_BIDS . ' bids in a day.');
            return false;
        }

        $user_bid_limit = MAX_GAME_BIDS;
        if ($user['score'] < 0) {
            $user_bid_limit = MAX_GAME_BIDS - $user['score'];
        }
        if ($user_bid_limit < MIN_GAME_BIDS) {
            $user_bid_limit = MIN_GAME_BIDS;
        }
        
        if (count($bids_in_last_day) >= $user_bid_limit) {
            echo api_error_response('user_maximum_game_bids', 'Your score is negative and you\'ve reached your limit of ' . $user_bid_limit . ' bids in a day. As your score rises, you\'ll be able to make more bids.');
            return false;
        }

        $this->game_model->insert_bid($game_key, $user['id'], $amount);

        echo api_response();
    }

}
