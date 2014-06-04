<?php require_once('common.php');//引入公共文件，其中实现了SQL注入漏洞检查的代码
$username=trim($_POST['username']);
//取得客户端提交的密码并用md5()函数时进行加密转换以便后面的验证
$pwd=md5($_POST['pwd']);
//设置一个错误消息变量，以便判断是否有错误产生
//以及在客户端显示错误信息，其初值为空
$errmsg='';
if(!empty($username)){//用户填写了数据才执行数据库操作
	//------------
	//数据验证，empty()函数判断变量内容是否为空
if(empty($username)){
	$errmsg=''数据输入不完整;
}
//--------------------------
if(empty($errmsg)){//errmsg为空说明前面的验证通过
//调用mysqli的构造函数建立连接，同时选择使用数据库'tset'
$db=@new mysqli("127.0.0.1","developer","123456","test");
//检查数据库连接
if(mysqli_connect_errno()){
	$errmsg="数据库连接失败！\n";
	}
else{
	//查询数据库，看用户名密码是否正确
	$sql="SELECT*FROM t_user WHERE f_username='$username'AND f_password='$pwd'";
	$rs=$db->query($sql);
//$rs->num_rows 判断上面的执行结果是否含有记录，有记录则说明登陆成功
if($rs&&$rs->num_rows>0){
	//使用session保存当前用户
	session_start();
	if(empty($_SESSION['uid'])){
		echo"您还没有登陆，不能访问当前页面！";
		exit;	
}
	$_SESSION['uid']=$username;
	//在实际应用中可以使用前面提到的重新定向功能转到主页
	$errmsg="登陆成功";
	//更新用户登录信息
	$ip=$_SERVER['REMOVE_ADDR'];//获取客户端的IP
	$sql="UPDATE t_userSET f_logintimes=f_logintimes+1,";
	$sql="f_lastname=now();f_loginip='$ip'";
	$sql="WHEREf_username='$username'";
	$db->query($sql);
}
else{
$errmsg="用户名或密码不正确，登录失败！"
}
//关闭数据库连接
$db->close();
}
}
}
?>
代码首先从自动全局变量$_SERVER中获得客户端的IP地址，然后构造SQL语句并执行该语句
以更新用户登录信息。值得注意的是该SQL与剧中对f_lastname的赋值是通过调用MySQL的
内部函数now()来实现的，MySQL的now()函数返回的是服务器上的当前时间。
<html>
<head>
<meta http-equiv="Content-Type" content="text/html";charset=gb2312>
<title>User Login</title>
<style type="text/css">
<!-
.alert{color:red}
.textinput{width:160px}
.btn{width:80px}
table{border:3px double;blackground-color:#eeeeee;}
-->
</style>
<script language="javascript">
<!--
function doCheck(){
	if(document.frmLogin.username.value==""){
		alert('请输入您的用户名！');
		return false;
		}
	if(document.frmLogin.password.value==""){
		alert('请输入您的密码！');
		return false;
	}
}
-->
</script>
</head>
<body>
<form name="frmLogin" method="post" action="login.php" onSubmit="return doCheck();">
<table border="0" cellpadding="8" width="350" align="center">
<tr>
<td colspan="2" align="center" class="alert">用户名：</td></tr>
<td><input name="username" type="text" id="username" class="textinput"/></td>
</tr>
<tr>
<td>密码：</td>
<td><input name="pwd" type="password" id="password" class="textinput"></td>
</tr>
<tr><td colspan="2" align="center">
<input type="submit" class="btn" value="登陆">&nbsp;&nbsp;
<input type="reset" class="btn" value="重置">
</td>
</tr>
</form>
</body>
</html>
