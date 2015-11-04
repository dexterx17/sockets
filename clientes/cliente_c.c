#include <sys/socket.h>
#include <sys/types.h>
#include <netinet/in.h>
#include <netdb.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <errno.h>
#include <arpa/inet.h> 
#include <jansson.h> 

int main(int argc, char *argv[])
{
    int sockfd = 0, n = 0;
    char recvBuff[1024];
    struct sockaddr_in serv_addr; 

    json_t *root;
    json_error_t error;

    if(argc != 2)
    {
        printf("\n Usage: %s <ip of server> \n",argv[0]);
        return 1;
    } 

    memset(recvBuff, '0',sizeof(recvBuff));
    if((sockfd = socket(AF_INET, SOCK_STREAM, 0)) < 0)
    {
        printf("\n Error : Could not create socket \n");
        return 1;
    } 

    memset(&serv_addr, '0', sizeof(serv_addr)); 

    serv_addr.sin_family = AF_INET;
    serv_addr.sin_port = htons(9300); 

    if(inet_pton(AF_INET, argv[1], &serv_addr.sin_addr)<=0)
    {
        printf("\n inet_pton error occured\n");
        return 1;
    } 

    if( connect(sockfd, (struct sockaddr *)&serv_addr, sizeof(serv_addr)) < 0)
    {
       printf("\n Error : Connect Failed \n");
       return 1;
    } 

    bzero(recvBuff,1024);	
        printf("este es el que jode %c valor %d \n",recvBuff[0],recvBuff[0]);
	

    while ( (n = read(sockfd, recvBuff, sizeof(recvBuff)-1)) > 0)
     {
	        
	printf("\n N: %i", n);

	printf("este es el que jode %c valor %d \n",recvBuff[0],recvBuff[0]);

        memcpy(recvBuff,&recvBuff[1],strlen(recvBuff)-1);
	recvBuff[strlen(recvBuff)-1]='\0';
	
	printf("\n buf:%s \n", recvBuff);

     //   recvBuff[n] = 0;
        /*if(fputs(recvBuff, stdout) == EOF)
        {
            printf("\n Error : Fputs error\n");
        }*/
        
    /*      root = json_loads(recvBuff, 0, &error);

        if(!root)
        {
            fprintf(stderr, "error: on line %d: %s\n", error.line, error.text);
            return 1;
        }

        if(!json_is_array(root))
        {
            fprintf(stderr, "error: root is not an array\n");
            json_decref(root);
            return 1;
        }
    */
    } 

    if(n < 0)
    {
        printf("\n Read error \n");
    } 

    return 0;
}
