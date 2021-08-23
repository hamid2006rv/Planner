<?php
include('init.php');

if(isset($_POST['action']))
{
	$action=$_POST['action'];
	if ($action==1)
	{
		$level=$_POST['level'];
		$term=$_POST['term'];
		$major=$_POST['major'];
		$entry=$_POST['entry'];
		$cid=$_POST['cid'];
		$tid=$_POST['tid'];
		$day=$_POST['day'];
		$from=$_POST['from'];
		$to=$_POST['to'];
		$classid=$_POST['classid'];
		
		$data=array('error'=>0);
		
		///////////////////////////////////////////
			$uid=$_SESSION['user_id'];
			$result=mysql_query("select dptid from major where major.mid=$major");
			$row=mysql_fetch_assoc($result);
			$dptid=$row['dptid'];
			$result=mysql_query("select * from dpt_user where dptid=$dptid and uid=$uid and I=1");
			if(mysql_num_rows($result)==0)
			{
				$data['error']=-1;
				$data['err_message']='مجوز اضافه کردن درس برای شما وجود ندارد!';
				echo json_encode($data);
				exit();	
			}
			/////////////////////////////////////////

		//check ostad
		$sql="select * from program where program.tid=$tid and day=$day and ((`from`<=$from and `to`>=$from) or (`from`<=$from and `to`>=$to) or (`from`>=$from and `to`<=$to) or (`from`<=$to and `to`>=$to))";
		
		$result=mysql_query($sql);
		if($result && mysql_num_rows($result)>0)
		{
			$data['error']=-1;
			$data['err_message']='تداخل با برنامه درسی استاد';
		}
		//check class
		$sql="select * from program where program.clid=$classid and day=$day and ((`from`<=$from and `to`>=$from) or (`from`<=$from and `to`>=$to) or (`from`>=$from and `to`<=$to) or (`from`<=$to and `to`>=$to))";
		$result=mysql_query($sql);
		if($result && mysql_num_rows($result)>0)
		{
			$data['error']=-1;
			$data['err_message']='کلاس پر است';
		}

		if($data['error']==0){
			$sql="insert into program values (null,$level,'$term',$entry,$cid,$tid,$day,$from,$to,$classid,$major)";
			$result=mysql_query($sql);
				if($result)
				{
					$data['id']= mysql_insert_id();
					mysql_query("update class set free=false where clid=$classid");
				}
			}
		
		 echo json_encode($data);
	}
	//////////////////////////////////////////////////
	if ($action==2)
	{
		$pid=$_POST['pid'];	
		$sql="select * from program, teacher, course where pid=$pid and program.cid=course.cid and program.tid=teacher.tid";
		$result=mysql_query($sql);
		if($result)
		{
			$row=mysql_fetch_assoc($result);
			$data=array();
			foreach($row as $key=>$value)
				$data[$key]=$value;
			echo json_encode($data);
		}
	}
	//////////////////////////////////////////////////
	if ($action==3)
		{
			$pid=$_POST['pid'];
			///////////////////////////////////////////
			$uid=$_SESSION['user_id'];
			$result=mysql_query("select dptid from program, major where major.mid=program.mid and pid=$pid");
			$row=mysql_fetch_assoc($result);
			$dptid=$row['dptid'];
			$result=mysql_query("select * from dpt_user where dptid=$dptid and uid=$uid and D=1");
			if(mysql_num_rows($result)==0)
			{
				echo 'مجوز حذف برای شما وجود ندارد!';
				exit();	
			}
			/////////////////////////////////////////
			
			$sql="delete from program where pid=$pid";
			$result=mysql_query($sql);
			if($result)
			{
				echo 'ok';
			}
			else
				echo -1;
		}
	/////////////////////////////////////////////////////
	if ($action==4)
	{
		$pid=$_POST['pid'];
		$from=$_POST['from'];
		$to=$_POST['to'];
		$day=$_POST['day'];
		$tid=$_POST['tid'];
		$clid=$_POST['clid'];
		$result=mysql_query("select * from program where pid=$pid");
		$row=mysql_fetch_assoc($result);
		
		$term=$row['term'];
		$major=$row['mid'];
		$level=$row['level'];
		$entry=$row['entryid'];
	
		$data=array('error'=>0);
			///////////////////////////////////////////
			$uid=$_SESSION['user_id'];
			$result=mysql_query("select dptid from program, major where major.mid=program.mid and pid=$pid");
			$row=mysql_fetch_assoc($result);
			$dptid=$row['dptid'];
			$result=mysql_query("select * from dpt_user where dptid=$dptid and uid=$uid and U=1");
			if(mysql_num_rows($result)==0)
			{
				$data['error']=-1;
				$data['err_message']='مجوز ویرایش برای شما وجود ندارد!';
				echo json_encode($data);
				exit();
			}
			/////////////////////////////////////////
		

		//check ostad
		$sql="select * from program where program.pid<>$pid and program.tid=$tid and day=$day and ((`from`<=$from and `to`>=$from) or (`from`<=$from and `to`>=$to) or (`from`>=$from and `to`<=$to) or (`from`<=$to and `to`>=$to))";
		
		$result=mysql_query($sql);
		if($result && mysql_num_rows($result)>0)
		{
			$data['error']=-1;
			$data['err_message']='تداخل با برنامه درسی استاد';
		}
		//check class
		$sql="select * from program where program.pid<>$pid and program.clid=$clid and day=$day and ((`from`<=$from and `to`>=$from) or (`from`<=$from and `to`>=$to) or (`from`>=$from and `to`<=$to) or (`from`<=$to and `to`>=$to))";
		$result=mysql_query($sql);
		if($result && mysql_num_rows($result)>0)
		{
			$data['error']=-1;
			$data['err_message']='کلاس پر است';
		}
		
		if($data['error']==0){
			$sql="update program set `from`=$from, `to`=$to, day=$day, tid=$tid, clid=$clid where pid=$pid";
			$result=mysql_query($sql);
			if($result)
			{
			
			}else
			$data['error']==-1;
		}
		echo json_encode($data);
	}
	/////////////////////////////////////////////////////
	if($action==5)
	{
		$level=$_POST['level'];
		$term=$_POST['term'];
		$entry=$_POST['entry'];
		$major=$_POST['major'];
		$sql="select * from program, course where level='$level' and term='$term' and mid='$major' and entryid='$entry' and program.cid=course.cid";
		$result=mysql_query($sql);
		$data=array();
		while($row=mysql_fetch_assoc($result))
		{
			$data[$row['pid']]=array();
			$data[$row['pid']]['day']=$row['day'];
			$data[$row['pid']]['from']=$row['from'];
			$data[$row['pid']]['to']=$row['to'];
			$data[$row['pid']]['cname']=$row['cname'];
		}
		echo json_encode($data);
	}
	///////////////////////////////////////////////////
	if ($action==6)
	{
		$tid=$_POST['tid'];
		$sql="select * from program,course where  program.cid=course.cid and tid=$tid";
		$result=mysql_query($sql);
		if($result)
		{
			$data=array();
			while($row=mysql_fetch_assoc($result))
			{
				$data[$row['pid']]['cname']=$row['cname'];
				$data[$row['pid']]['day']=$row['day'];
				$data[$row['pid']]['from']=$row['from'];
				$data[$row['pid']]['to']=$row['to'];
			}
			echo json_encode($data);
		}
	}
	//////////////////////////////////////////////////
	if ($action==7)
	{
		$sql="select * from course";
		$result=mysql_query($sql);
		if($result)
		{
			$data=array();
			while($row=mysql_fetch_assoc($result))
			{
				$crs=array();
				$crs['cid']=$row['cid'];
				$crs['cname']=$row['cname'];
				$crs['unit']=$row['unit'];
				array_push($data, $crs);
			}
			echo json_encode($data);
		}
	}
	///////////////////////////////////////////////////
	if ($action==8)
	{
		$clid=$_POST['clid'];
		$sql="select * from program,course where  program.cid=course.cid and clid=$clid";
		$result=mysql_query($sql);
		if($result)
		{
			$data=array();
			while($row=mysql_fetch_assoc($result))
			{
				$data[$row['pid']]['cname']=$row['cname'];
				$data[$row['pid']]['day']=$row['day'];
				$data[$row['pid']]['from']=$row['from'];
				$data[$row['pid']]['to']=$row['to'];
			}
			echo json_encode($data);
		}
	}
	///////////////////////////////////////////////////////////////////////////////
	if ($action==9)
	{
		$mid=$_POST['mid'];
		$sql="select * from major where mid=$mid";
		
		$result=mysql_query($sql);
		$data=array('error'=>0);
		if($result)
		{
			
			$row=mysql_fetch_assoc($result);
				$data['std_num']=$row['std_num'];			
				$data['nkrd']=$row['kardani_n'];
				$data['pkrd']=$row['kardani_p'];
				$data['pkrsh']=$row['karshenasi_p'];
				$data['nkrsh']=$row['karshenasi_n'];
				$data['akrsh']=$row['karshenasi_a'];
				$ent=mysql_query("select * from major_entry, entry where entry.eid=major_entry.eid and mid=$mid");
				$ed=array();
				while($er=mysql_fetch_assoc($ent))
				{
					$x=array();
					$x['id']='#er_'.$er['eid'];
					$x['eid']=$er['eid'];
					$x['ename']=$er['ename'];
					$ed[]=$x;
				}
				$data['entry']=$ed;

		}
		else
			$data['error']=-1;
		echo json_encode($data);
	}
	//////////////////////////////////////////////////
	if ($action==10)
	{
		$dptid=$_POST['dptid'];
		$sql="select * from major where dptid=$dptid";
		
		$result=mysql_query($sql);
		if($result)
		{
			$data=array();
			while($row=mysql_fetch_assoc($result))
			{
				$crs=array();
				$crs['mid']=$row['mid'];
				$crs['mname']=$row['mname'];
				array_push($data, $crs);
			}
			echo json_encode($data);
		}
	}
	//////////////////////////////////////////////////
	if ($action==11)
	{
		$day=$_POST['day'];
		$from=$_POST['from'];
		$to=$_POST['to'];
		$pid=$_POST['pid'];
		$sql="select clid from class where clid not in(
		select clid from program where day=$day and ((`from`<=$from and `to`>=$from) or (`from`<=$from and `to`>=$to) or (`from`>=$from and `to`<=$to) or (`from`<=$to and `to`>=$to))) 
		union
		select clid from program where pid=$pid	";
		$result=mysql_query($sql);
		if($result)
		{
			$data=array();
			while($row=mysql_fetch_assoc($result))
			{
				$class=array();
				$class['clid']=$row['clid'];
				array_push($data, $class);
			}
			echo json_encode($data);
		}	
	}
	/////////////////////////////////////////////////////////////
	if($action==12)
	{
	
		if(!isset($_SESSION['br_list']))
			$_SESSION['br_list']=array();
		$pid=$_POST['pid'];		
		$_SESSION['br_list'][]=$pid;


	}
	////////////////////////////////////////////////////////////
	if($action==13)
	{
		$pid=$_POST['pid'];
		if(isset($_SESSION['br_list']))
		{
			$k = array_search($pid,$_SESSION['br_list']);
			if($k!==false)
    			unset($_SESSION['br_list'][$k]);
		}

	}
	////////////////////////////////////////////////////////////

}

?>