<?php
	include ('php/authority.php');
	$uid=$_SESSION['user_id'];
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		$clid=$_POST["clid"];
		$capacity=$_POST["capacity"];
		if(isset($_POST["data"]) && $_POST["data"]=='on')
			$data=1;
		else
			$data=0;
		$sql="insert into class values($clid,$capacity,$data,true)";
		$result=mysql_query($sql);
		//if($result)
		//	echo 'Saved!';		
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
				<td valign="top">
			<!------------------------------------------------------------------------------->
<?php  if($uid==1):?>
<form action='class.php' method='post'>
	<table>
		<tr>
			<td>شماره کلاس:</td><td><input type='text' name='clid'></td>
		</tr>
		<tr>
			<td>ظرفیت:</td><td><input type='text' name='capacity'></td>
		</tr>
		<tr>
			<td>ویدئو پروژکتور:</td><td><input type='checkbox' name='data'></td>
		</tr>
		<tr>
			<td><input type='submit' value='save'></td>
			<td><a href='main.php'>بازگشت</a></td>
		</tr>
	</table>
</form>
<?php endif;?>
<table class='table' style='width:100%'>
	<tr class='row'>
        <th class='head'></th>
		 <th class='head'></th>
		<th class='head'>شماره کلاس</th>
        <th class='head'>ظرفیت</th>
		<th class='head'>ویدئو پروژکتور</th>
		<th class='head'>آتلیه</th>
		<th class='head'>آزمایشگاه</th>
    </tr>
	<?php
		$result=mysql_query('select * from class order by 1');
		if($result)
		{
			while($row=mysql_fetch_assoc($result)):?>
			<tr class='row' >
				<td class='col'><input class='edit' value='<?php echo $row["id"];?>' 
				type='image' width="20" height="20" src='pic/edit.png'></input></td>
				<td class='col'><input class='delete' value='<?php echo $row["id"];?>' 
				type='image' width="20" height="20" src='pic/delete.png'></input></td>
				<td class='col'><?php echo $row['clid'];?></td>
				<td class='col'><?php echo $row['capacity'];?></td>
				<td class='col'><?php if ($row['type']=='D'||$row['type']=='AD') echo '*';?></td>
				<td class='col'><?php if ($row['type']=='A'||$row['type']=='AD') echo '*';?></td>
				<td class='col'><?php if ($row['type']=='L') echo $row['cname'];?></td>
			</tr>
			<?php endwhile;
		}
	?>
	</table>
			<!------------------------------------------------------------------------------->
			</td>
		</tr>
	</table>
</body>
</html>