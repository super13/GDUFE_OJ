#include<stdio.h>
#include<unistd.h>
int main(int argc,char *argv[])
{
	char a[100];
	execl("/usr/bin/pkill", "pkill ","Main", (char *)0);
	sprintf(a,"/usr/lib/jvm/java-7-sun/bin/java Main <stdio/%s.in >%s.out 2>runerror.log",argv[1],argv[1]);
	system(a);
        //execl("/usr/lib/jvm/java-7-sun/bin/java", "java Main < stdio/",argv[1],".in >",argv[1],".out 2>error.log", (char *)0);
        return 0;
}
