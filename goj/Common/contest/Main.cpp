#include<stdio.h>
#include<algorithm>
using namespace std;
int main()
{
	long long int N,M,a[50000],b[50000],i,j,k,c,J,I;
	scanf("%lld%lld",&N,&M);
	for(k=0;k<N;k++)
	{
		scanf("%lld",&a[k]);
	}
	while(M--)
	{
		scanf("%lld%lld",&i,&j);
		J=j;I=i;
		for(k=0;k<=J-I,i<=j;i++)
		{
			b[k++]=a[i-1];
		}
		sort(b,b+k);
		c=b[k-1]-b[0];
		printf("%lld\n",c);
	}
	return 0;
}