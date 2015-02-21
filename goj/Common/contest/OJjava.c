#include<stdio.h>
#include<unistd.h>
int main(int argc,char *argv[])
{
	char a[100];
	sprintf(a,"/usr/lib/jvm/java-7-sun/bin/java Main <%s/stdio/%s.in >%s.out 2>runerror.log",argv[1],argv[2],argv[2]);
	system(a);
        //execl("/usr/lib/jvm/java-7-sun/bin/java", "java Main < stdio/",argv[1],".in >",argv[1],".out 2>error.log", (char *)0);
        return 0;
}
