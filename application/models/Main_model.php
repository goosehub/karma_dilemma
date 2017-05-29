<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// echo '<br>' . $this->db->last_query() . '<br>';

Class main_model extends CI_Model
{
    function insert_request($user_flag, $user_key, $api_flag)
    {
        $data = array(
            'user_flag' => $user_flag,
            'user_key' => $user_key,
            'api_flag' => $api_flag,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'route_url' => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            'full_url' => $_SERVER['REQUEST_URI'],
            'get_data' => json_encode($_GET),
            'post_data' => json_encode($_POST),
        );
        $this->db->insert('request', $data);
        return $this->db->insert_id();
    }
    function check_request_route($ip, $route_url, $timestamp)
    {
        $this->db->select('*');
        $this->db->from('request');
        $this->db->where('ip', $ip);
        $this->db->where('route_url', $route_url);
        $this->db->where('created >', $timestamp);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>