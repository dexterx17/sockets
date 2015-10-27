<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

	var $socket;

	public function index(){
		$data=array();
		$this->load->view('administrador/streaming',$data);
	}

}