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
		$data=get_alias($level, $term, $entry, $major);
		echo json_encode($data);
		exit();
	}
	/////////////////////////////////////////////////////
	if ($action==2)
	{
		$pid=$_POST['pid'];
		$cid=$_POST['cid'];
		$level=$_POST['level'];
		$term=$_POST['term'];
		$major=$_POST['major'];
		$entry=$_POST['entry'];
		save_alias($pid,$cid,$level, $term, $entry, $major);
		$result=mysql_query("select course.cname, course.unit, teacher.name,teacher.family from program, course, teacher where program.pid=$pid and course.cid=$cid and program.tid=teacher.tid");
		$row=mysql_fetch_assoc($result);
		$data=array();
		$data['cname']=$row['cname'];
		$data['unit']=$row['unit'];
		$data['name']=$row['name'];
		$data['family']=$row['family'];
		echo json_encode($data);
		exit();
	}
	////////////////////////////////////////////
	if($action==3)
	{
		$pid=$_POST['pid'];
		$level=$_POST['level'];
		$term=$_POST['term'];
		$major=$_POST['major'];
		$entry=$_POST['entry'];
		$sql="SELECT c_alias.cid AS alias_cid, mname, ename, course.cname, program.term, program.level FROM program, alias, course, course AS c_alias, major, entry WHERE program.pid =$pid AND program.pid = alias.pid AND program.cid = course.cid  AND alias.alias_cid = c_alias.cid AND program.mid = major.mid AND program.entryid = entry.eid AND alias.level =$level AND alias.term = '$term' AND alias.entryid =$entry AND alias.mid =$major";
		
		$result=mysql_query($sql);
		$row=mysql_fetch_assoc($result);
		$data['alias_cid']=$row['alias_cid'];
		$data['term']=$row['term'];
		$data['major']=$row['mname'];
		$data['entry']=$row['ename'];
		$data['level']=$row['level'];
		$data['cname']=$row['cname'];	
		echo json_encode($data);
		exit();
	}
	//////////////////////////////////////////////////////////
	if($action==4)
	{
		$pid=$_POST['pid'];
		$level=$_POST['level'];
		$term=$_POST['term'];
		$major=$_POST['major'];
		$entry=$_POST['entry'];
		$sql="delete from alias where pid=$pid and term='$term' and level=$level and mid=$major and entryid=$entry";
		$result=mysql_query($sql);
		echo $result;
		exit();
	}
}
//////////////////////////////////////////////////////////////////
function save_alias($pid,$cid,$level, $term, $entry, $major)
{
	$sql="insert into alias values ($pid, $cid, $level, '$term', $entry, $major)";	
	$result=mysql_query($sql);
	return $result;
}
///////////////////////////////////////////////////////////////////
function get_alias($level, $term, $entryid, $mid)
{
	$data=array();
	$sql="select * from alias, program, course where alias.level=$level and alias.term='$term' and alias.entryid=$entryid and alias.mid=$mid and alias.alias_cid=course.cid and alias.pid=program.pid";
	
	$result=mysql_query($sql);
	
	if($result)
	{
			while($row=mysql_fetch_assoc($result))
			{
				$data[$row['pid']]['day']=$row['day'];
				$data[$row['pid']]['from']=$row['from'];
				$data[$row['pid']]['to']=$row['to'];
				$data[$row['pid']]['cname']=$row['cname'];
			}
	}
	return $data;
}
?>