<?php
	include ('php/authority.php');
	
	$did='';
	$mid=-1;
	$tid=-1;
	$stdnum=0;
	$uid=$_SESSION['user_id'];
	$nkrd=0;
	$pkrd=0;
	$pkrsh=0;
	$nkrsh=0;
	$akrsh=0;
	
	$changepass=false;

	if($_SERVER["REQUEST_METHOD"]=="GET")
	{
	
		if(isset($_GET['old_pass']) && $_GET['old_pass']!='')
			$changepass=true;	
			
		if(isset($_GET['major']))
			$mid=$_GET['major'];
		if(isset($_GET['dpt']))
			$did=$_GET['dpt'];
		if(isset($_GET['stdnum']) && $_GET['stdnum']!='')
			$stdnum=$_GET['stdnum'];
		if(isset($_GET['pkrd']))
			$pkrd=1;
		if(isset($_GET['nkrd']))
			$nkrd=1;
		if(isset($_GET['pkrsh']))
			$pkrsh=1;
		if(isset($_GET['nkrsh']))
			$nkrsh=1;
		if(isset($_GET['akrsh']))
			$akrsh=1;
	
		if($did!=-1 && $mid!=-1)
		{
		$sql="update major set  std_num=$stdnum, 			
								kardani_p=$pkrd,
								kardani_n=$nkrd,
								karshenasi_p=$pkrsh,
								karshenasi_n=$nkrsh,
								karshenasi_a=$akrsh where mid=$mid";
			mysql_query($sql);
			mysql_query("delete from major_entry where mid=$mid");
			foreach($_GET as $key=>$value)
				{	
					$pos=strpos($key,"r_");
					if($pos!=false && $pos==1 && $value=='on') 
					{
						$ent=substr($key,3);
						mysql_query("insert into major_entry values ($mid,$ent)");
					}
				}
		}

	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="css/search.css">
	<link rel="stylesheet" type='text/css' href="css/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.ui.all.css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type='text/javascript' src='js/combobox.ui.js'></script>
</head>
<body dir='rtl' style='font-family:tahoma;font-size:10pt'>
<table style="width: 100%; height: 100%;" cellpadding="0" cellspacing="0">
		<tr bgcolor="#618CD1">
			<td  >
				<a href='./php/login.php'>خروج</a>
			</td>
			<td>
		<!---------------------------------------------------------------------------->
			</td>
		</tr>
		<tr>
<td style="width: 10%;padding:5pt;font-family:tahoma;font-size:9pt" valign="top" align='center' bgcolor="#D7E7FB">
				<div>
					<img src='pic/sepahan.png' alt='sepahan logo' width="80" height="91">
					<br/><br />
					<ul id='menu'>
						<li>
							<a >برنامه هفتگی</a>
								<ul>
									<?php $majors=mysql_query("select * from major order by mname");
										  while($mjrow=mysql_fetch_assoc($majors)):?>
										  <li><a ><?php echo $mjrow['mname'];?></a>
											<ul>
												<?php 
												$mid=$mjrow['mid'];
												$entries=mysql_query("select * from major where mid=$mid");
												$erow=mysql_fetch_assoc($entries);?>
												<?php 
													if($erow['kardani_p']):?>
													<li><a href='main.php?major=<?php echo $mid;?>&level=1'>کاردانی پیوسته</a></li>
												<?php endif;?>
                                                <?php 
													if($erow['kardani_n']):?>
													<li><a href='main.php?major=<?php echo $mid;?>&level=2'>کاردانی ناپیوسته</a></li>
												<?php endif;?>
												<?php	if($erow['karshenasi_p']):?>
													<li><a href='main.php?major=<?php echo $mid;?>&level=3'>کارشناسی پیوسته</a></li>
												<?php endif;?>
												<?php	if($erow['karshenasi_n']):?>
													<li><a href='main.php?major=<?php echo $mid;?>&level=4'>کارشناسی ناپیوسته</a></li>
												<?php endif;?>
												<?php	if($erow['karshenasi_a']):?>
													<li><a href='main.php?major=<?php echo $mid;?>&level=5'>کارشناسی ارشد</a></li>
												<?php endif;?>
											</ul>
										  </li>
									<?php endwhile;?>
								</ul>
						</li>
						<li>
							<a href='t_program.php' >برنامه اساتید</a>
						</li>
						<li>
							<a href='c_program.php' >برنامه کلاسها </a>
						</li>
						<li>
							<a href='teacher.php' >اساتید</a>
						</li>
						<li>
							<a href='course.php' >دروس</a>
						</li>
						<li>
							<a href='class.php' >کلاس ها</a>
						</li>
						<li>
							<a href='settings.php' >تنظیمات</a>
						</li>
					</ul>
				</div>
			</td>
            				<script>
				$('#menu').menu({position:{my:"right top", at:"left top"}});
				</script>
			<!------------------------------------------------------------------------------->
<td valign="top" style='padding:5pt;font-family:tahoma;font-size:9pt;'>
<form action='<?php echo $_SERVER['PHP_SELF'];?>' method='get'>
	<?php if($uid==1):?>
	<input type='hidden' name='did' id='did' value="-1">
	<p>
		<hr />
	</p>
    <div>
			گروه: <select id='dpt' name='dpt'>
					<option value='-1'>[ انتخاب شود ]</option>
					<?php $result=mysql_query("select * from dpt");
					while($row=mysql_fetch_assoc($result)):?>
					<option value='<?php echo $row['dptid'];?>'><?php echo $row['dname']; ?></option>
					<?php endwhile;?>
				  </select>
	</div>
	<hr/>
	<div>
			رشته: <select id='major' name='major'>
				  </select>
	</div>
	<hr/>
	<div>
			مقطع تحصیلی:<br>
					<input type='checkbox' name='pkrd' id='pkrd'>کاردانی پیوسته<br/>
                    <input type='checkbox' name='nkrd' id='nkrd'>کاردانی ناپیوسته<br/>
					<input type='checkbox' name='pkrsh' id='pkrsh'>کارشناسی پیوسته<br/>
					<input type='checkbox' name='nkrsh' id='nkrsh'>کارشناسی ناپیوسته<br/>
					<input type='checkbox' name='akrsh' id='akrsh'>کارشناسی ارشد<br/>
					
	</div>
	<hr/>
	<div>
			ورودیها:<br/> 
					<?php $rst=mysql_query("select * from entry order by ename");
					while($r=mysql_fetch_assoc($rst)):?>
					<input type='checkbox' name='<?php echo "er_".$r['eid']; ?>' id='<?php echo "er_".$r['eid']; ?>'><?php echo $r['ename']; ?><br/>
					<?php endwhile;?>
	</div>
	<hr/>
	<div>
	تعداد دانشجویان:
	<input type='text' name='stdnum' id='stdnum' size='4'>
	</div>
	<hr/>
    <?php endif;?>
	<div>
		<a id='change_pass' href='#'>تغییر رمز عبور</a>
        <div id='change_passdiv' style='display:none;'>
        	old password: <input type='password' name='old_pass' />
            <?php 
			if($changepass)
			{
				$oldpass=$_GET['old_pass'];
				$userresult=mysql_query("select * from users where id=$uid and password='$oldpass'");
				if(mysql_num_rows($userresult)==0)
				{
						$changepass=false;
						echo "<span style='color:red'>wrong password!</span>";
				}
					
			}
			?>
            <br/>
            new password: <input type='password' name='new_pass'/><br/>
            confirm pass: <input type='password' name='confirm_pass'/>
            <?php 
			if($changepass)
			{
				$newpass=$_GET['new_pass'];
				$confirm=$_GET['confirm_pass'];
				if($newpass==$confirm && $newpass!='')
				{
				mysql_query("update users set password='$newpass' where id=$uid");	
				echo "<span style='color:red'>Password changed successfully!</span>";
				}else
				{
					$changepass=false;
					echo "<span style='color:red'>Error</span>";
				}
					
			}?>
            <br/>
        </div>
	</div>
	<hr/>
	<input id='save' type='submit' value='save' />
	
</form>
			<!------------------------------------------------------------------------------->
			</td>
		</tr>
	</table>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/settings.js"></script>
</body>
</html>