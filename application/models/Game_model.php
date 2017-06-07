<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// echo '<br>' . $this->db->last_query() . '<br>';

Class game_model extends CI_Model
{
    function insert_game()
    {
        $data = array(
            'started_flag' => 0,
            'finished_flag' => 0,
            'primary_user_key' => 0,
            'secondary_user_key' => 0,
            'primary_choice' => 0,
            'secondary_choice' => 0,
        );
        $this->db->insert('game', $data);
        return $this->db->insert_id();
    }
    function insert_payoff($game_key, $primary_payoff, $secondary_payoff, $primary_choice, $secondary_choice)
    {
        $data = array(
            'game_key' => $game_key,
            'primary_payoff' => $primary_payoff,
            'secondary_payoff' => $secondary_payoff,
            'primary_choice' => $primary_choice,
            'secondary_choice' => $secondary_choice,
        );
        $this->db->insert('payoff', $data);
        return $this->db->insert_id();
    }
    function get_game_by_id($game_key)
    {
        $this->db->select('*');
        $this->db->from('game');
        $this->db->where('id', $game_key);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }
    function get_payoff_by_game_key($game_key)
    {
        $this->db->select('*');
        $this->db->from('payoff');
        $this->db->where('game_key', $game_key);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function insert_game_bid($game_key, $user_key, $amount)
    {
        $data = array(
            'game_key' => $game_key,
            'user_key' => $user_key,
            'amount' => $amount,
        );
        $this->db->insert('game_bid', $data);
        return $this->db->insert_id();
    }
    function get_bid_by_game_key($game_key)
    {
        $this->db->select('*');
        $this->db->from('game_bid');
        $this->db->where('game_key', $game_key);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function get_bid_by_game_and_user_key($game_key, $user_key)
    {
        $this->db->select('*');
        $this->db->from('game_bid');
        $this->db->where('game_key', $game_key);
        $this->db->where('user_key', $user_key);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }
    function get_game_bids_by_user_in_last_day($user_key)
    {
        $this->db->select('*');
        $this->db->from('game_bid');
        $this->db->where('user_key', $user_key);
        $this->db->where('created >= DATE_SUB( NOW(), INTERVAL 24 HOUR )');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function get_games_by_status($started_flag, $finished_flag)
    {
        $this->db->select('*');
        $this->db->from('game');
        $this->db->where('started_flag', $started_flag);
        $this->db->where('finished_flag', $finished_flag);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function count_games_by_status($started_flag, $finished_flag)
    {
        $this->db->select('COUNT(*) as game_count');
        $this->db->from('game');
        $this->db->where('started_flag', $started_flag);
        $this->db->where('finished_flag', $finished_flag);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]['game_count']) ? $result[0]['game_count'] : 0;
    }
    function get_games_by_status_and_user_key($started_flag, $finished_flag, $user_key, $limit = 100, $offset = 0)
    {
        $this->db->select('*');
        $this->db->from('game');
        $this->db->where('started_flag', $started_flag);
        $this->db->where('finished_flag', $finished_flag);
        $this->db->where('(primary_user_key = ' . $user_key . ' OR secondary_user_key = ' . $user_key . ')');
        $this->db->limit($limit);
        $this->db->offset($offset);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function get_games_by_status_and_age($started_flag, $finished_flag, $minutes_ago)
    {
        $minutes_ago = (int) $minutes_ago;
        $this->db->select('*');
        $this->db->from('game');
        $this->db->where('started_flag', $started_flag);
        $this->db->where('finished_flag', $finished_flag);
        $this->db->where('created <= DATE_SUB( NOW(), INTERVAL ' . $minutes_ago . ' MINUTE )');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function start_game($game_key, $primary_user_key, $secondary_user_key)
    {
        $data = array(
            'started_flag' => true,
            'primary_user_key' => $primary_user_key,
            'secondary_user_key' => $secondary_user_key,
            'start_timestamp' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id', $game_key);
        $this->db->update('game', $data);
    }
    function finish_game($game_key)
    {
        $data = array(
            'finished_flag' => true,
        );
        $this->db->where('id', $game_key);
        $this->db->update('game', $data);
    }
    function update_game_primary_choice($game_key, $choice)
    {
        $data = array(
            'primary_choice' => $choice,
            'primary_choice_timestamp' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id', $game_key);
        $this->db->update('game', $data);
    }
    function update_game_secondary_choice($game_key, $choice)
    {
        $data = array(
            'secondary_choice' => $choice,
            'secondary_choice_timestamp' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id', $game_key);
        $this->db->update('game', $data);
    }
    function update_user_score($user_key, $score_change, $increment)
    {
        if ($increment) {
            $math_sign = '+';
        }
        else {
            $math_sign = '-';
        }
        $this->db->set('score', 'score' . $math_sign . $score_change, FALSE);
        $this->db->where('id', $user_key);
        $this->db->update('user');
    }
    function get_game_payoff_by_choices_and_game_key($primary_choice, $secondary_choice, $game_key)
    {
        $this->db->select('*');
        $this->db->from('payoff');
        $this->db->where('primary_choice', $primary_choice);
        $this->db->where('secondary_choice', $secondary_choice);
        $this->db->where('game_key', $game_key);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }
    function get_count_of_users_currently_bidding($minutes_ago)
    {
        $minutes_ago = (int) $minutes_ago;
        $this->db->select('COUNT(*) as user_count');
        $this->db->from('game_bid');
        $this->db->where('created >', date('Y-m-d H:i:s', time() - ($minutes_ago * 60) ) );
        $this->db->group_by('user_key');
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]['user_count']) ? $result[0]['user_count'] : 0;
    }
    function get_leaderboard($column, $sort, $limit, $offset)
    {
        // Verify Column
        $user_columns = array(
            'id',
            'username',
            'avatar',
            'score',
            'available_good_karma',
            'available_bad_karma',
            'good_karma',
            'total_available_karma',
            'total_karma',
            'games_played',
            'last_load',
            'created',
        );
        if (!in_array($column, $user_columns)) {
            echo api_error_response('bad_leaderboard_column', 'Column provided was not valid.');
            exit();
        }

        // Verify Sort
        if (strtolower($sort) != 'asc' && strtolower($sort) != 'desc') {
            echo api_error_response('bad_leaderboard_sort', 'Leaderboard sort parameter must be asc or desc.');
            exit();
        }

        // Select user extended
        $this->db->select('
            user.id,
            user.username,
            user.avatar,
            user.score,
            (SELECT COUNT(*) FROM game WHERE game.primary_user_key = user.id OR game.secondary_user_key = user.id) AS games_played,
            user.available_good_karma,
            user.available_bad_karma,
            user.good_karma,
            user.bad_karma,
            SUM(user.available_good_karma + user.available_bad_karma) as total_available_karma,
            SUM(good_karma + bad_karma) as total_karma,
            user.last_load,
            user.created as created
        ');
        $this->db->from('user');
        $this->db->order_by($column, $sort);
        $this->db->limit($limit);
        $this->db->offset($offset);
        $this->db->group_by('id');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
}
?>
