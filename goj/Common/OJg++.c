#include<stdio.h>
#include<unistd.h>
int main(int argc,char *argv[])
{
	system("/usr/bin/g++ ./Main.cpp -lm -o Main 2>error.log");
        //execl("/usr/bin/g++", "g++ Main.cpp -o -lm Main 2>error.log", (char *)0);
        return 0;
}
