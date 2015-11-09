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

		$this->load->view('administrador/consola',$data);
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
		return $this->socket->wsStartServer('192.168.0.71',9300);

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

		// check if message length is 0
		if ($messageLength == 0) {
			$this->socket->wsClose($clientID);
			return;
		}

		$msj=json_decode($message);
		//$this->socket->log($msj);
		//echo "prueba";
		
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
				$this->socket->wsSend($id, json_encode(array('tipo'=>'conexion','cliente'=>$clientID ,'login_date'=>$client[3],'ip'=>$ip)));
	}

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
			$this->socket->wsSend($id, json_encode(array('tipo'=>'desconexion','cliente'=>$clientID ,'login_date'=>$client[3],'ip'=>$ip)));
	}
}
