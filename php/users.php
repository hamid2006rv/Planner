<?php 
	include('authority.php');
	$msg='';
	if($_SERVER["REQUEST_METHOD"]=='POST')
	{
		$name=$_POST['name'];
		$pass=$_POST['pass'];
		$dpt=$_POST['dpt'];
		
		$insert=0;
		$delete=0;
		$update=0;
		
		if(isset($_POST['insert']) && $_POST['insert']=='on')
			$insert=1;
		if(isset($_POST['delete']) && $_POST['delete']=='on')
			$delete=1;
		if(isset($_POST['update']) && $_POST['update']=='on')
			$update=1;
	
		mysql_query("insert into users (username, password) values ('$name', '$pass')");
		$id=mysql_insert_id();
		mysql_query("insert into dpt_user values ($dpt, $id, $delete, 1, $insert, $update)");
		echo 'اطلاعات ذخیره شد';
	}
?>
<html>
<head>
<meta charset="utf-8">
</head>
<body dir='rtl'>
<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
نام کاربر <input type='text' name='name'><br/>
پسورد	<input type='text' name='pass'><br/>
گروه <select name='dpt'>
		<?php 
		$result=mysql_query("select * from dpt");
		while($row=mysql_fetch_assoc($result))
			{
				echo "<option value='".$row['dptid']."'>".$row['dname']."</option>"; 
			}
		?>
	 </select><br/>
مجوز درج <input type='checkbox' name='insert' checked='checked'><br/>
مجوز حذف <input type='checkbox' name='delete' checked='checked'><br/>
مجوز تغییر <input type='checkbox' name='update' checked='checked'><br/>

<input type='submit' name='save' value='ذخیره'>
</form>
</body>
</html>