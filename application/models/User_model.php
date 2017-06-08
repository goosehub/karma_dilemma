<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class user_model extends CI_Model
{
    function get_all_users()
    {
        $this->db->select('id, username, avatar, created, score, available_good_karma, available_bad_karma, good_karma, bad_karma');
        $this->db->from('user');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function get_this_user()
    {
        // Default to user as false
        $user = false;

        // Get users by session
        if ($this->session->userdata('user_session')) {
            $session_data = $this->session->userdata('user_session');
            $user = $this->user_model->get_user_extended_by_id($session_data['id']);
            $user['started_games_count'] = $this->game_model->count_your_turn($user['id']);
            if (!isset($user['username'])) {
                redirect('user/logout', 'refresh');
                exit();
                return false;
            }
            $this->user_loaded($user['id']);
        }

        // Get users by api key
        else if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
            $input = get_json_post(false);
            if (isset($input->user_id) && isset($input->api_key)) {
                $user_auth = $this->user_model->get_user_auth_by_id($input->user_id);
                if (!isset($user_auth['api_key']) || !hash_equals($user_auth['api_key'], $input->api_key)) {
                    $this->output->set_status_header(401);
                    echo api_error_response('bad_auth', 'Your user_id, api_key combination was incorrect');
                    exit();
                }
                $user = $this->get_user_extended_by_id($user_auth['id']);
                $user['started_games_count'] = $this->game_model->count_your_turn($user['id']);
                $this->user_loaded($user['id']);
            }
        }

        // Return user
        return $user;
    }
    function get_user_by_id($user_id)
    {
        $this->db->select('id, username, avatar, created, score, available_good_karma, available_bad_karma, good_karma, bad_karma');
        $this->db->from('user');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }
    function get_user_extended_by_id($user_id)
    {
        $this->db->select('
            user.id,
            user.username,
            user.avatar,
            user.score,
            user.available_good_karma,
            user.available_bad_karma,
            user.good_karma,
            user.bad_karma,
            SUM(user.available_good_karma + user.available_bad_karma) as total_available_karma,
            SUM(good_karma + bad_karma) as total_karma,
            (SELECT COUNT(*) FROM game WHERE game.primary_user_key = user.id OR game.secondary_user_key = user.id) AS games_played,
            user.last_load,
            user.created as created
        ');
        $this->db->from('user');
        $this->db->group_by('id');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        $result = $query->result_array();
            return isset($result[0]) ? $result[0] : false;
    }
    function get_user_auth_by_id($user_id)
    {
        $this->db->select('id, username, password, api_key');
        $this->db->from('user');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return isset($result[0]) ? $result[0] : false;
        }
        else {
            return false;
        }
    }
    function get_user_auth_by_username($username)
    {
        $this->db->select('id, username, password, api_key');
        $this->db->from('user');
        $this->db->where('username', $username);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return isset($result[0]) ? $result[0] : false;
        }
        else {
            return false;
        }
    }
    function register($username, $password, $api_key, $email, $ip, $register_ip_frequency_limit_minutes, $ab_test, $avatar)
    {
        // Check for excessive IPs registers
        $this->db->select('id');
        $this->db->from('user');
        $this->db->where('ip', $ip);
        $this->db->where('created > NOW() - INTERVAL ' . $register_ip_frequency_limit_minutes . ' MINUTE');
        $this->db->limit(1);
        $query = $this->db->get();

        // Disabled for now
        if (!is_dev() && $query->num_rows() > 0) {
            return 'ip_fail';
        }

        // Check for existing username
        $this->db->select('username');
        $this->db->from('user');
        $this->db->where('username', $username);
        $this->db->limit(1);
        $query = $this->db->get();

        // Username already exists
        if ($query->num_rows() > 0) {
            return false;
        }
        // Register
        else {
            // Insert user into user
            $data = array(
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'api_key' => $api_key,
            'email' => $email,
            'ip' => $ip,
            'ab_test' => $ab_test,
            'avatar' => $avatar,
            'last_load' => date('Y-m-d H:i:s'),
            'score' => 0,
            'available_good_karma' => 0,
            'available_bad_karma' => 0,
            'good_karma' => 0,
            'bad_karma' => 0,
            );
            $this->db->insert('user', $data);

            // Return user id
            $this->db->select_max('id');
            $this->db->from('user');
            $this->db->limit(1);
            $query = $this->db->get()->row();
            $user_id = $query->id;
            return $user_id;
        }
    }
    function user_loaded($user_id)
    {
        $data = array(
            'last_load' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $user_id);
        $this->db->update('user', $data);
        return true;
    }
    function update_avatar($user_id, $avatar)
    {
        $data = array(
            'avatar' => $avatar
        );
        $this->db->where('id', $user_id);
        $this->db->update('user', $data);
        return true;
    }

}
?>