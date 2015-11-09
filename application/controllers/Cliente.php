<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Permite administrar las operaciones de los clientes
 * 
 */
class Cliente extends CI_Controller {

	var $socket;

	/**
	 * Muestra una vista  para conectarse al streaming de video
	 * @return php Vista del streaming de video
	 */
	public function index(){
		$data=array();
		$this->load->view('administrador/streaming',$data);
	}

	/**
	 * Muestra una vista  para compartir pantalla
	 *  PRUEBAS
	 * @return php Vista pruebas webrtc
	 */
	public function pantalla(){
		$data=array();
		$this->load->view('administrador/pantalla',$data);
	}

}