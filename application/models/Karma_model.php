<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// echo '<br>' . $this->db->last_query() . '<br>';

Class karma_model extends CI_Model
{
    function insert_karma($type)
    {
        $data = array(
            'resale_flag' => 0,
            'sold_flag' => 0,
            'buyer_user_key' => 0,
            'seller_user_key' => 0,
            'type' => $type,
        );
        $this->db->insert('karma', $data);
        return $this->db->insert_id();
    }
    function get_karma_on_auction()
    {
        $this->db->select('*');
        $this->db->from('karma');
        $this->db->where('sold_flag', 0);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function get_bids_by_karma($karma_key)
    {
        $this->db->select('*');
        $this->db->from('karma_bid');
        $this->db->where('karma_key', $karma_key);
        $this->db->order_by('amount', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function get_highest_bid_on_karma($karma_key)
    {
        $this->db->select('*');
        $this->db->from('karma_bid');
        $this->db->where('karma_key', $karma_key);
        $this->db->order_by('amount', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : 0;
    }
    function get_karma_bids_by_user_in_last_day($user_key)
    {
        $this->db->select('*');
        $this->db->from('karma_bid');
        $this->db->where('user_key', $user_key);
        $this->db->where('created >= DATE_SUB( NOW(), INTERVAL 24 HOUR )');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function insert_karma_bid($karma_key, $user_key, $amount)
    {
        $data = array(
            'karma_key' => $karma_key,
            'user_key' => $user_key,
            'amount' => $amount,
        );
        $this->db->insert('karma_bid', $data);
        return $this->db->insert_id();
    }
    function get_karma_by_id($karma_key)
    { 
        $this->db->select('*');
        $this->db->from('karma');
        $this->db->where('id', $karma_key);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }
    function finish_karma_auction($karma_key, $user_key)
    {
        $data = array(
            'sold_flag' => 1,
            'buyer_user_key' => $user_key,
        );
        $this->db->where('id', $karma_key);
        $this->db->update('karma', $data);
    }
    function update_user_karma_owned($user_key, $karma_type, $karma_change)
    {
        if ($karma_type) {
            $this->db->set('owned_positive_karma', 'owned_positive_karma+' . $karma_change, FALSE);
        }
        else {
            $this->db->set('owned_negative_karma', 'owned_negative_karma+' . $karma_change, FALSE);
        }
        $this->db->where('id', $user_key);
        $this->db->update('user');
    }

}
?>