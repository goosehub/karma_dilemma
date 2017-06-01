<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('main_model', '', TRUE);
        $this->load->model('game_model', '', TRUE);
        
        $this->main_model->record_request();
    }

    // Map view
    public function index($token = false)
    {
        // Use hash equals function to prevent timing attack
        $auth = auth();
        if (!$token) {
            return false;
        }
        if (!hash_equals($auth->token, $token)) {
            return false;
        }

        echo 'Start of Cron - ' . time() . '<br>';
        $this->create_games();
        $this->start_games()
        $this->finish_games()
        echo 'End of Cron - ' . time() . '<br>';
    }

    public function create_games()
    {
        // Check if it's time to run
        $crontab = '* * * * *'; // Every minute
        $now = date('Y-m-d H:i:s');
        $run_crontab = parse_crontab($now, $crontab);
        if (!$run_crontab) {
            return false;
        }

        // Create games
        echo 'Create Games - ' . time() . '<br>';
        $games_to_create = 1;
        for ($i = 0; $i < $games_to_create; $i++) {
            echo '<hr> Creating game and payoffs - ' . time() . '<br>';
            $game_key = $this->game_model->insert_game();
            $a_action = 0;
            $b_action = 0;
            $this->create_payoff($game_key, $a_action, $b_action);
            $a_action = 1;
            $b_action = 0;
            $this->create_payoff($game_key, $a_action, $b_action);
            $a_action = 0;
            $b_action = 1;
            $this->create_payoff($game_key, $a_action, $b_action);
            $a_action = 1;
            $b_action = 1;
            $this->create_payoff($game_key, $a_action, $b_action);
        }
    }

    public function start_games()
    {
        // Check if it's time to run
        $crontab = '* * * * *'; // Every minute
        $now = date('Y-m-d H:i:s');
        $run_crontab = parse_crontab($now, $crontab);
        if (!$run_crontab) {
            return false;
        }
    }

    public function finish_games()
    {
        // Check if it's time to run
        $crontab = '* * * * *'; // Every minute
        $now = date('Y-m-d H:i:s');
        $run_crontab = parse_crontab($now, $crontab);
        if (!$run_crontab) {
            return false;
        }
    }

    public function create_payoff($game_key, $a_action, $b_action)
    {
        $payoff_min_base = -10;
        $payoff_max_base = 10;
        $payoff_multiplier = 10;
        $a_payoff = rand($payoff_min_base, $payoff_max_base) * $payoff_multiplier;
        $b_payoff = rand($payoff_min_base, $payoff_max_base) * $payoff_multiplier;
        $this->game_model->insert_payoff($game_key, $a_payoff, $b_payoff, $a_action, $b_action);
        echo $a_action . ' ' . $a_payoff . '<br>';
        echo $b_action . ' ' . $b_payoff . '<br>';
        echo '<hr>';
    }

}