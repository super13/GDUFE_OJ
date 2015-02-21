#include<stdio.h>
#include<unistd.h>
int main(int argc,char *argv[])
{
	system("/usr/lib/jvm/java-7-sun/bin/javac ./Main.java 2>error.log");
        //execl("/usr/lib/jvm/java-7-sun/bin/javac", "javac ","Main.java", (char *)0);
        return 0;
}
