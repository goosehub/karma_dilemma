<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// echo '<br>' . $this->db->last_query() . '<br>';

Class main_model extends CI_Model
{
    function record_request()
    {
        $user_flag = 0;
        $user_key = 0;
        $api_flag = 0;
        $session_data = $this->session->userdata('user_session');
        if ($session_data) {
            $user_flag = 1;
            $user_key = $session_data['id'];
        }
        if ($this->input->get('api')) {
            $api_flag = 1;
        }
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
        $this->db->like('route_url', $route_url);
        $this->db->where('created >', $timestamp);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>