<!-- ALTER TABLE program AUTO_INCREMENT =1111-->
<?php 
	include('php/authority.php');
	
	$level=-1;
	$term='اول 92-93';
	$mid=-1;
	$entry=-1;

	$uid=$_SESSION['user_id'];


	if($_SERVER['REQUEST_METHOD']=='GET')
	{
		if(isset($_GET['level']))
			$level=$_GET['level'];
		if(isset($_GET['term']))
			$term=$_GET['term'];
		if(isset($_GET['major']))
			$mid=$_GET['major'];
		if(isset($_GET['entry']))
			$entry=$_GET['entry'];
	}

	if($mid!=-1)
	{
		$mrows=mysql_query("select * from major where mid=$mid");
		$mrow=mysql_fetch_assoc($mrows);
	}
	else
	{
		$dpt=mysql_query("select major.* from dpt ,major , dpt_user where dpt_user.uid=$uid and major.dptid=dpt.dptid and dpt_user.dptid=dpt.dptid");
		$mrow=mysql_fetch_assoc($dpt);
		$mid=$mrow['mid'];
		if($mrow['karshenasi_a']) $level=5;
		if($mrow['karshenasi_n']) $level=4;
		if($mrow['karshenasi_p']) $level=3;
		if($mrow['kardani_n']) $level=2;
		if($mrow['kardani_p']) $level=1;
	}
	
	if($entry==-1)
	{
		$entryresult=mysql_query("select eid from major_entry where mid=$mid");
		$row=mysql_fetch_assoc($entryresult);
		$entry=$row['eid'];	
	}
	$sql="select * from program,teacher,course	where level=$level and term='$term' and mid=$mid and entryid=$entry and program.cid=course.cid and program.tid=teacher.tid";
	$resultsections=mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <title>برنامه هفتگی</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="css/main.css" />
	<link rel="stylesheet" type='text/css' href="css/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.ui.all.css" />
