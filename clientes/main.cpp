#include <WinSock2.h>
#include <WS2tcpip.h>
#include <iostream>
#include <string>
#include <process.h>
// link with Ws2_32.lib
#pragma comment(lib, "Ws2_32.lib")
 
char envBuff[512];
bool bandEnvio;
static HANDLE myhandleA;

unsigned __stdcall startSocketcillo(void*){
	WSADATA wsaData;
		SOCKET conn_socket;
		struct sockaddr_in server;
		int resp;
		struct hostent *hp;

		//Inicializamos la DLL de manejo de sockets
		resp=WSAStartup(MAKEWORD(1,0),&wsaData);
		if(resp){
			printf("Error al iniciar socket\n");
			getchar();
			return -1;
		}

		//Obtenemos la IP del servidor... en este caso
		// localhost indica nuestra propia máquina...
		 
		/*hp=(struct hostent *)gethostbyname("192.168.0.107");

		  if(!hp){
			printf("No se ha encontrado servidor...\n");
			getchar();WSACleanup();return WSAGetLastError();
		  }*/

		//Creamos el socket
		conn_socket = socket(AF_INET,SOCK_STREAM,0);
		if(conn_socket == INVALID_SOCKET){
			printf("Error al crear socket\n");
			getchar();
			WSACleanup();
			return WSAGetLastError();
		}

		 memset(&server, 0, sizeof(server)) ;
		 //memcpy(&server.sin_addr, hp->h_addr, hp->h_length);
		 server.sin_addr.s_addr=inet_addr("192.168.0.107");
		 server.sin_family = AF_INET;
		 //server.sin_family = hp->h_addrtype;
		 server.sin_port = htons(8888);

		 // Nos conectamos con el servidor...
		if(connect(conn_socket,(struct sockaddr *)&server,sizeof(server))==SOCKET_ERROR){
			printf("Fallo al conectarse con el servidor\n");
			closesocket(conn_socket);
			WSACleanup();getchar();return WSAGetLastError();
		}
		
		printf("Conexión establecida con: %s\n", inet_ntoa(server.sin_addr));

		//strcpy_s(envBuff,"Hola servidor... .P");
		bandEnvio = false;
		while(1){
			//Enviamos y recibimos datos...
			if(bandEnvio){
				printf("Enviando Mensaje... \n");
				send(conn_socket,envBuff,sizeof(envBuff),0);
				printf("Datos enviados: %s \n", envBuff);
				bandEnvio = false;
			}
		}

		getchar();
  
		// Cerramos el socket y liberamos la DLL de sockets
		closesocket(conn_socket);
		WSACleanup();

	return EXIT_SUCCESS;
}

int main(int argc, char *argv[])
{
	myhandleA = (HANDLE)_beginthreadex(0, 0, &startSocketcillo, (void*)0, 0, 0);
	char hola[10];
	Sleep(4000);
	for(int iii = 0; iii < 5 ; iii++){
		//printf("Envia un mensajito");
		getchar();
		strcpy(envBuff,"Ahi te voy");
		bandEnvio = true;
	}
}

