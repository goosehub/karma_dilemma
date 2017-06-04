<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karma extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('main_model', '', TRUE);
        $this->load->model('user_model', '', TRUE);
        $this->load->model('karma_model', '', TRUE);

        $this->main_model->record_request();
    }

    public function bid()
    {
        $user = $this->user_model->get_this_user();

        if (!$user) {
            echo api_error_response('user_auth', 'You must be logged in or authenticated with the API to take this action.');
            return false;
        }

        $input = get_json_post(true);

        if (!is_int($input->karma_id) || $input->karma_id < 0) {
            echo api_error_response('karma_id_not_positive_int', 'Your karma id was not a positive int.');
            return false;
        }

        if (!is_int($input->amount)) {
            echo api_error_response('game_bid_amount_not_int', 'Your bid amount was not an int.');
            return false;
        }

        if ($input->amount > 100 || $input->amount < -100) {
            echo api_error_response('game_bid_amount_out_of_range', 'Your bid amount was not between -100 and 100.');
            return false;
        }

        $karma = $this->karma_model->get_karma_by_id($input->karma_id);

        if (empty($karma)) {
            echo api_error_response('karma_bid_amount_out_of_range', 'Karma with that id was not found.');
            return false;
        }

        if ($karma['sold_flag']) {
            echo api_error_response('karma_auction_has_ended', 'Karma auction has ended.');
            return false;
        }

        $karma_bid = $this->karma_model->get_highest_bid_on_karma($karma['id']);

        if ($input->amount <= $karma_bid['amount']) {
            echo api_error_response('higher_karma_bid_exists', 'A higher bid for this karma exists.');
            return false;
        }

        $bids_in_last_day = $this->karma_model->get_karma_bids_by_user_in_last_day($user['id']);

        if (count($bids_in_last_day) >= MAX_KARMA_BIDS) {
            echo api_error_response('global_maximum_karma_bids', 'You have reached the global limit of ' . MAX_KARMA_BIDS . ' bids in a day.');
            return false;
        }

        $user_bid_limit = MAX_KARMA_BIDS;
        if ($user['score'] < 0) {
            $user_bid_limit = MAX_KARMA_BIDS - $user['score'];
        }
        if ($user_bid_limit < MIN_KARMA_BIDS) {
            $user_bid_limit = MIN_KARMA_BIDS;
        }
        
        if (count($bids_in_last_day) >= $user_bid_limit) {
            echo api_error_response('user_maximum_karma_bids', 'Your score is negative and you\'ve reached your limit of ' . $user_bid_limit . ' karma bids in a day. As your score rises, you\'ll be able to make more bids.');
            return false;
        }

        $this->karma_model->insert_karma_bid($input->karma_id, $user['id'], $input->amount);

        echo api_response();
    }

    public function give()
    {
        $user = $this->user_model->get_this_user();

        if (!$user) {
            echo api_error_response('user_auth', 'You must be logged in or authenticated with the API to take this action.');
            return false;
        }

        $input = get_json_post(true);

        if (!is_int($input->other_player_user_id) || $input->other_player_user_id < 0) {
            echo api_error_response('other_player_user_id_not_positive_int', 'Other player user id was not a positive int.');
            return false;
        }

        if ($input->type != 0 && $input->type != 1) {
            echo api_error_response('game_choice_out_of_range', 'Your choice must be 0 or 1.');
            return false;
        }

        if ($input->type) {
            if ($user['owned_positive_karma'] < 1) {
                echo api_error_response('not_enough_positive_karma', 'You do not have any positive karma to give.');
                return false;
            }
        }
        else {
            if ($user['owned_negative_karma'] < 1) {
                echo api_error_response('not_enough_negative_karma', 'You do not have any negative karma to give.');
                return false;
            }
        }

        $this->karma_model->update_user_karma_owned($input->other_player_user_id, $input->type, 1, true);
        $this->karma_model->update_user_karma_owned($user['id'], $input->type, 1, false);
        $this->karma_model->update_user_karma($input->other_player_user_id, $input->type, 1);

        echo api_response();
    }

    function sell()
    {
        $user = $this->user_model->get_this_user();

        if (!$user) {
            echo api_error_response('user_auth', 'You must be logged in or authenticated with the API to take this action.');
            return false;
        }

        $input = get_json_post(true);

        if ($input->type != 0 && $input->type != 1) {
            echo api_error_response('game_choice_out_of_range', 'Your choice must be 0 or 1.');
            return false;
        }

        if ($input->type) {
            if ($user['owned_positive_karma'] < 1) {
                echo api_error_response('not_enough_positive_karma', 'You do not have any positive karma to give.');
                return false;
            }
        }
        else {
            if ($user['owned_negative_karma'] < 1) {
                echo api_error_response('not_enough_negative_karma', 'You do not have any negative karma to give.');
                return false;
            }
        }

        $this->karma_model->update_user_karma_owned($user['id'], $input->type, 1, false);
        $this->karma_model->insert_karma($input->type, $user['id']);

        echo api_response();

    }

}
