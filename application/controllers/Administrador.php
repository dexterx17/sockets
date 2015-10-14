<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {

	public function index(){
		$data=array();
		$data['paquete']=$this->paquete->get_info();
		$this->load->view('administrador/consola',$data);
	}

	public function test(){
		
				$this->load->view('administrador/consola');
	}

	public function test2($p1=9,$p2=9){
		
		$this->load->view('administrador/consola');
	}
}
