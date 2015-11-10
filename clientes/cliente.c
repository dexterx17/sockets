#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <signal.h>
#include <libwebsockets.h>
#include <json/json.h>

// Promp color
// [30mMensaje -> letters in black color
// [31mMensaje -> letters in red color
// 32m -> green, 33m -> yellow, 34m -> blue, 35m -> magenta, 36m -> cyan, 37m -> gray, 90m -> dark gray, 91m -> light red, 92m -> light green, 93 m -> ligh yellow, 94m -> ligh blue.. for more information aboud letters color, backgroud color, styles, resets, you can find information in the html file in this folder
// For more information about letters color, backgroud, reset, html files attach

#define KGRN "\033[0;32;32m"	//green
#define KCYN "\033[0;36m"	//cyan
#define KRED "\033[0;32;31m"	//red
#define KYEL "\033[1;33m"	//yellow
#define KBLU "\033[0;32;34m"	//blue
#define KCYN_L "\033[1;36m"	//ligh cyan
#define KBRN "\033[0;33m"	
#define RESET "\033[0m"		// reset all attributes

//Variables
struct session_data {
	int fd;
};
static int destroy_flag = 0;
static int connection_flag = 0;
static int writeable_flag = 0;
struct pthread_routine_tool {
	struct libwebsocket_context *context;
	struct libwebsocket *wsi;
};

//Functions
static void INT_HANDLER(int signo);
static int ws_service_callback(struct libwebsocket_context *context,
                         struct libwebsocket *wsi,
                         enum libwebsocket_callback_reasons reason, void *user,
                         void *in, size_t len);
static int websocket_write_back(struct libwebsocket *wsi_in, char *str, int str_size_in);
static void *pthread_routine(void *tool_in);					 
						 