</head>
<body dir="rtl">

		<div id='overlay'></div>
		<div id='wait' align='center' valign='center'>
			<strong>در حال تماس با سرور, لطفا چند لحظه منتظر باشید...</strong>
			<img src='pic/loading.gif' alt='' width='20pt'>
		</div>
		<div id='crs' align='center'>hi every one</div>
    <div id='crsdialog' title='' dir='rtl' align='center' valign='center' style="font-family:tahoma;font-size:9pt">
		<input id='pidcrs' type='hidden' value='-1'/>
		<table width='100%'>
				<tr>
			<td>
				روز :
			</td>
			<td colspan="2">
				<select id='daycrs' class='datetime'>
						<option value='1'>شنبه</option>
						<option value='2'>یکشنبه</option>
						<option value='3'>دوشنبه</option>
						<option value='4'>سه شنبه</option>
						<option value='5'>چهار شنبه</option>
						<option value='6'>پنج شنبه</option>
					</select>
			</td>
		</tr>
        <tr>
		<td>
			ساعت :
		</td>
		<td>
			از
		<select id='fromcrs' class='datetime'>
			<option value='1'>08:00</option>
			<option value='2'>08:45</option>
			<option value='3'>09:45</option>
			<option value='4'>10:45</option>
			<option value='5'>11:45</option>
			<option value='6'>12:30</option>
			<option value='7'>14:00</option>
			<option value='8'>14:45</option>
			<option value='9'>15:45</option>
			<option value='10'>16:30</option>
			<option value='11'>17:30</option>
			<option value='12'>18:15</option>
		</select>
		</td>
		<td>
		تا
		<select id='tocrs' class='datetime'>
			<option value='1'>08:45</option>
			<option value='2'>09:30</option>
			<option value='3'>10:30</option>
			<option value='4'>11:30</option>
			<option value='5'>12:30</option>
			<option value='6'>13:15</option>
			<option value='7'>14:45</option>
			<option value='8'>15:30</option>
			<option value='9'>16:30</option>
			<option value='10'>17:15</option>
			<option value='11'>18:15</option>
			<option value='12'>19:00</option>
		</select>
		</td>
		</tr>

        <tr>
			<td>
				نام درس :
			</td>
			<td colspan='2'>
				<select id='coursecrs'>
				<option value='-1' unit='-1' selected='selected'>[ انتخاب شود ]</option>
				<?php
						$sql="select course.* from course, crs_major where course.cid=crs_major.cid and crs_major.level=$level and crs_major.mid=$mid order by cname";
						
						$result=mysql_query($sql);
						while($row=mysql_fetch_assoc($result)):
				?>
					<option value="<?php echo $row['cid'];?>" unit="<?php echo $row['unit']?>"><?php echo $row['cname'];?></option>
				<?php endwhile?>
				</select>
			</td>
	   </tr>
		
		<tr>
			<td>
			نام استاد :
			</td>
			<td colspan='2'>
			<select id='teachercrs'>
			<option value='-1' selected='selected'>[ انتخاب شود ]</option>
			<?php
				$sql="select * from teacher order by family, name";
				
				$result=mysql_query($sql);
				while($row=mysql_fetch_assoc($result)):
			?>
			<option value="<?php echo $row['tid'];?>"><?php echo $row['name'].' '.$row['family'];?></option>
			<?php endwhile?>
			</select>
			</td>
		</tr>
		<tr>
		<td>شماره کلاس :</td>
		<td colspan='2'>
			<select id='classes'>
				<option value='-1' selected='selected'>[ انتخاب شود ]</option>
					<?php
						$sql="select * from class";
							$result=mysql_query($sql);
								while($row=mysql_fetch_assoc($result)):
					?>
					<option value="<?php echo $row['clid'];?>"><?php echo $row['clid'];?></option>
	  			<?php endwhile?>
			</select><img alt='loading' src='pic/loading.gif' width="15" height="15" id='cls_img_loading' style='display:none;'/>
		</td>
		</tr>
		</table>
		<input id='addcrs' type='button' value='اضافه'/>
		<input id='editcrs' type='button' value='ویرایش'/>
		<input id='deletecrs' type='button' value='حذف'/>
		<input id='cancelcrs' type='button' value='انصراف'/>
	</div>

	    <table style="width: 100%; height: 100%;" cellpadding="0" cellspacing="0">
		<tr style="height: 5%" bgcolor="#618CD1">
			<td  >
				<a href='./php/login.php'>خروج</a>
			</td>
			<td>
			<!---------------------------------------------------------------------------->
				<form id='frm' action='main.php' method='get'>
					<p class="MsoNormal" >
						<b>
						<span  style="font-size:14.0pt;font-family:B_Compset">برنامه هفتگي مقطع</span></b><span
							style="font-size:14.0pt;font-family:B_Compset">
						:<b> </b>
					
						<select class='options' id='level' name='level'>
							<?php if($mrow['kardani_p']):?>
								<option value='1' <?php if ($level=='1'):?>selected='selected'<?php endif;?>>کاردانی پیوسته</option>
							<?php endif;?>
                            <?php if($mrow['kardani_n']):?>
								<option value='2' <?php if ($level=='2'):?>selected='selected'<?php endif;?>>کاردانی ناپیوسته</option>
							<?php endif;?>
							<?php if($mrow['karshenasi_p']):?>
								<option value='3' <?php if ($level=='3'):?>selected='selected'<?php endif;?>>کارشناسی پیوسته</option>
							<?php endif;?>
							<?php if($mrow['karshenasi_n']):?>
								<option value='4' <?php if ($level=='4'):?>selected='selected'<?php endif;?>>کارشناسی ناپیوسته</option>
							<?php endif;?>
							<?php if($mrow['karshenasi_a']):?>
								<option value='5' <?php if ($level=='5'):?>selected='selected'<?php endif;?>>کارشناسی ارشد</option>
							<?php endif;?>

						</select>
						
						<b><span style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</span>نيمسال</b> :<b> </b>
						<select class='options' id='term' name='term' disabled='disabled'>
							<option <?php if ($term=='اول 92-93'):?>selected='selected'<?php endif;?>>اول 92-93</option>
							<option <?php if ($term=='دوم 91-92'):?>selected='selected'<?php endif;?>>دوم 91-92</option>
							<option <?php if ($term=='اول 91-92'):?>selected='selected'<?php endif;?>>اول 91-92</option>
						</select><b><span style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</span>رشته</b> :
						<select class='options' id='major' name='major'>
						    <?php $majorresult=mysql_query("select * from major order by mname");
								  while($mjrrow=mysql_fetch_assoc($majorresult)):?>
									<option value='<?php echo $mjrrow['mid']; ?>' <?php if ($mid==$mjrrow['mid']):?>selected='selected'<?php endif;?>><?php echo $mjrrow['mname'];?></option>
								  <?php endwhile;?>
							</select><b><span style="">&nbsp;&nbsp;&nbsp;&nbsp;
						</span>ورودی</b> :<b> </b>
						<select class='options' id='entry' name='entry'>
							<?php $entry_result=mysql_query("select * from major_entry, entry where major_entry.mid=$mid and major_entry.eid=entry.eid order by ename");
								  while($entry_row=mysql_fetch_assoc($entry_result)):?>
							<option value='<?php echo $entry_row['eid'];?>' <?php if ($entry==$entry_row['eid']):?>selected='selected'<?php endif;?>><?php echo $entry_row['ename'];?></option>
							<?php endwhile;?>
						</select>
						</span>
						</p>
				</form>

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
												$mn_mid=$mjrow['mid'];
												$entries=mysql_query("select * from major where mid=$mn_mid");
												$erow=mysql_fetch_assoc($entries);?>
												<?php 
													if($erow['kardani_p']):?>
													<li><a href='main.php?major=<?php echo $mn_mid;?>&level=1'>کاردانی پیوسته</a></li>
												<?php endif;?>
                                                <?php 
													if($erow['kardani_n']):?>
													<li><a href='main.php?major=<?php echo $mn_mid;?>&level=2'>کاردانی ناپیوسته</a></li>
												<?php endif;?>
												<?php	if($erow['karshenasi_p']):?>
													<li><a href='main.php?major=<?php echo $mn_mid;?>&level=3'>کارشناسی پیوسته</a></li>
												<?php endif;?>
												<?php	if($erow['karshenasi_n']):?>
													<li><a href='main.php?major=<?php echo $mn_mid;?>&level=4'>کارشناسی ناپیوسته</a></li>
												<?php endif;?>
												<?php	if($erow['karshenasi_a']):?>
													<li><a href='main.php?major=<?php echo $mn_mid;?>&level=5'>کارشناسی ارشد</a></li>
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
                        <?php if($uid==1):?>
                        <li>
                        	<a href='php/users.php'>کاربران</a>
                        </li>
                        <?php endif;?>
					</ul>
				</div>
                <br/>
                <div id='borrows_crs'>
						لیست دروس مشترک:
    					<?php
						if(isset($_SESSION['br_list']))
							foreach($_SESSION['br_list'] as $br):
								$br_result=mysql_query("select * from program, course,entry,major where program.cid=course.cid and program.entryid=entry.eid and program.mid=major.mid and pid=$br");
								if(mysql_num_rows($br_result)==1):
									
									$br_row=mysql_fetch_assoc($br_result);
										?>
											<div class='brrow_select' pid='<?php echo $br_row['pid'];?>'
                                			style="background-color:yellow;margin:2pt;border:1pt solid black;">
                       			
                       						<img class='br_remove' style="width:15px;height:15px;display:none;cursor:pointer" src="pic/Actions-window-close-icon.png"   href="pic" />
                                			<img class='br_add' style="width:15px;height:15px;display:none;cursor:pointer" src="pic/add-icon.png"    href="pic" />
											<?php echo $br_row['cname'];?>&nbsp;<?php 
						switch($br_row['level'])
						{
							case 1: echo 'کاردانی پیوسته'; break;
							case 2: echo 'کاردانی ناپیوسته';break;
							case 3: echo 'کارشناسی پیوسته';break;
							case 4: echo 'کارشناسی ناپیوسته';break;
							case 5: echo 'کارشناسی ارشد';break; 	
						}?>&nbsp;نرم&nbsp;<?php echo $br_row['term'];?>
						ورودی&nbsp;
						<?php echo $br_row['ename'];?>&nbsp;رشته
						&nbsp;
						<?php echo $br_row['mname'];?>
						
						</div>
						<?php endif;
						endforeach;?>                    
				</div>
			</td>
	        <td>
            <table border="0" cellpadding="0" cellspacing="0" width='100%'>
                 <tr>
                    <td width="80%" valign="top">
            <table id='xtable' border="1" cellpadding="0" cellspacing="0" class="MsoNormalTable"
             style="margin-left:-.8in;border-collapse:collapse;border:none" width="100%">
            <tr style="height:19.15pt">
                <td colspan="11" style="border-top:double 4.5pt;
  border-left:double 1.5pt;border-bottom:solid 1.0pt;border-right:solid 1.0pt;
  border-color:windowtext;
  height:19.15pt" valign="top" width="57%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:17.0pt;font-family:B_Compset">صبح</span><span  style="font-size:18.0pt;font-family:B_Compset
  "></span></b></p>
                </td>
                <td colspan="6" style="border-top:double windowtext 4.5pt;
  border-left:double windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
  border-right:none;
  height:19.15pt" valign="top" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:18.0pt;font-family:B_Compset">بعدازظهر</span></b></p>
                </td>
            </tr>
            <tr style=";page-break-inside:avoid;height:31.7pt">
                <td colspan="2" style="border:solid windowtext 1.0pt;
  border-top:none;

  height:31.7pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset"><span style=""> </span>ساعت</span></b></p>
                    <p class="MsoNormal" >
                        <span  style="font-size:13.0pt;font-family:
  B_Compset"><span style="">&nbsp;</span></span><b><span
                             style="font-family:B_Compset">روز</span></b></p>
                    <p class="MsoNormal" >
                        <b>
                        <span  style="
  font-family:B_Compset">گروه</span></b></p>
                </td>
                <td colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;
  border-right:none;height:31.7pt" width="7%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset">8 </span></b>
                    </p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset">تا </span></b>
                    </p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset">8:45</span></b></p>
                </td>
                <td style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;
  ;padding:
  0in 5.4pt 0in 5.4pt;height:31.7pt" width="7%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset">8:45 </span></b>
                    </p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset">تا </span></b>
                    </p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset">9:30</span></b></p>
                </td>
                <td style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;
  height:31.7pt" width="7%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset">9:45</span></b></p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset"><span style="">&nbsp;</span>تا</span></b></p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset"><span style="">&nbsp;</span>10:30</span></b></p>
                </td>
                <td
                    style="border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;
  ;padding:
  0in 5.4pt 0in 5.4pt; border-right-style: none; border-right-color: inherit; border-right-width: medium; border-top-style: none; border-top-color: inherit; border-top-width: medium;"
                    width="7%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset">10:45 </span></b>
                    </p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset">تا</span></b></p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset">11:30 </span></b>
                    </p>
                </td>
                <td colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;
  border-right:none;
  ;height:31.7pt" width="7%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:11.0pt;font-family:B_Compset">11:45 </span></b>
                    </p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:11.0pt;font-family:B_Compset">تا </span></b>
                    </p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:11.0pt;font-family:B_Compset">12:30</span><span  style="font-size:11.0pt;"></span></b></p>
                </td>
                <td style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;
  ;padding:
  0in 5.4pt 0in 5.4pt;height:31.7pt" width="7%">
                    <p align="center" class="MsoNormal" style="margin-top:0in;margin-right:
  5.65pt;margin-bottom:0in;margin-left:5.65pt;margin-bottom:.0001pt;text-align:
  center;direction:ltr;unicode-bidi:embed">
                        <b>
                        <span   style="font-size:10.0pt;font-family:B_Compset">12:30</span><span style="font-size:10.0pt;
  "></span></b></p>
                    <p align="center" class="MsoNormal" style="margin-top:0in;margin-right:
  5.65pt;margin-bottom:0in;margin-left:5.65pt;margin-bottom:.0001pt;text-align:
  center;direction:ltr;unicode-bidi:embed">
                        <b><span
                            style="font-size:11.0pt;font-family:B_Compset">
                        تا</span></b></p>
                    <p align="center" class="MsoNormal"  style="margin-top:0in;margin-right:
  5.65pt;margin-bottom:0in;margin-left:5.65pt;margin-bottom:.0001pt;text-align:center;direction:ltr;unicode-bidi:embed">
                        <b><span
                            style="font-size:10.0pt;font-family:B_Compset">
                        13:15</span></b></p>
                </td>
                <td style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;
  ;padding:
  0in 5.4pt 0in 5.4pt;height:31.7pt" width="7%">
                    <p align="center" class="MsoNormal"  style="margin-top:0in;margin-right:
  5.65pt;margin-bottom:0in;margin-left:5.65pt;margin-bottom:.0001pt;text-align:
  center;direction:ltr;unicode-bidi:embed">
                        <b><span
                            style="font-size:11.0pt;font-family:B_Compset">
                        <span style="">&nbsp;</span>13 </span></b>
                    </p>
                    <p align="center" class="MsoNormal"  style="margin-top:0in;margin-right:
  5.65pt;margin-bottom:0in;margin-left:5.65pt;margin-bottom:.0001pt;text-align:
  center;direction:ltr;unicode-bidi:embed">
                        <b><span
                            style="font-size:11.0pt;font-family:B_Compset">
                        تا</span></b></p>
                    <p align="center" class="MsoNormal"  style="margin-top:0in;margin-right:
  5.65pt;margin-bottom:0in;margin-left:5.65pt;margin-bottom:.0001pt;text-align:
  center;direction:ltr;unicode-bidi:embed">
                        <b><span
                            style="font-size:11.0pt;font-family:B_Compset">
                        14</span></b></p>
                </td>
                <td style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;
  ;
  height:31.7pt" width="7%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset">14</span></b></p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset">تا</span></b></p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset">14:45</span></b></p>
                </td>
                <td style="border-top:none;
  border-left:double windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
  border-right:none;
  ;height:31.7pt" width="7%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset">14:45</span></b></p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset">تا</span></b></p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset">15:30</span></b></p>
                </td>
                <td style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;
  border-right:none;
  ;height:31.7pt" width="7%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset">15:45</span></b></p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset"><span style="">&nbsp;</span>تا</span></b></p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset"><span style="">&nbsp;</span>16:30</span></b></p>
                </td>
                <td style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;
  ;padding:
  0in 5.4pt 0in 5.4pt;height:31.7pt" width="7%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset">16:30 </span></b>
                    </p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset">تا</span></b></p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="
  font-family:B_Compset">17:15</span></b></p>
                </td>
                <td style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;padding:
  0in 5.4pt 0in 5.4pt;height:31.7pt" width="7%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:11.0pt;font-family:B_Compset">17:30 </span></b>
                    </p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:11.0pt;font-family:B_Compset">تا </span></b>
                    </p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:11.0pt;font-family:B_Compset">18:15</span><span  style="font-size:11.0pt;"></span></b></p>
                </td>
                <td style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;
  ;padding:
  0in 5.4pt 0in 5.4pt;height:31.7pt" width="7%">
                    <p align="center" class="MsoNormal"  style="margin-top:0in;margin-right:
  5.65pt;margin-bottom:0in;margin-left:5.65pt;margin-bottom:.0001pt;text-align:
  center;direction:ltr;unicode-bidi:embed">
                        <b>
                        <span   style="font-size:10.0pt;font-family:B_Compset">18:15</span><span style="font-size:10.0pt;
  "></span></b></p>
                    <p align="center" class="MsoNormal"  style="margin-top:0in;margin-right:
  5.65pt;margin-bottom:0in;margin-left:5.65pt;margin-bottom:.0001pt;text-align:
  center;direction:ltr;unicode-bidi:embed">
                        <b><span
                            style="font-size:11.0pt;font-family:B_Compset">
                        تا</span></b></p>
                    <p align="center" class="MsoNormal"  style="margin-top:0in;margin-right:
  5.65pt;margin-bottom:0in;margin-left:5.65pt;margin-bottom:.0001pt;text-align:
  center;direction:ltr;unicode-bidi:embed">
                        <b><span
                            style="font-size:11.0pt;font-family:B_Compset">
                        19</span></b></p>
                </td>

            </tr>

            <tr style="page-break-inside:avoid;height:25pt">
                <td rowspan="2" style="width:44.85pt;border:solid windowtext 1.0pt;
  border-top:none;
  height:15.75pt" width="7%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">شنبه</span></b></p>
                </td>
                <td style="width:17.85pt;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;
  height:25pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">1</span></b></p>
                </td>
                <td  class='cell' free='true' time='1' day='1' sec='1'  colspan="2" style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >

                </td>
                <td class='cell' free='true' time='2' day='1' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >

                </td>
                <td class='cell' free='true' time='3' day='1' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:solid windowtext 1.0pt;" >

                </td>
                <td class='cell' free='true' time='4' day='1' sec='1'
                    style="border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;
  ; border-right-style: none; border-right-color: inherit; border-right-width: medium; border-top-style: none; border-top-color: inherit; border-top-width: medium;"
                    >

                </td>
                <td class='cell' free='true' time='5' day='1' sec='1'  colspan="2" style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:solid windowtext 1.0pt;" >

                </td>
                <td class='cell' free='true' time='6' day='1' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >

                </td>
                <td rowspan="12"
                    style="width: .5in; border-top: none; border-left: double windowtext 1.5pt; border-bottom: double windowtext 4.5pt; border-right: none;        background: #D9D9D9; padding: 0in 5.4pt 0in 5.4pt;  height: 15.75pt"
                    >
                    <p align="center" class="MsoNormal"  style="margin-top:0in;margin-right:
  5.65pt;margin-bottom:0in;margin-left:5.65pt;margin-bottom:.0001pt;text-align:
  center">
                        <b>
                        <span  style="font-size:17.0pt;
  font-family:B_Compset">نماز و نهار</span><span  style="font-size:18.0pt;font-family:B_Compset
  "></span></b></p>
                </td>
                <td class='cell' free='true' time='7' day='1' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='8' day='1' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='9' day='1' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='10' day='1' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='11' day='1' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='12' day='1' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>

            </tr>
            <tr style="page-break-inside:avoid;height:25pt">
                <td style="border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;
  height:25pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">2</span></b></p>
                </td>
                <td class='cell' free='true' time='1' day='1' sec='2'  colspan="2" style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >

                </td>
                <td class='cell' free='true' time='2' day='1' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='3' day='1' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='4' day='1' sec='2'
                    style="border-left:double windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right-style: none; border-right-color: inherit; border-right-width: medium; border-top-style: none; border-top-color: inherit; border-top-width: medium;">&nbsp;
                    </td>
                <td class='cell' free='true' time='5' day='1' sec='2'  colspan="2" style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='6' day='1' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='7' day='1' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='8' day='1' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='9' day='1' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='10' day='1' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='11' day='1' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='12' day='1' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
            </tr>

            <tr style="height:25pt">
                <td rowspan="2" style="border:solid windowtext 1.0pt;
  border-top:none;
  height:25.5pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">يکشنبه</span></b></p>
                </td>
                <td style="border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;
  height:25pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">1</span></b></p>
                </td>
                <td class='cell' free='true' time='1' day='2' sec='1'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:dotted windowtext 1.0pt;
  border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='2' day='2' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='3' day='2' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:solid windowtext 1.0pt;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='4' day='2' sec='1'
                    style="border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;
  ; border-right-style: none; border-right-color: inherit; border-right-width: medium; border-top-style: none; border-top-color: inherit; border-top-width: medium;"
                    valign="top" class="style10">
                    &nbsp;</td>
                <td class='cell' free='true' time='5' day='2' sec='1'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:dotted windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='6' day='2' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='7' day='2' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='8' day='2' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='9' day='2' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='10' day='2' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='11' day='2' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='12' day='2' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;
  ;height:25.5pt" valign="top" >&nbsp;
                    </td>

            </tr>
            <tr style="height:27.75">
                <td style="border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;  height:25pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">2</span></b></p>
                </td>
                <td class='cell' free='true' time='1' day='2' sec='2'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;
  border-right:none;" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='2' day='2' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='3' day='2' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='4' day='2' sec='2'
                    style="border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;
  ;
   border-right-style: none; border-right-color: inherit; border-right-width: medium; border-top-style: none; border-top-color: inherit; border-top-width: medium;"
                    valign="top" class="style11">
                    &nbsp;</td>
                <td class='cell' free='true' time='5' day='2' sec='2'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='6' day='2' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='7' day='2' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='8' day='2' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='9' day='2' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none" >&nbsp;
                    </td>
                <td class='cell' free='true' time='10' day='2' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='11' day='2' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='12' day='2' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
            </tr>

            <tr style="height:25pt">
                <td rowspan="2" style="border:solid windowtext 1.0pt;
  border-top:none;
  height:25.5pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">دوشنبه</span></b></p>
                </td>
                <td style="border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;
  height:25pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">1</span></b></p>
                </td>
                <td class='cell' free='true' time='1' day='3' sec='1'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:dotted windowtext 1.0pt;
  border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='2' day='3' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='3' day='3' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:solid windowtext 1.0pt;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='4' day='3' sec='1'
                    style="border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;
  ; border-right-style: none; border-right-color: inherit; border-right-width: medium; border-top-style: none; border-top-color: inherit; border-top-width: medium;"
                    valign="top" class="style10">
                    &nbsp;</td>
                <td class='cell' free='true' time='5' day='3' sec='1'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:dotted windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='6' day='3' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='7' day='3' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='8' day='3' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='9' day='3' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='10' day='3' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='11' day='3' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='12' day='3' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;
  ;height:25.5pt" valign="top" >&nbsp;
                    </td>

            </tr>
            <tr style="height:27.75">
                <td style="border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;  height:25pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">2</span></b></p>
                </td>
                <td class='cell' free='true' time='1' day='3' sec='2'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;
  border-right:none;" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='2' day='3' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='3' day='3' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='4' day='3' sec='2'
                    style="border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;
  ;
   border-right-style: none; border-right-color: inherit; border-right-width: medium; border-top-style: none; border-top-color: inherit; border-top-width: medium;"
                    valign="top" class="style11">
                    &nbsp;</td>
                <td class='cell' free='true' time='5' day='3' sec='2'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='6' day='3' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='7' day='3' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='8' day='3' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='9' day='3' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none" >&nbsp;
                    </td>
                <td class='cell' free='true' time='10' day='3' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='11' day='3' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='12' day='3' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
            </tr>

            <tr style="height:25pt">
                <td rowspan="2" style="border:solid windowtext 1.0pt;
  border-top:none;
  height:25.5pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">سه‌شنبه</span></b></p>
                </td>
                <td style="border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;
  height:25pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">1</span></b></p>
                </td>
                <td class='cell' free='true' time='1' day='4' sec='1'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:dotted windowtext 1.0pt;
  border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='2' day='4' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='3' day='4' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:solid windowtext 1.0pt;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='4' day='4' sec='1'
                    style="border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;
  ; border-right-style: none; border-right-color: inherit; border-right-width: medium; border-top-style: none; border-top-color: inherit; border-top-width: medium;"
                    valign="top" class="style10">
                    &nbsp;</td>
                <td class='cell' free='true' time='5' day='4' sec='1'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:dotted windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='6' day='4' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='7' day='4' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='8' day='4' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='9' day='4' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='10' day='4' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='11' day='4' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='12' day='4' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;
  ;height:25.5pt" valign="top" >&nbsp;
                    </td>

            </tr>
            <tr style="height:27.75">
                <td style="border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;  height:25pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">2</span></b></p>
                </td>
                <td class='cell' free='true' time='1' day='4' sec='2'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;
  border-right:none;" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='2' day='4' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='3' day='4' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='4' day='4' sec='2'
                    style="border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;
  ;
   border-right-style: none; border-right-color: inherit; border-right-width: medium; border-top-style: none; border-top-color: inherit; border-top-width: medium;"
                    valign="top" class="style11">
                    &nbsp;</td>
                <td class='cell' free='true' time='5' day='4' sec='2'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='6' day='4' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='7' day='4' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='8' day='4' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='9' day='4' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none" >&nbsp;
                    </td>
                <td class='cell' free='true' time='10' day='4' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='11' day='4' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='12' day='4' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
            </tr>

             <tr style="height:25pt">
                <td rowspan="2" style="border:solid windowtext 1.0pt;
  border-top:none;
  height:25.5pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">چهارشنبه</span></b></p>
                </td>
                <td style="border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;
  height:25pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">1</span></b></p>
                </td>
                <td class='cell' free='true' time='1' day='5' sec='1'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:dotted windowtext 1.0pt;
  border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='2' day='5' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='3' day='5' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:solid windowtext 1.0pt;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='4' day='5' sec='1'
                    style="border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;
  ; border-right-style: none; border-right-color: inherit; border-right-width: medium; border-top-style: none; border-top-color: inherit; border-top-width: medium;"
                    valign="top" class="style10">
                    &nbsp;</td>
                <td class='cell' free='true' time='5' day='5' sec='1'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:dotted windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='6' day='5' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='7' day='5' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='8' day='5' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='9' day='5' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='10' day='5' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='11' day='5' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='12' day='5' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;
  ;height:25.5pt" valign="top" >&nbsp;
                    </td>

            </tr>
            <tr style="height:27.75">
                <td style="border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;  height:25pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">2</span></b></p>
                </td>
                <td class='cell' free='true' time='1' day='5' sec='2'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;
  border-right:none;" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='2' day='5' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='3' day='5' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='4' day='5' sec='2'
                    style="border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;
  ;
   border-right-style: none; border-right-color: inherit; border-right-width: medium; border-top-style: none; border-top-color: inherit; border-top-width: medium;"
                    valign="top" class="style11">
                    &nbsp;</td>
                <td class='cell' free='true' time='5' day='5' sec='2'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='6' day='5' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='7' day='5' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='8' day='5' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='9' day='5' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none" >&nbsp;
                    </td>
                <td class='cell' free='true' time='10' day='5' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='11' day='5' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='12' day='5' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
            </tr>

            <tr style="height:25pt">
                <td rowspan="2" style="border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:double windowtext 4.5pt;border-right:solid windowtext 1.0pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">پنج‌شنبه</span></b></p>
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset"></span></b></p>
                </td>
                <td style="border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;
  height:25pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">1</span></b></p>
                </td>
                             <td class='cell' free='true' time='1' day='6' sec='1'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:dotted windowtext 1.0pt;
  border-right:none" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='2' day='6' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='3' day='6' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:solid windowtext 1.0pt;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='4' day='6' sec='1'
                    style="border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;
 border-right-style: none; border-right-color: inherit; border-right-width: medium; border-top-style: none; border-top-color: inherit; border-top-width: medium;"
                    valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='5' day='6' sec='1'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:dotted windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;" valign="top"
                    >&nbsp;
                    </td>
                <td class='cell' free='true' time='6' day='6' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='7' day='6' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='8' day='6' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none" >&nbsp;
                    </td>
                <td class='cell' free='true' time='9' day='6' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='10' day='6' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='11' day='6' sec='1'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;height:26.25pt" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='12' day='6' sec='1'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:dotted windowtext 1.0pt;border-right:none;" valign="top" >&nbsp;
                    </td>

            </tr>
            <tr style="height:25pt">
                <td style="border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:double windowtext 4.5pt;border-right:none;
  ;
  height:25pt" >
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:13.0pt;font-family:B_Compset">2</span></b></p>
                </td>
              <td class='cell' free='true' time='1' day='6' sec='2'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:double windowtext 4.5pt;
  border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='2' day='6' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:double windowtext 4.5pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='3' day='6' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:double windowtext 4.5pt;border-right:solid windowtext 1.0pt" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='4' day='6' sec='2'
                    style="border-left:double windowtext 1.5pt;
  border-bottom:double windowtext 4.5pt;
  ; border-right-style: none; border-right-color: inherit; border-right-width: medium; border-top-style: none; border-top-color: inherit; border-top-width: medium;"
                    valign="top">&nbsp;
                    </td>
                <td class='cell' free='true' time='5' day='6' sec='2'  colspan="2" style="border-top:none;
  border-left:dashed windowtext 1.0pt;border-bottom:double windowtext 4.5pt;
  border-right:solid windowtext 1.0pt;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='6' day='6' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:double windowtext 4.5pt;border-right:none;" valign="top" >&nbsp;
                    </td>
   <td class='cell' free='true' time='7' day='6' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:double windowtext 4.5pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='8' day='6' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:double windowtext 4.5pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='9' day='6' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:double windowtext 4.5pt;border-right:none;" >&nbsp;
                    </td>
                <td class='cell' free='true' time='10' day='6' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:double windowtext 4.5pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='11' day='6' sec='2'  style="border-top:none;border-left:dashed windowtext 1.0pt;
  border-bottom:double windowtext 4.5pt;border-right:none;" valign="top" >&nbsp;
                    </td>
                <td class='cell' free='true' time='12' day='6' sec='2'  style="border-top:none;border-left:double windowtext 1.5pt;
  border-bottom:double windowtext 4.5pt;border-right:none;" valign="top" >&nbsp;
                    </td>
            </tr>

        </table>
        </td>
        <td valign="top">
          <table id='crstable' border="1" cellpadding="0" cellspacing="0" class="MsoNormalTable"

            style="margin-left:-.8in;border-collapse:collapse;border:none;" width="100%">
            <tr style=";height:19.15pt">
                <td style="border-top:double windowtext 4.5pt; border-left:double windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
				border-right:none;  height:19.15pt" width="45%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset">نام درس</span></b></p>
                </td>
                <td style="border-top:double windowtext 4.5pt; border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;  border-right:none;
					height:19.15pt">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:9.0pt;font-family:B_Compset">تعداد واحد</span><span  style="font-size:11.0pt;font-family:&quot;BCompset&quot;"></span></b></p>
                </td>
                <td style="border-top:double windowtext 4.5pt;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;height:19.15pt"
				width="45%">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset">نام استاد</span></b></p>
                </td>
            </tr>
		<?php
			if($resultsections)
				while($row=mysql_fetch_assoc($resultsections)):?>
					<tr pid='<?php echo $row['pid'];?>' class='section' bgcolor='#E4EFF8'>
					<td  height='31.7pt'><?php echo $row['cname'];?> </td>
					<td><?php echo $row['unit'];?></td>
					<td><?php echo $row['name'].' '.$row['family'];?></td>
					</tr>
				<?php endwhile;?>
        <?php
			$sql="select * from program,alias,teacher,course	where program.pid=alias.pid and alias.level=$level and alias.term='$term' and alias.mid=$mid and alias.entryid=$entry and alias.alias_cid=course.cid and program.tid=teacher.tid";
			
			$aliasresult=mysql_query($sql);
			if($aliasresult)
				while($row=mysql_fetch_assoc($aliasresult)):?>
					<tr pid='<?php echo $row['pid'];?>' class='alias' bgcolor='#C0C'>
					<td  height='31.7pt'><?php echo $row['cname'];?> </td>
					<td><?php echo $row['unit'];?></td>
					<td><?php echo $row['name'].' '.$row['family'];?></td>
					</tr>
				<?php endwhile;?>

        </table>
        </td>
                  </tr>
             </table>
            </td>
        </tr>
		</table>
	
<div id='brdialog'>
<input type='hidden' id='brpid' />
نام درس:
<br/><select id='brcrs' size='20'>
				<?php
				$sql="select course.* from course, crs_major where course.cid=crs_major.cid and crs_major.level=$level and crs_major.mid=$mid order by cname";
				$result=mysql_query($sql);
				while($row=mysql_fetch_assoc($result)):
				?>
					<option value="<?php echo $row['cid'];?>" unit="<?php echo $row['unit']?>"><?php echo $row['cname'];?></option>
				<?php endwhile?>
</select><br/>
مشترک با: <br/><strong id='broldcrs'></strong><br/>
<input type='button' id='bradd' value='اضافه' />
<input type='button' id='brdel' value='حذف' />
<input type='button' id='brcncl' value='انصراف' />
</div>	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type='text/javascript' src='js/combobox.ui.js'></script>
<script type="text/javascript" src="js/main.js"></script>

</body>
</html>
