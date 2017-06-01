<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('main_model', '', TRUE);
        $this->load->model('user_model', '', TRUE);
        $this->load->model('game_model', '', TRUE);

        $this->main_model->record_request();
    }

    public function index()
    {
        // Authentication
        $data['user'] = $this->user_model->get_this_user();

        // Include api key
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
        $data['games_on_auction'] = $this->game_model->get_games_on_auction();
        foreach ($data['games_on_auction'] as &$game)
        {
            $game['payoffs'] = $this->game_model->get_payoff_by_game_key($game['id']);
        }

        // Return here for API
        if ($this->input->get('api')) {
            echo api_response($data);
            return false;
        }

        $data['user'] = $this->user_model->get_this_user();

        // Load view
        $data['page_title'] = 'Games on Auction';
        $this->load->view('templates/header', $data);
        $this->load->view('games_on_auction', $data);
        $this->load->view('templates/footer', $data);
    }

    public function api_docs()
    {
        // Authentication
        $data['user'] = $this->user_model->get_this_user();

        // Include api key
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