/////// START
int main(void)
{
	//* register the signal SIGINT handler */
	// There is a code example
    struct sigaction act;
    act.sa_handler = INT_HANDLER;
    act.sa_flags = 0;
    sigemptyset(&act.sa_mask);
    sigaction( SIGINT, &act, 0);
	
	//Libwebsockets variables
	struct libwebsocket_context *context = NULL;
	struct lws_context_creation_info info;
	//Struct
	/*struct lws_context_creation_info {
		int port;
		const char * iface;
		struct libwebsocket_protocols * protocols;
		struct libwebsocket_extension * extensions;
		struct lws_token_limits * token_limits;
		const char * ssl_cert_filepath;
		const char * ssl_private_key_filepath;
		const char * ssl_ca_filepath;
		const char * ssl_cipher_list;
		int gid;
		int uid;
		unsigned int options;
		void * user;
		int ka_time;
		int ka_probes;
		int ka_interval;
		#ifdef LWS_OPENSSL_SUPPORT
			void * provided_client_ssl_ctx;
		#else
			void * provided_client_ssl_ctx;
		#endif
	};*/
	
	/*Members

protocols
    Array of structures listing supported protocols and a protocol- specific callback for each one. The list is ended with an entry that has a NULL callback pointer. It's not const because we write the owning_server member 
extensions
    NULL or array of libwebsocket_extension structs listing the extensions this context supports. If you configured with --without-extensions, you should give NULL here. 
token_limits
    NULL or struct lws_token_limits pointer which is initialized with a token length limit for each possible WSI_TOKEN_*** 
ssl_cert_filepath
    If libwebsockets was compiled to use ssl, and you want to listen using SSL, set to the filepath to fetch the server cert from, otherwise NULL for unencrypted 
ssl_private_key_filepath
    filepath to private key if wanting SSL mode, else ignored 
ssl_ca_filepath
    CA certificate filepath or NULL 
ssl_cipher_list
    List of valid ciphers to use (eg, "RC4-MD5:RC4-SHA:AES128-SHA:AES256-SHA:HIGH:!DSS:!aNULL" or you can leave it as NULL to get "DEFAULT" 
gid
    group id to change to after setting listen socket, or -1. 
uid
    user id to change to after setting listen socket, or -1. 
options
    0, or LWS_SERVER_OPTION_DEFEAT_CLIENT_MASK 
user
    optional user pointer that can be recovered via the context pointer using libwebsocket_context_user 
ka_time
    0 for no keepalive, otherwise apply this keepalive timeout to all libwebsocket sockets, client or server 
ka_probes
    if ka_time was nonzero, after the timeout expires how many times to try to get a response from the peer before giving up and killing the connection 
ka_interval
    if ka_time was nonzero, how long to wait before each ka_probes attempt 
provided_client_ssl_ctx
    If non-null, swap out libwebsockets ssl implementation for the one provided by provided_ssl_ctx. Libwebsockets no longer is responsible for freeing the context if this option is selected. 
provided_client_ssl_ctx
    If non-null, swap out libwebsockets ssl implementation for the one provided by provided_ssl_ctx. Libwebsockets no longer is responsible for freeing the context if this option is selected. */


	struct libwebsocket *wsi = NULL;			//Struct thar handle client conexion
	struct libwebsocket_protocols protocol;	// List of protocols and handlers server supports.
	
	 
	memset(&info, 0, sizeof info);
	info.port = CONTEXT_PORT_NO_LISTEN;	//Delete listen on any port, because we are only client
	info.iface = NULL;					// NULL to bind the listen socket to all interfaces, or the interface name, eg, "eth2" 
	info.protocols = &protocol;
	info.ssl_cert_filepath = NULL;		//NULL uncrypter
	info.ssl_private_key_filepath = NULL;//No private key
	info.extensions = libwebsocket_get_internal_extensions();
	info.gid = -1;
	info.uid = -1;
	info.options = 0;
	
	
	//Work with protocol struct, that will be passed to libwebsocket_create_server
	/*public attributes of libwebsocket_protocol -> 
	 * const char * name, callback_function * callback, size_t per_session_data_size, size_t rx_buffer_size, 
	 * struct libwebsocket_context * owning_server, int protocol_index
	 */ 
	 
	 /*id
    ignored by lws, but useful to contain user information bound to the selected protocol. For example if this protocol was called "myprotocol-v2", you might set id to 2, and the user code that acts differently according to the version can do so by switch (wsi->protocol->id), user code might use some bits as capability flags based on selected protocol version, etc. 
owning_server
    the server init call fills in this opaque pointer when registering this protocol with the server. 
protocol_index
    which protocol we are starting from zero */
	
	protocol.name  = "my-echo-protocol";	//Protocol name that must match the one given in the client Javascript new WebSocket(url, 'protocol') name. 
	protocol.callback = &ws_service_callback;	//The service callback used for this protocol. It allows the service action for an entire protocol to be encapsulated in the protocol-specific callback 
	protocol.per_session_data_size = sizeof(struct session_data);	//Each new connection using this protocol gets this much memory allocated on connection establishment and freed on connection takedown. A pointer to this per-connection allocation is passed into the callback in the 'user' parameter 
	protocol.rx_buffer_size = 0;	//if you want atomic frames delivered to the callback, you should set this to the size of the biggest legal frame that you support. If the frame size is exceeded, there is no error, but the buffer will spill to the user callback when full, which you can detect by using libwebsockets_remaining_packet_payload. Notice that you just talk about frame size here, the LWS_SEND_BUFFER_PRE_PADDING and post-padding are automatically also allocated on top. 
	//protocol.id = 0;
	//protocol.user = NULL;
	
	context = libwebsocket_create_context(&info);	//Create the websocket handler, create the listening socket
	printf(KRED"[Main] context created.\n"RESET);
	
	if (context == NULL) {
		printf(KRED"[Main] context is NULL.\n"RESET);
		return -1;
	}
	
	
	//Connect to another websocket server
	/*Arguments

context
    Websocket context 
address
    Remote server address, eg, "myserver.com" 
port
    Port to connect to on the remote server, eg, 80 
ssl_connection
    0 = ws://, 1 = wss:// encrypted, 2 = wss:// allow self signed certs 
path
    Websocket path on server 
host
    Hostname on server 
origin
    Socket origin name 
protocol
    Comma-separated list of protocols being asked for from the server, or just one. The server will pick the one it likes best. If you don't want to specify a protocol, which is legal, use NULL here. 
ietf_version_or_minus_one
    -1 to ask to connect using the default, latest protocol supported, or the specific protocol ordinal */
	
	wsi = libwebsocket_client_connect(context, "192.168.0.71", 9300, 0,
			"/", "192.168.0.71:9300", NULL,
			 protocol.name, -1);
			 
			 
	printf(KGRN"[Main] wsi create success.\n"RESET);
	
	
	struct pthread_routine_tool tool;
	tool.wsi = wsi;
	tool.context = context;

	pthread_t pid;
	pthread_create(&pid, NULL, pthread_routine, &tool);
	pthread_detach(pid);

	while(!destroy_flag)
	{
		libwebsocket_service(context, 50);
	}

	libwebsocket_context_destroy(context);
	
		
	return 0;
}


