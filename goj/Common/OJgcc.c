#include<stdio.h>
#include<unistd.h>
int main(int argc,char *argv[])
{
	system("/usr/bin/gcc ./Main.c -lm -o Main 2>error.log");
        //execl("/usr/bin/gcc", "gcc ","Main.c","-o","-lm","Main", (char *)0);
        return 0;
}
