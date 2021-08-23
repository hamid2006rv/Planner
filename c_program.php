<?php 
	include('php/authority.php');
	$clid=-1;
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		if(isset($_POST['class']))
			$clid=$_POST['class'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <title>برنامه هفتگی</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="css/c_program.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.ui.all.css" />
</head>
<body dir="rtl" style='font-family:tahoma;fonte-zise:8px'>
<div id='crs' align='center' >hi every one</div>

<div id='overlay'></div>
		<div id='wait' align='center' valign='center'>
			<strong>در حال تماس با سرور, لطفا چند لحظه منتظر باشید...</strong>
			<img src='pic/loading.gif' alt='' width='20pt'>
		</div>

	<table style="width: 100%; height: 100%;" cellpadding="0" cellspacing="0">
		<tr style="height: 5%" bgcolor="#618CD1">
			<td  >
				<a href='./php/login.php'>خروج</a>
			</td>
			<td>
			<!---------------------------------------------------------------------------->
				<form id='frm' action='c_program.php' method='post'>
				<p style='font-family:tahoma;font-size:9pt'>
					کلاس:
					<select id='class' name='class'>
						<option value='-1'>[ انتخاب شود ]</option>
						<?php
						$result=mysql_query('select * from class order by clid');
						while($row=mysql_fetch_assoc($result)):	?>
							<option value="<?php echo $row['clid'];?>" <?php if($row['clid']==$clid):?> selected='selected' <?php endif;?> ><?php echo $row['clid'];?></option>
						<?php endwhile;?>
					</select>
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
				border-right:none;  height:19.15pt">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset">نام درس</span></b></p>
                </td>
                <td style="border-top:double windowtext 4.5pt; border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;  border-right:none;
					height:19.15pt">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-size:9.0pt;font-family:B_Compset">تعداد واحد</span><span  style="font-size:.0pt;font-family:&quot;BCompset&quot;"></span></b></p>
                </td>
                <td style="border-top:double windowtext 4.5pt;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;height:19.15pt">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset">رشته</span></b></p>
                </td>
				<td style="border-top:double windowtext 4.5pt;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;height:19.15pt">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset">مقطع</span></b></p>
                </td>
				<td style="border-top:double windowtext 4.5pt;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;height:19.15pt">
                    <p align="center" class="MsoNormal"  style="text-align:center">
                        <b>
                        <span  style="font-family:B_Compset">ورودی</span></b></p>
                </td>
            </tr>
		<?php
			$tcrslt=mysql_query("select * from program,course,major,entry where program.cid=course.cid and clid=$clid and program.mid=major.mid and program.entryid=entry.eid");
				while($row=mysql_fetch_assoc($tcrslt)):?>
					<tr pid='<?php echo $row['pid'];?>' class='section' bgcolor='#E4EFF8'>
					<td  width='120' height='31.7pt'><?php echo $row['cname'];?> </td>
					<td><?php echo $row['unit'];?></td>
					<td><?php echo $row['mname'];?></td>
					<td>
						<?php if($row['level']==1) echo 'کاردانی پیوسته';?>
                        <?php if($row['level']==2) echo 'کاردانی ناپیوسته';?>
						<?php if($row['level']==3) echo 'کارشناسی پیوسته';?>
						<?php if($row['level']==4) echo 'کارشناسی ناپیوسته';?>
						<?php if($row['level']==5) echo 'کارشناسی ارشد';?>
					</td>
					<td><?php echo $row['ename'];?></td>
					</tr>
				<?php endwhile;?>

        </table>
        </td>
                  </tr>
             </table>
            </td>
        </tr>
		</table>
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type='text/javascript' src='js/combobox.ui.js'></script>
<script type="text/javascript" src="js/c_program.js"></script>
</body>
</html>
