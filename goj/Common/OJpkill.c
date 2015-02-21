#include<stdio.h>
#include<unistd.h>
int main(int argc,char *argv[])
{
        system("/usr/bin/pgrep -f Main|xargs kill -9");
        //execl("/usr/bin/pkill ","Main", (char *)0);
        //system("/usr/bin/pkill Main");
        return 0;
}
