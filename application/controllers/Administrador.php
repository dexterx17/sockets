<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Permite administrar la conexion y los mensajes que se 
 * transmite a traves del Socket
 * 
 */

class Administrador extends CI_Controller {

	var $socket;

	/**
	 * Muestra la consola del socket
	 * @return php Vista de la consola
	 */
	public function index(){
		$data=array();
		$data['paquete']=$this->paquete->get_info();

		$this->load->view('administrador/teleoperacion',$data);
	}

	/**
	 * Muestra una vista  para inicializar el adminstrador
	 * del streaming de video 
	 * @return php Vista del admin de streaming video
	 */
	public function video(){
		$data=array();
		$this->load->view('administrador/admin_video',$data);
	}

	public function consola(){
		$data=array();
		$this->load->view('administrador/admin_consola',$data);
	}

		public function grafica(){
		$data=array();
		$this->load->view('Brazo/index.html',$data);
	}
	public function admin_video(){
		$data=array();
		$this->load->view('administrador/streaming',$data);
	}

	/**
	 * Inicializa un socket en la ip y puertos especificados
	 * 
	 * @return TRUE Devuelve verdadero si se inicializo correctamente
	 */
	public function iniciar_socket(){
		$this->socket= new PHPWebSocket();	
		
		$this->socket->bind('message', 'wsOnMessage');
		$this->socket->bind('open', 'wsOnOpen');
		$this->socket->bind('close', 'wsOnClose');     
		return $this->socket->wsStartServer('192.168.1.102',9300);
		

	}
		public function iniciar_socket1(){
		$this->socket= new PHPWebSocket();	
		
		$this->socket->bind('message', 'wsOnMessage');
		$this->socket->bind('open', 'wsOnOpen');
		$this->socket->bind('close', 'wsOnClose');     
		return $this->socket->wsStartServer('192.168.0.23',9301);
		
	}

	/**
	 * Se ejecuta cuando llega un mensaje al socket enmascarado 
	 * de acuerdo al estandar WebSocket Protocol 07 (http://tools.ietf.org/html/draft-ietf-hybi-thewebsocketprotocol-07)
	 * 
	 * @param  Integer $clientID      Identificador del cliente
	 * @param  String $message       Mensaje
	 * @param  Integer $messageLength Tamano del mensaje
	 * @param  [type] $binary        [description]
	 */
		

	function wsOnMessage($clientID, $message, $messageLength, $binary) {
	

		$ip = long2ip($this->socket->wsClients[$clientID][6]);		
	
	//	$this->socket->log("$ip ($clientID) send to message.");	

		// check if message length is 0
		if ($messageLength == 0) {
			$this->socket->wsClose($clientID);
			return;
		}
		//print_r($message);
		$msj=json_decode($message);
		//$this->socket->log($msj);

		print_r($msj);

		//Si es un mensaje tipo {'cliente':'admin'} seteo la posicion 12 
		if (isset($msj->cliente)){

			//print_r($this->socket->wsClients[$clientID]);
			
			$this->socket->wsClients[$clientID][12] = $msj->cliente;
			
			print ($msj->cliente);
		


		}
	

		foreach ($this->socket->wsClients as $id => $client){
			//verifico si ya tienen definido un tipo en la posicion 12
			if(isset($client[12])){
				//Si esta definido el destino ({'origen':'admin','destino':'silla','texto':'mensaje'})
				if(isset($msj->destino)){
					//como si sabemos que tipo de cliente es verificamos si el mensaje es para el
					if($client[12]==$msj->destino){
						//enviamos solo al cliente destino
						$this->socket->wsSend($id,json_encode ($msj));
					}
					else{
						if($client[12]=="php"){
						//enviamos solo al cliente php
						$this->socket->wsSend($id,json_encode ($msj));

					}
					
				}
									

					//Reenvio en mensaje al mismo cliente que envio
					//si es diferente de servidor no retorna
					/*
					if(($msj->destino!="servidor")){
						if($client[12]==$msj->origen){
						//enviamos solo al cliente destino
						$this->socket->wsSend($id, json_encode($msj));
					  }	
					}
					*/
				}else{
			
						
			

					$this->socket->wsSend($id,json_encode ($msj));
				}
			}
	 	//	$this->socket->log("$ip ($clientID) se guardo");
		}

		 
	}

		


	/**
	 * Se ejecuta cuando un nuevo cliente se conecta al socket
	 * 
	 * @param  Integer $clientID Identificador del cliente
	 * @return [type]           [description]
	 */


	function wsOnOpen($clientID) {
		$ip = long2ip($this->socket->wsClients[$clientID][6]);




		$this->socket->log("$ip ($clientID) has connected.");



		//Send a join notice to everyone but the person who joined
		foreach ($this->socket->wsClients as $id => $client)
			if ($id != $clientID)
				$this->socket->wsSend($id, json_encode(array('tipo'=>'conexion','clienteId'=>$clientID ,'ip'=>$ip)));

	}


 

	//
	/**
	 * Se ejecuta cuando un cliente se desconecta del socket
	 * 
	 * @param  Integer $clientID Identificador del cliente
	 * @return [type]           [description]
	 */

	function wsOnClose($clientID, $status) {

		$ip = long2ip($this->socket->wsClients[$clientID][6]);
	
		$this->socket->log("$ip ($clientID) has disconnected.");
 
		//Send a user left notice to everyone in the room
		foreach ($this->socket->wsClients as $id => $client)
			$this->socket->wsSend($id, json_encode(array('tipo'=>'desconexion','cliente'=>$clientID ,'ip'=>$ip)));
	}

}