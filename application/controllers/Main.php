<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        // $this->load->model('main_model', '', TRUE);
    }

	public function index()
	{
        $data['page_title'] = site_name();
        $this->load->view('templates/header', $data);
		$this->load->view('main', $data);
		$this->load->view('templates/footer', $data);
	}
}
