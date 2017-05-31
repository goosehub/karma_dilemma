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
            'a_user_key' => 0,
            'b_user_key' => 0,
            'a_action' => 0,
            'b_action' => 0,
        );
        $this->db->insert('game', $data);
        return $this->db->insert_id();
    }
    function insert_payoff($game_key, $a_payoff, $b_payoff, $a_action, $b_action)
    {
        $data = array(
            'game_key' => $game_key,
            'a_payoff' => $a_payoff,
            'b_payoff' => $b_payoff,
            'a_action' => $a_action,
            'b_action' => $b_action,
        );
        $this->db->insert('payoff', $data);
        return $this->db->insert_id();
    }
}
?>
