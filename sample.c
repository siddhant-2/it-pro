#include <stdio.h>
int main()
{
printf("hi");
return 0;
}




#include <stdio.h>
int main()
{
int a,b;
scanf("%d%d",&a,&b);
if(a>b)
	printf("%d is greater than %d ",a,b);
else
	printf("%d is greater than %d ",b,a);
return 0;
}



#include <stdio.h>
int dbl(int n)
{
printf("%d",n+n);
return 0;
}
int main()
{
int a;
scanf("%d",&a);
dbl(a);
return 0;
}











#include <stdio.h>
int main()
{
int a;
scanf("%d",&a);
while(a--)
 {
 printf("wah");
 printf("\n");
 }
return 0;
}