static void INT_HANDLER(int signo) {
    destroy_flag = 1;
}

static int ws_service_callback(struct libwebsocket_context *context,
                         struct libwebsocket *wsi,
                         enum libwebsocket_callback_reasons reason, void *user,
                         void *in, size_t len)
{
   
    switch (reason) {

		case LWS_CALLBACK_CLIENT_ESTABLISHED:
			printf(KYEL"[Main Service] Connect with server success.\n"RESET);
			connection_flag = 1;
			break;

		case LWS_CALLBACK_CLIENT_CONNECTION_ERROR:
			printf(KRED"[Main Service] Connect with server error.\n"RESET);
			destroy_flag = 1;
			connection_flag = 0;
			break;

		case LWS_CALLBACK_CLOSED:
			printf(KYEL"[Main Service] LWS_CALLBACK_CLOSED\n"RESET);
			destroy_flag = 1;
			connection_flag = 0;
			break;

		case LWS_CALLBACK_CLIENT_RECEIVE:
			printf(KCYN_L"[Main Service] Client recvived:%s\n"RESET, (char *)in);

			if (writeable_flag)
				destroy_flag = 1;

			break;
		case LWS_CALLBACK_CLIENT_WRITEABLE :
			printf(KYEL"[Main Service] On writeable is called. send byebye message\n"RESET);
			websocket_write_back(wsi, "Byebye! See you later", -1);
			writeable_flag = 1;
			break;

		default:
			break;
	}

    return 0;
}

static int websocket_write_back(struct libwebsocket *wsi_in, char *str, int str_size_in) 
{
	if (str == NULL || wsi_in == NULL)
		return -1;

	int n;
	int len;
	char *out = NULL;

	if (str_size_in < 1) 
		len = strlen(str);
	else
		len = str_size_in;
 
	// the funny part
	// create a buffer to hold our response
	// it has to have some pre and post padding. You don't need to care

	out = (char *)malloc(sizeof(char)*(LWS_SEND_BUFFER_PRE_PADDING + len + LWS_SEND_BUFFER_POST_PADDING));
	
	//* setup the buffer*/
	memcpy (out + LWS_SEND_BUFFER_PRE_PADDING, str, len );
	//* write out*/
	n = libwebsocket_write(wsi_in, out + LWS_SEND_BUFFER_PRE_PADDING, len, LWS_WRITE_TEXT);


	printf(KBLU"[websocket_write_back] %s\n"RESET, str);
	
	//* free the buffer*/
	free(out);

	return n;
}


static void *pthread_routine(void *tool_in)
{
	//JSON
	/*Creating a json object*/
  json_object * jobj = json_object_new_object();

  /*Creating a json array*/
  json_object *jarray = json_object_new_array();

  /*Creating json strings*/
  json_object *jstring1 = json_object_new_string("192.168.0.12");
  json_object *jstring2 = json_object_new_string("192.168.0.71");
  json_object *jstring3 = json_object_new_string("05050");

  /*Adding the above created json strings to the array*/
  json_object_array_add(jarray,jstring1);
  json_object_array_add(jarray,jstring2);
  json_object_array_add(jarray,jstring3);

  /*Form the json object*/
  json_object_object_add(jobj,"Categories", jarray);


	struct pthread_routine_tool *tool = tool_in;

	printf(KBRN"[pthread_routine] Good day. This is pthread_routine.\n"RESET);

	//* waiting for connection with server done.*/
	while(!connection_flag)
		usleep(1000*20);

	//*Send greeting to server*/
	printf(KBRN"[pthread_routine] Server is ready. send a greeting message to server.\n"RESET);	
	websocket_write_back(tool->wsi, (char*)json_object_to_json_string(jobj), -1);

	printf(KBRN"[pthread_routine] sleep 2 seconds then call onWritable\n"RESET);
	sleep(1);
	printf(KBRN"------------------------------------------------------\n"RESET);
	sleep(1);
	//printf(KBRN"[pthread_routine] sleep 2 seconds then call onWritable\n"RESET);

	//*involked wriable*/
	printf(KBRN"[pthread_routine] call on writable.\n"RESET);	
	libwebsocket_callback_on_writable(tool->context, tool->wsi);

}