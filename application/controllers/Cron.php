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
        // $this->finish_games();
        // $this->start_games();
        $this->create_games();
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
        echo 'Create Games - ' . time() . '<br>';

        $games_on_auction = $this->game_model->get_games_on_auction();

        // Create games
        $games_to_create = GAME_AUCTIONS_TO_HAVE_ACTIVE - count($games_on_auction);
        for ($i = 0; $i < $games_to_create; $i++) {
            echo '<hr> Creating game and payoffs - ' . time() . '<br>';
            $game_key = $this->game_model->insert_game();
            $primary_action = 0;
            $secondary_action = 0;
            $this->create_payoff($game_key, $primary_action, $secondary_action);
            $primary_action = 1;
            $secondary_action = 0;
            $this->create_payoff($game_key, $primary_action, $secondary_action);
            $primary_action = 0;
            $secondary_action = 1;
            $this->create_payoff($game_key, $primary_action, $secondary_action);
            $primary_action = 1;
            $secondary_action = 1;
            $this->create_payoff($game_key, $primary_action, $secondary_action);
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
        echo 'Start Games - ' . time() . '<br>';

        // Get games to start
        $games = $this->game_model->get_games_by_status_and_age($started = false, $finished = false, GAME_AUCTION_TIME_MINUTES);

        foreach ($games as $game) {
            $bids = $this->game_model->get_bid_by_game_key($game['id']);

            // Not enough bidders
            if (count($bids) < 2) {
                continue;
            }
            echo 'Starting Game - ' . time() . '<br>';

            $sorted_bids = sort_array($bids, 'amount');

            $bid_count = count($bids);
            $two_thirds_median_bid_index = ceil($bid_count * 0.33);
            $primary_player = $sorted_bids[0]['user_key'];
            $secondary_player = $sorted_bids[$two_thirds_median_bid_index]['user_key'];
/*            $highest_bid = array();
            $highest_bid['user_key'] = 0;
            $highest_bid['amount'] = 0;
            $bid_sum = 0;
            foreach ($bids as $bid) {
                $bid_sum += $bid['amount'];
                if ($bid['amount'] > $highest_bid['amount']) {
                    $highest_bid['user_key'] = $bid['user_key'];
                    $highest_bid['amount'] = $bid['amount'];
                }
            }
            $average_bid = $bid_sum / $
            $secondary_player = 0; // ?*/
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

    public function create_payoff($game_key, $primary_action, $secondary_action)
    {
        $payoff_min_base = -10;
        $payoff_max_base = 10;
        $payoff_multiplier = 10;
        $primary_payoff = rand($payoff_min_base, $payoff_max_base) * $payoff_multiplier;
        $secondary_payoff = rand($payoff_min_base, $payoff_max_base) * $payoff_multiplier;
        $this->game_model->insert_payoff($game_key, $primary_payoff, $secondary_payoff, $primary_action, $secondary_action);
        echo $primary_action . ' ' . $primary_payoff . '<br>';
        echo $secondary_action . ' ' . $secondary_payoff . '<br>';
        echo '<hr>';
    }

}