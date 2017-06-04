<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('main_model', '', TRUE);
        $this->load->model('game_model', '', TRUE);
        $this->load->model('karma_model', '', TRUE);
        
        $this->main_model->record_request();
    }

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
        // $this->create_games();
        $this->finish_karma_auctions();
        $this->create_karma();
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

        $games_on_auction = $this->game_model->get_games_by_status($started_flag = false, $finished_flag = false);

        // Create games
        $games_to_create = GAME_AUCTIONS_TO_HAVE_ACTIVE - count($games_on_auction);
        for ($i = 0; $i < $games_to_create; $i++) {
            echo '<hr> Creating game and payoffs - ' . time() . '<br>';

            // Create game
            $game_key = $this->game_model->insert_game();

            // Create payoffs
            $primary_choice = 0;
            $secondary_choice = 0;
            $this->create_payoff($game_key, $primary_choice, $secondary_choice);
            $primary_choice = 1;
            $secondary_choice = 0;
            $this->create_payoff($game_key, $primary_choice, $secondary_choice);
            $primary_choice = 0;
            $secondary_choice = 1;
            $this->create_payoff($game_key, $primary_choice, $secondary_choice);
            $primary_choice = 1;
            $secondary_choice = 1;
            $this->create_payoff($game_key, $primary_choice, $secondary_choice);
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

            // Sort and set data
            $sorted_bids = sort_array($bids, 'amount', SORT_ASC);
            $bid_count = count($bids);
            $two_thirds_median_bid_index = ceil($bid_count * 0.33);
            $primary_user_key = $sorted_bids[0]['user_key'];
            $primary_user_bid = $sorted_bids[0]['amount'];
            $secondary_user_key = $sorted_bids[$two_thirds_median_bid_index]['user_key'];
            $secondary_user_bid = $sorted_bids[$two_thirds_median_bid_index]['amount'];

            // Update user scores
            $this->game_model->update_user_score($primary_user_key, $primary_user_bid);
            $this->game_model->update_user_score($secondary_user_key, $secondary_user_bid);

            // Start game
            $this->game_model->start_game($game['id'], $primary_user_key, $secondary_user_key);
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
        echo 'Finish Games - ' . time() . '<br>';

        // Get games to finish
        $games = $this->game_model->get_games_by_status_and_age($started = true, $finished = false, GAME_TIME_MINUTES);

        foreach ($games as $game) {
            echo 'Finishing Game - ' . time() . '<br>';
            // Get payoff
            $payoff = $this->game_model->get_game_payoff_by_choices_and_game_key($game['primary_choice'], $game['secondary_choice'], $game['id']);

            // Update user scores
            $this->game_model->update_user_score($game['primary_user_key'], $payoff['primary_payoff']);
            $this->game_model->update_user_score($game['secondary_user_key'], $payoff['secondary_payoff']);

            // Finish game
            $this->game_model->finish_game($game['id']);
        }
    }

    public function create_karma()
    {
        // Check if it's time to run
        $crontab = '* * * * *'; // Every minute
        $now = date('Y-m-d H:i:s');
        $run_crontab = parse_crontab($now, $crontab);
        if (!$run_crontab) {
            return false;
        }
        echo 'Create Karma - ' . time() . '<br>';

        $karma_on_auction = $this->karma_model->get_karma_on_auction();

        $karma_to_create = KARMA_AUCTIONS_TO_HAVE_ACTIVE - count($karma_on_auction);
        for ($i = 0; $i < $karma_to_create; $i++) {
            $karma_type = rand(0,1);
            $this->karma_model->insert_karma($karma_type);
        }
    }

    public function finish_karma_auctions()
    {
        // Check if it's time to run
        $crontab = '* * * * *'; // Every minute
        $now = date('Y-m-d H:i:s');
        $run_crontab = parse_crontab($now, $crontab);
        if (!$run_crontab) {
            return false;
        }
        echo 'Finish Karma Auctions - ' . time() . '<br>';

        $karma_on_auction = $this->karma_model->get_karma_on_auction();

        foreach ($karma_on_auction as $karma) {
            $karma_bid = $this->karma_model->get_highest_bid_on_karma($karma['id']);
            if ($karma_bid['created'] < date('Y-m-d H:i:s', time() - 60 * KARMA_AUCTION_TIME_BETWEEN_BIDS_MINUTES)) {
                $this->karma_model->finish_karma_auction($karma['id'], $karma_bid['user_key']);
                $this->karma_model->update_user_karma_owned($karma_bid['user_key'], $karma['type'], 1);
            }
        }
        
    }

    public function create_payoff($game_key, $primary_choice, $secondary_choice)
    {
        $payoff_min_base = -10;
        $payoff_max_base = 10;
        $payoff_multiplier = 10;
        $primary_payoff = rand($payoff_min_base, $payoff_max_base) * $payoff_multiplier;
        $secondary_payoff = rand($payoff_min_base, $payoff_max_base) * $payoff_multiplier;
        $this->game_model->insert_payoff($game_key, $primary_payoff, $secondary_payoff, $primary_choice, $secondary_choice);
        echo $primary_choice . ' ' . $primary_payoff . '<br>';
        echo $secondary_choice . ' ' . $secondary_payoff . '<br>';
        echo '<hr>';
    }

}