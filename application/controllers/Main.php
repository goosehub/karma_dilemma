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

        // Return here for API
        if ($this->input->get('api')) {
            echo api_response($data);
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

            $game['has_bid'] = false;
            if ($data['user']) {
                $game['has_bid'] = $this->game_model->get_bid_by_game_and_user_key($game['id'], $data['user']['id']) ? true : false;
            }
        }

        // Return here for API
        if ($this->input->get('api')) {
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
            $game['payoffs'] = $this->game_model->get_payoff_by_game_key($game['id']);

            if ($game['primary_user_key'] === $data['user']['id']) {
                // Skip game if user already made a choice
                if ($game['start_timestamp'] < $game['primary_choice_timestamp']) {
                    unset($data['started_games'][$key]);
                    continue;
                }

                $game['primary_player'] = $data['user'];
                $game['secondary_player'] = $this->user_model->get_user_by_id($game['secondary_user_key']);
            }
            else {
                // Skip game if user already made a choice
                if ($game['start_timestamp'] < $game['secondary_choice_timestamp']) {
                    unset($data['started_games'][$key]);
                    continue;
                }

                $game['primary_player'] = $this->user_model->get_user_by_id($game['primary_user_key']);
                $game['secondary_player'] = $data['user'];
            }
        }

        $game['primary_player']['games_played'] = $this->game_model->count_games_by_status_and_user_key(true, true, $game['primary_player']['id']);
        $game['secondary_player']['games_played'] = $this->game_model->count_games_by_status_and_user_key(true, true, $game['secondary_player']['id']);


        // Return here for API
        if ($this->input->get('api')) {
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

    public function karma_on_auction()
    {
        $data['user'] = $this->user_model->get_this_user();

        $data['karma_on_auction'] = $this->karma_model->get_karma_on_auction();
        foreach ($data['karma_on_auction'] as &$karma) {
            $karma['bids'] = $this->karma_model->get_bids_by_karma($karma['id']);
        }

        // Return here for API
        if ($this->input->get('api')) {
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

    public function api_docs()
    {
        // Authentication
        $data['user'] = $this->user_model->get_this_user();

        // Include api key in user array
        if ($data['user']) {
            $user_auth = $this->user_model->get_user_auth_by_id($data['user']['id']);
            $data['user']['api_key'] = $user_auth['api_key'];
        }

        // Return here for API
        if ($this->input->get('api')) {
            echo api_response($data);
            return false;
        }

        // Load view
        $data['page_title'] = site_name();
        $this->load->view('templates/header', $data);
        $this->load->view('page/api_docs', $data);
        $this->load->view('templates/footer', $data);
    }
}
