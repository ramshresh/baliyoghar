<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('includes/Header');
                $this->load->view('includes/Navigation');
                $this->load->view('Home');
                $this->load->view('includes/Footer');
	}
}

