<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {

	var $socket;

	public function index(){
		$data=array();
		$data['paquete']=$this->paquete->get_info();

		$this->load->view('administrador/consola',$data);
	}

	public function iniciar_socket(){
		$this->socket= new PHPWebSocket();	
		$this->socket->bind('message', 'wsOnMessage');
		$this->socket->bind('open', 'wsOnOpen');
		//	$this->socket->bind('message', 'wsOnMessage');  
		$this->socket->bind('close', 'wsOnClose');   
			
		$this->socket->wsStartServer('192.168.0.71',9301);    
		
		//$this->load->view('administrador/consola');
	}

	public function video(){
		$data=array();
		$this->load->view('administrador/admin_video',$data);
	}

	function wsOnMessage($clientID, $message, $messageLength, $binary) {
	
		$ip = long2ip($this->socket->wsClients[$clientID][6]);

		// check if message length is 0
		if ($messageLength == 0) {
			$this->socket->wsClose($clientID);
			return;
		}
		$msj=json_decode($message);

		$this->socket->log(json_decode($msj));
		echo "prueba";
		echo $message;
	
		
		//The speaker is the only person in the room. Don't< let them feel lonely.
		if (sizeof($this->socket->wsClients) == 1)
			//$this->wsSend($clientID, json_encode($activity));
			$this->socket->wsSend($clientID, json_encode($msj));
//		$this->socket->wsSend($clientID, "There isn't anyone else in the room, but I'll still listen to you. --Your Trusty Server");
		else
		//Send the msj to everyone but the person who said it
			foreach ($this->socket->wsClients as $id => $client) {
//			if ( $id != $clientID ){
				$this->socket->wsSend($id, json_encode($msj));
//				$this->socket->wsSend($id, "Visitor $clientID ($ip) said \"$message\"");
//			}

			}
	}

	function wsOnOpen($clientID) {
		$ip = long2ip($this->socket->wsClients[$clientID][6]);
		
		$this->socket->log("$ip ($clientID) has connected.");
		//Send a join notice to everyone but the person who joined
		foreach ($this->socket->wsClients as $id => $client)
			if ($id != $clientID)
				//$this->socket->wsSend($id, json_encode(array('tipo'=>'conexion','cliente'=>$clientID ,'login_date'=>$client[3],'ip'=>$ip)));
			$this->socket->wsSend($id, json_encode(array('tipo'=>'conexion','cliente'=>$clientID ,'login_date'=>$client[3],'ip'=>$ip)));
	}



	function wsOnClose($clientID, $status) {

		$ip = long2ip($this->socket->wsClients[$clientID][6]);
		//	echo ("llega");
		$this->socket->log("$ip ($clientID) has disconnected.");
		//$this->socket->log(json_encode($msj));
		//Send a user left notice to everyone in the room
		foreach ($this->socket->wsClients as $id => $client)
			$this->socket->wsSend($id, json_encode(array('tipo'=>'desconexion','cliente'=>$clientID ,'login_date'=>$client[3],'ip'=>$ip)));
	}
}