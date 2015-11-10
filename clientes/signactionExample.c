#include <signal.h>

void termination_handler (int signum)
{
	struct temp_file *p;
	
	for(p = temp_file_list; p;p=p->next)
		unlink(p->name);
}

int main(void)
{
	struct signaction new_action, old_action; //Signaction -> examine and change a signal action estructura es:
	/*struct sigaction {
               void     (*sa_handler)(int);
               void     (*sa_sigaction)(int, siginfo_t *, void *);
               sigset_t   sa_mask;
               int        sa_flags;
               void     (*sa_restorer)(void);
           };
	*/
	//Create the structure to specify the new action
	new_action.sa_handler = termination_handler; //sa_handler Especifies the action to be associated with signum, SIG_DFL -> default, SIG-IGN -> ignore
	sigemptyset(&new_action.sa_mask); 			// blocking signal prevent interrupts during critical parts of your code
	new_action.sa_flags = 0;
	
	sigaction(SIGINT, NULL, &old_action);
	
	if(old_action.sa_handler != SIG_IGN)
		sigaction (SIGINT, &new_action, NULL);
	sigaction(SIGHUP,NULL,&old_action);
	
	if(old_action.sa_handler != SIG_IGN)
		sigaction(SIGHUP, &new_action,NULL);
	sigaction(SIGTERM,NULL,&old_action);
	
	if(old_action.sa_handler != SIG_IGN)
		sigaction(SIGTERM, &new_action,NULL);
		
	//With this code, load a new_actino strcuture with the desired parameter and passes to sigaction call, sigemptyset is part of blocking signals
}