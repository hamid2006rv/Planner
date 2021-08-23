<?php
include('init.php');
if(isset($_SESSION['user_id']))
	unset($_SESSION['user_id']);

$error='';		
	if (isset($_POST['username']) && isset($_POST['password']))
		{
			$sql="select * from users where username='".$_POST['username']."' and password='".$_POST['password']."'";
			$result=mysql_query($sql);
			if($result && mysql_num_rows($result)==1)
			{
				
				$error='welcome!';
				$row=mysql_fetch_assoc($result);
				$_SESSION['user_id']=$row['id'];
				header('location: ../main.php ');
			}
			else
			$error='کلمه کاربری یا رمز عبور اشتباه است!';	
		}
 
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>سیستم اتوماسیون اداری </title>
</head>
<body dir="rtl">
	<form action='<?php $PHP_SELF?>' method='POST'>
		<table align="center">
		<tr>
			<td>نام کاربری</td><td><input name='username' type='text'  /></td>
		</tr>
		<tr>
			<td>رمز عبور</td><td><input name='password' type='password' /></td>
		</tr>
		<tr>
			<td colspan='2'>
			<input type='submit' value='ورود به سیستم'/>
			</td>
		</tr>
		<tr><td colspan=2>
		<div style='color:red;'><?php echo $error;?></div>
		</td>
		</tr>
		</table>
	
	</form>
    <span style="font-family:Tahoma;font-size:10px;color:blue;" align="center">توجه: این برنامه تنها از طریق مرورگر "فایرفاکس" قابل استفاده است!</span>
    
</body>
</html>