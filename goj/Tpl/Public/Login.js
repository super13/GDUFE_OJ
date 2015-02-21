function getcookie(objname){
        var arrstr = document.cookie.split("; ");
        for(var i = 0;i < arrstr.length;i ++){
        var temp = arrstr[i].split("=");
        if(temp[0] == objname) return decodeURI(temp[1]);
        }
}
function changeText(a){
	a = typeof(a) == 'undefined' ? 0 : a;
	if(getcookie('account')==null){
		if(a==0)
        		document.getElementById('LoginArea').innerHTML = "<ul><li id='regi'><a href='http://acm.gdufe.edu.cn/User/Register'>Register</a></li> <li id='log'><a href='http://acm.gdufe.edu.cn/User/Login'>Login</a></li></ul>";
		else if(a==1)
			document.getElementById('LoginArea').innerHTML = "<ul><li id='regi'><a href='http://acm.gdufe.edu.cn/User/Register' class='thispage'>Register</a></li> <li id='log'><a href='http://acm.gdufe.edu.cn/User/Login'>Login</a></li></ul>";
		else
			document.getElementById('LoginArea').innerHTML = "<ul><li id='regi'><a href='http://acm.gdufe.edu.cn/User/Register' >Register</a></li> <li id='log'><a href='http://acm.gdufe.edu.cn/User/Login' class='thispage'>Login</a></li></ul>";
 }
 else
        document.getElementById('LoginArea').innerHTML = "<ul><li id='me'><a href='http://acm.gdufe.edu.cn/User/Me'>"+getcookie('nickname') +"</a></li> <li id='logout'><a href ='http://acm.gdufe.edu.cn/User/Logout' >Logout</a></li></ul>";
 }

	
