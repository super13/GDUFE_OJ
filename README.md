# GDUFE_ACM_ONLINE_JUDGE
GDUFE_ACM_OJ,based on ThinkPHP ,and the judging core is writing in java.
OJ是在centos6.4下写的，没有写安装。只能直接放入使用。
goj目录是整个oj代码，里面的index.php是thinkphp的入口文件，要对应thinkphp文件放的位置
    Common目录，放着OJ的所有测试数据和提交的程序代码，还有判题程序。里面contest目录表示比赛的判题程序。判题程序分两个，
    代码放在根目录的Judge和JudgeContest。
    Conf目录，配置文件，数据库用户密码，数据库名等。
    Lib目录，整个网站后台的代码。(MVC的C)
    Tpl目录，整个网站前端的代码。(MVC的V)

Judge和JudgeContest目录分别对应着两个判题程序的代码。eclipse工程，导入即可，需要一些jar包，里面有列。

Thinkphp目录，Thinkphp框架的依赖文件，位置需要与goj下index.php里面的设置对应上。

还有两个sql文件表示所有数据库需要的表.
