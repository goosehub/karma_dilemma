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
            'primary_action' => 0,
            'secondary_action' => 0,
        );
        $this->db->insert('game', $data);
        return $this->db->insert_id();
    }
    function insert_payoff($game_key, $primary_payoff, $secondary_payoff, $primary_action, $secondary_action)
    {
        $data = array(
            'game_key' => $game_key,
            'primary_payoff' => $primary_payoff,
            'secondary_payoff' => $secondary_payoff,
            'primary_action' => $primary_action,
            'secondary_action' => $secondary_action,
        );
        $this->db->insert('payoff', $data);
        return $this->db->insert_id();
    }
    function get_games_on_auction()
    {
        $this->db->select('*');
        $this->db->from('game');
        $this->db->where('started_flag', false);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
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
    function insert_bid($game_key, $user_key, $amount)
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
    function get_bids_by_user_in_last_day($user_key)
    {
        $this->db->select('*');
        $this->db->from('game_bid');
        $this->db->where('user_key', $user_key);
        $this->db->where('created >= DATE_SUB( NOW(), INTERVAL 24 HOUR )');
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
}
?>
