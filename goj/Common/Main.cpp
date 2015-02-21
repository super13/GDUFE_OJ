#include<cstdio>
#include<cmath>
#include<cstring>
#include<set>
#include<stack>
#include<queue>
#include<vector>
#include<iostream>
#include<algorithm>
using namespace std;
#define ll long long
#define INF 0x7FFFFFFF
#define INT_MIN -(1<<31)
#define eps 10^(-6)
#define Q_CIN ios::sync_with_stdio(false)
#define REP( i , n ) for ( int i = 0 ; i < n ; ++ i )
#define REV( i , n ) for ( int i = n - 1 ; i >= 0 ; -- i )
#define FOR( i , a , b ) for ( int i = a ; i <= b ; ++ i )
#define FOV( i , a , b ) for ( int i = a ; i >= b ; -- i )
#define CLR( a , x ) memset ( a , x , sizeof (a) )
#define RE freopen("in.txt","r",stdin)
#define WE freopen("out.txt","w",stdout)
#define NMAX 10002



int main()
{
	int n,m;
    while(scanf("%d%d",&n,&m)!=EOF)
    {
        printf("%d\n",n+m);
    }
	return 0;
}
