<?php require_once('common.php');//���빫���ļ�������ʵ����SQLע��©�����Ĵ���
$username=trim($_POST['username']);
//ȡ�ÿͻ����ύ�����벢��md5()����ʱ���м���ת���Ա�������֤
$pwd=md5($_POST['pwd']);
//����һ��������Ϣ�������Ա��ж��Ƿ��д������
//�Լ��ڿͻ�����ʾ������Ϣ�����ֵΪ��
$errmsg='';
if(!empty($username)){//�û���д�����ݲ�ִ�����ݿ����
	//------------
	//������֤��empty()�����жϱ��������Ƿ�Ϊ��
if(empty($username)){
	$errmsg=''�������벻����;
}
//--------------------------
if(empty($errmsg)){//errmsgΪ��˵��ǰ�����֤ͨ��
//����mysqli�Ĺ��캯���������ӣ�ͬʱѡ��ʹ�����ݿ�'tset'
$db=@new mysqli("127.0.0.1","developer","123456","test");
//������ݿ�����
if(mysqli_connect_errno()){
	$errmsg="���ݿ�����ʧ�ܣ�\n";
	}
else{
	//��ѯ���ݿ⣬���û��������Ƿ���ȷ
	$sql="SELECT*FROM t_user WHERE f_username='$username'AND f_password='$pwd'";
	$rs=$db->query($sql);
//$rs->num_rows �ж������ִ�н���Ƿ��м�¼���м�¼��˵����½�ɹ�
if($rs&&$rs->num_rows>0){
	//ʹ��session���浱ǰ�û�
	session_start();
	if(empty($_SESSION['uid'])){
		echo"����û�е�½�����ܷ��ʵ�ǰҳ�棡";
		exit;	
}
	$_SESSION['uid']=$username;
	//��ʵ��Ӧ���п���ʹ��ǰ���ᵽ�����¶�����ת����ҳ
	$errmsg="��½�ɹ�";
	//�����û���¼��Ϣ
	$ip=$_SERVER['REMOVE_ADDR'];//��ȡ�ͻ��˵�IP
	$sql="UPDATE t_userSET f_logintimes=f_logintimes+1,";
	$sql="f_lastname=now();f_loginip='$ip'";
	$sql="WHEREf_username='$username'";
	$db->query($sql);
}
else{
$errmsg="�û��������벻��ȷ����¼ʧ�ܣ�"
}
//�ر����ݿ�����
$db->close();
}
}
}
?>
�������ȴ��Զ�ȫ�ֱ���$_SERVER�л�ÿͻ��˵�IP��ַ��Ȼ����SQL��䲢ִ�и����
�Ը����û���¼��Ϣ��ֵ��ע����Ǹ�SQL����ж�f_lastname�ĸ�ֵ��ͨ������MySQL��
�ڲ�����now()��ʵ�ֵģ�MySQL��now()�������ص��Ƿ������ϵĵ�ǰʱ�䡣
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
		alert('�����������û�����');
		return false;
		}
	if(document.frmLogin.password.value==""){
		alert('�������������룡');
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
<td colspan="2" align="center" class="alert">�û�����</td></tr>
<td><input name="username" type="text" id="username" class="textinput"/></td>
</tr>
<tr>
<td>���룺</td>
<td><input name="pwd" type="password" id="password" class="textinput"></td>
</tr>
<tr><td colspan="2" align="center">
<input type="submit" class="btn" value="��½">&nbsp;&nbsp;
<input type="reset" class="btn" value="����">
</td>
</tr>
</form>
</body>
</html>
