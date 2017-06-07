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

        echo '<h1>Start of Cron - ' . time() . '</h1>';
        $this->finish_games_on_time_expired();
        $this->start_games();
        $this->create_games();
        $this->finish_karma_auctions();
        $this->create_karma();
        echo '<h1>End of Cron - ' . time() . '</h1>';
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
        echo '<h2>Create Games - ' . time() . '</h2>';

        // Create games based on users currently bidding
        $count_of_users_currently_bidding = $this->game_model->get_count_of_users_currently_bidding(MINUTES_TO_GET_GAME_BID_ACTIVITY);

        // Get count of games currently on auction
        $count_of_games_on_auction = $this->game_model->count_games_by_status($started_flag = false, $finished_flag = false);

        // Create games we want to have on auction
        $games_to_create = floor(GAME_AUCTIONS_TO_HAVE_ACTIVE_PER_ACTIVE_USER * $count_of_users_currently_bidding) - $count_of_games_on_auction;

        // Minimum of games to have on auction
        if ($count_of_games_on_auction < MIN_GAME_AUCTIONS_TO_HAVE_ACTIVE) {
            $games_to_create = MIN_GAME_AUCTIONS_TO_HAVE_ACTIVE - $count_of_games_on_auction;
        }

        for ($i = 0; $i < $games_to_create; $i++) {
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

            echo '<hr> Game Created - ' . time() . '<br>';
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
        echo '<h2>Start Games - ' . time() . '</h2>';

        // Get games to start
        $games = $this->game_model->get_games_by_status_and_age($started = false, $finished = false, GAME_AUCTION_TIME_MINUTES);

        foreach ($games as $game) {
            $bids = $this->game_model->get_bid_by_game_key($game['id']);

            // Not enough bidders
            if (count($bids) < 2) {
                continue;
            }

            // Sort and set data
            $sorted_bids = sort_array($bids, 'amount', SORT_ASC);
            $bid_count = count($bids);
            $two_thirds_median_bid_index = ceil($bid_count * 0.33);
            $primary_user_key = $sorted_bids[0]['user_key'];
            $primary_user_bid = $sorted_bids[0]['amount'];
            $secondary_user_key = $sorted_bids[$two_thirds_median_bid_index]['user_key'];
            $secondary_user_bid = $sorted_bids[$two_thirds_median_bid_index]['amount'];

            // Update user scores
            $this->game_model->update_user_score($primary_user_key, $primary_user_bid, true);
            $this->game_model->update_user_score($secondary_user_key, $secondary_user_bid, true);

            // Start game
            $this->game_model->start_game($game['id'], $primary_user_key, $secondary_user_key);

            echo 'Game Started - ' . time() . '<br>';
        }
    }

    public function finish_games_on_time_expired()
    {
        // Check if it's time to run
        $crontab = '* * * * *'; // Every minute
        $now = date('Y-m-d H:i:s');
        $run_crontab = parse_crontab($now, $crontab);
        if (!$run_crontab) {
            return false;
        }
        echo '<h2>Finish Games - ' . time() . '</h2>';

        // Get games to finish
        $games = $this->game_model->get_games_by_status_and_age($started = true, $finished = false, GAME_TIME_MINUTES);

        foreach ($games as $game) {
            // Get payoff
            $payoff = $this->game_model->get_game_payoff_by_choices_and_game_key($game['primary_choice'], $game['secondary_choice'], $game['id']);

            // Update user scores
            $this->game_model->update_user_score($game['primary_user_key'], $payoff['primary_payoff'], true);
            $this->game_model->update_user_score($game['secondary_user_key'], $payoff['secondary_payoff'], true);

            // Finish game
            $this->game_model->finish_game($game['id']);

            echo 'Game Finished - ' . time() . '<br>';
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
        echo '<h2>Create Karma - ' . time() . '</h2>';

        // Create games based on users currently bidding
        $count_of_users_currently_bidding = $this->game_model->get_count_of_users_currently_bidding(MINUTES_TO_GET_GAME_BID_ACTIVITY);

        // Get count of games currently on auction
        $count_of_games_on_auction = $this->game_model->count_games_by_status($started_flag = false, $finished_flag = false);

        // Get count of karma on auction
        $count_of_karma_on_auction = $this->karma_model->count_of_karma_on_auction();

        // Create games we want to have on auction
        $karma_to_create = floor(KARMA_AUCTIONS_TO_HAVE_ACTIVE_PER_ACTIVE_USER * $count_of_users_currently_bidding) - $count_of_games_on_auction;

        // Minimum of games to have on auction
        if ($count_of_karma_on_auction < MIN_KARMA_AUCTIONS_TO_HAVE_ACTIVE) {
            $karma_to_create = MIN_KARMA_AUCTIONS_TO_HAVE_ACTIVE - $count_of_karma_on_auction;
        }

        // Loop to create karma
        for ($i = 0; $i < $karma_to_create; $i++) {
            // Random Type
            $karma_type = rand(0,1);

            // Create Karma
            $this->karma_model->insert_karma($karma_type, $seller_user_key = 0);

            echo 'Karma Created - ' . time() . '<br>';
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
        echo '<h2>Finish Karma Auctions - ' . time() . '</h2>';

        // Get all karma on auction
        $karma_on_auction = $this->karma_model->get_karma_on_auction();

        // Foreach Karma
        foreach ($karma_on_auction as $karma) {

            // Get highest bid
            $karma_bid = $this->karma_model->get_highest_bid_on_karma($karma['id']);
            if (!$karma_bid) {
                continue;
            }

            // If time since last bid is long enough
            if (strtotime($karma_bid['created']) < time() - 60 * KARMA_AUCTION_TIME_BETWEEN_BIDS_MINUTES) {
                echo 'Finish Karma Auction - ' . time() . '<br>';

                // Subtract payment
                $this->game_model->update_user_score($karma_bid['user_key'], $karma_bid['amount'], false);

                // Add karma
                $this->karma_model->update_user_karma_available($karma_bid['user_key'], $karma['type'], 1, true);

                // Add payment to seller if exists
                if ($karma['seller_user_key']) {
                    $this->game_model->update_user_score($karma['seller_user_key'], $karma_bid['amount'], true);
                }

                // Finish auction
                $this->karma_model->finish_karma_auction($karma['id'], $karma_bid['user_key']);
            
                echo 'Karma Auction Created - ' . time() . '<br>';
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