$(document).ready(function(){
$('#menu').menu({position:{my:"right top", at:"left top"}});
$('#teachercrs').combobox();
$('#coursecrs').combobox();
$('#classes').combobox();
$('#brcrs').combobox();
///////////////////////////////////////////////////////////////////////////////////////////////////////
$('.brrow_select').mouseenter(mouse_enter).mouseleave(mouse_leave);
$('.br_add').click(add_click);
$('.br_remove').click(remove_click);
$('.alias').dblclick(alias_click);

////////////////////////////////////////////////////////////////////////////////////////////////////
	var level=$('#level').val();
	var term=$('#term').val();
	var major=$('#major').val();
	var entry=$('#entry').val();

	show_wait()
	$.post('php/action.php',{action:5, level:level, term:term, major:major, entry:entry},function(e){
		var data=JSON.parse(e);
		for(var pid in data)
		{
			var day=data[pid]['day'];
			var from=parseInt(data[pid]['from']);
			var to=parseInt(data[pid]['to']);
			var cname=data[pid]['cname'];

			param={left:-1, top:-1, width:0, height:0};
			ger_coordination(day, from, to, param);
			
			var c=$('#crs').clone();
			$('body').append(c);
			c.css('top',param.top).css('left',param.left).css('width',param.width).css('height',param.height ).text(cname).addClass('section').attr('pid',pid).show();
			$('.section').unbind().bind('dblclick',section_click).bind('mouseenter',section_mouseenetr).bind('mouseleave',section_mouseleave);

		}//end for pid
		load_alias(level, term, major, entry);
		$('.section').draggable({revert:true,cursor: "move"});
		$('#borrows_crs').droppable({
			accept:'.section',
			tolerance: "touch",
			hoverClass:'borrows_active',
			drop: function(event, ui){
				var crs=ui.draggable.text();
				var level=$('#level').find('option:selected').text();
				var term=$('#term').find('option:selected').text();
				var entry=$('#entry').find('option:selected').text();
				var major=$('#major').find('option:selected').text();
				var pid=ui.draggable.attr('pid');
				
				$.post('php/action.php',{action:12,pid:pid});
				
				var add=$('<img>')
					.css('width', '15px')
					.css('height', '15px')
					.css('display', 'none')
					.css('cursor','pointer')
					.attr('src','pic/add-icon.png')
					.attr('href','pic')
					.click(add_click);
				var remove=$('<img>')
					.css('width', '15px')
					.css('height', '15px')
					.css('display', 'none')
					.css('cursor','pointer')
					.attr('src','pic/Actions-window-close-icon.png')
					.attr('href','pic')
					.click(remove_click);
			
				var div=$('<div>')
				.css('background-color','yellow')
				.css('margin','2pt')
				.css('border','1pt solid black')
				.addClass('brrow_select')
				.append(remove)
				.append(add)
				.append(crs+' '+level+' ترم '+term+' ورودی '+entry+' رشته '+major)
				.mouseenter(function(){add.show();remove.show();})
				.mouseleave(function(){add.hide();remove.hide();});
				
				$(this).append(div);
				}
			});
		
		hide_wait()
	});//end post

	///////////////////////////////////////////////////////
	$('.datetime').change(function(){
		$('#cls_img_loading').show();
		var tmp=$('#classes').val();
		
		$('#classes').html("<option value='-1' selected='selected'>[ انتخاب شود ]</option>");
		var day=$('#daycrs').val();
		var from=$('#fromcrs').val();
		var to=$('#tocrs').val();
	   	var pid=$('#pidcrs').val();
	    $.post('php/action.php',{action:11, pid:pid, day:day, from: from, to:to},function(e){
			var data=JSON.parse(e);
			for(var i=0;i< data.length ;i++)
				{
					$('#classes').append("<option value='"+data[i]['clid']+"' >"+data[i]['clid']+"</option>");
				}
			if($('#classes').find("option[value='"+tmp+"']").length==1 )
				$('#classes').val(tmp);
			$('#cls_img_loading').hide();
			});
		
		
		});
	///////////////////////////////////////////////////////
	$('#addcrs').click(function(){
		
		var teacherid=$('#teachercrs').val();
		var courseid=$('#coursecrs').val();
		var teacher=$('#teachercrs').find('option[value='+teacherid+']').text();
		var course=$('#coursecrs').find('option[value='+courseid+']').text();
		var unit=$('#coursecrs').find('option[value='+courseid+']').attr('unit');
		var day=$('#daycrs').val();
		var from=parseInt($('#fromcrs').val());
		var to=parseInt($('#tocrs').val());
		var classid=$('#classes').val();
		
		if(teacher=='' || teacher== null)
		{
			alert('استاد نامشخص است');	
			return false;
		}
		if(course=='' || course== null)
		{
			alert('درس نامشخص است');
			return false;	
		}
		if(classid=='' || classid==null){
			alert('شماره کلاس اشتباه وارد شده است');
			return false;
			};
		
		if(from<=6 && to>6)
		{
			alert('امکان برگذاری کلاس بین ساعت نماز و ناهار وجود ندارد');
			return false;
		}
		if (teacherid==-1)
		{
			alert('استاد درس مشخص شود');
			return false;
		}
		if (courseid==-1)
		{
			alert('درس نامشخص است');
			return false;
		}
		if (classid==-1)
		{
			alert('کلاس نا مشخص است');
			return false;
		}
		

		if(from<=to)
		{
			var i=0;
			var level=$('#level').val();
			var term=$('#term').val();
			var major=$('#major').val();
			var entry=$('#entry').val();

			param={left:-1, top:-1, width:0, height:0};
			ger_coordination(day, from, to, param);			
			show_wait()
			$.post('php/action.php',{action:1, level:level, term:term , major:major , entry:entry, 
				cid: courseid, tid: teacherid, day : day, from: from, to:to, classid:classid},
				function(e){
					var data=JSON.parse(e);
				
					if(data['error']==0)
						{
							$('.section').draggable('destroy');
					    
							$('#crstable').append(  "<tr pid='"+data['id']+"' class='section' bgcolor='#E4EFF8'>"+
														"<td  width='120' "+ 
														"height='31.7pt'>"+course+"</td>"+
														"<td>"+unit+"</td><td>"+teacher+"</td></tr>");
							var c=$('#crs').clone();
							$('body').append(c);
							c.css('top',param.top).css('left',param.left).css('width',param.width).css('height',param.height ).text(course).addClass('section').attr('pid',data['id']).show();
							$('.section').unbind().bind('dblclick',section_click).bind('mouseenter',section_mouseenetr).bind('mouseleave',section_mouseleave);
							$('.section').draggable({revert:true,  cursor: "move"});	

							$('#crsdialog').hide();
						}
						else
							alert(data['err_message']);
				hide_wait()
			});

		}//end if
		else
		{
			alert('ساعت اشتباه وارد شده است');
		}
		
	});
	//////////////////////////////////////////////////////
	$('#deletecrs').click(function(){
		var c=confirm('درس حذف شود؟');
		
		if(c)
		{
			var pid=$('#pidcrs').val();
			$.post('php/action.php',{action:3,pid:pid},function(e){
				if(e=='ok'){
					$('#crsdialog').hide();
					$(".section[pid='"+pid+"']").remove();
					$(window).triggerHandler('resize');
				}
				else alert(e);
			});
			
		}
	});
	//////////////////////////////////////////////////////
	$('#editcrs').click(function(){
		
			if(validate_form()==false)
			{
				return false;

			}
			
			var pid=$('#pidcrs').val();
			var teacherid=$('#teachercrs').val();
			var day=$('#daycrs').val();
			var from=parseInt($('#fromcrs').val());
			var to=parseInt($('#tocrs').val());
			var classid=$('#classes').val();		
			
			$.post('php/action.php',{action:4,pid:pid, from:from, to:to, day:day, tid:teacherid, clid:classid},function(e){
				
				var data=JSON.parse(e);
					if(data['error']==0)
						{
							$('#crsdialog').hide();
							$("tr.section[pid='"+pid+"']").find('td').first().next().next()
							.text($('#teachercrs').find('option[value='+teacherid+']').text());
							$(window).triggerHandler('resize');
						}
						else
							alert(data['err_message']);
			});
	});
	//////////////////////////////////////////////////////
	$('#cancelcrs').click(function(){
		$('#crsdialog').hide();
	});
	//////////////////////////////////////////////////////
	$('.options:not(#major)').change(function(){
		$('#frm').submit();
	});
	/////////////////////////////////////////////////////
	$('#major').change(function(){
		var major=$(this).val();
		$('#level').html('');
		$('#entry').html('');
		$.post('php/action.php',{action:9, mid:major},function(e){
			try{
				var data=JSON.parse(e);
		    
				if(data['pkrd']=='1') $('#level').append("<option value='1'>کاردانی پیوسته</option>");
				if(data['nkrd']=='1') $('#level').append("<option value='2'>کاردانی ناپیوسته</option>");
				if(data['pkrsh']=='1') $('#level').append("<option value='3'>کارشناسی پیوسته</option>");
				if(data['nkrsh']=='1') $('#level').append("<option value='4'>کارشناسی ناپیوسته</option>");
				if(data['akrsh']=='1') $('#level').append("<option value='5'>کارشناسی ارشد</option>");
				$('#level').find('option').first().attr('selected','selected');
				
				for(var i=0;i<data['entry'].length;i++)
				{
					 $('#entry').append("<option value='"+data['entry'][i]['eid']+"'>"+data['entry'][i]['ename']+"</option>");
				}
				
				$('#frm').submit();
				}catch(ex){alert(ex.message);}
			});
		});
	/////////////////////////////////////////////////////
	$('.section').dblclick(section_click);
	$('.section').mouseenter(section_mouseenetr);
	$('.section').mouseleave(section_mouseleave);
	/////////////////////////////////////////////////////
	$('.cell').mouseenter(function(){
		$(this).css('background-color','#FF6666');
	}).mouseleave(function(){$(this).css('background-color','');}).click(function(){
		var p=$(this).position();
		var day=$(this).attr('day');
		var time=$(this).attr('time');
		$('#pidcrs').val(-1);
		$('#daycrs').val(day);
		$('#fromcrs').val(time);
		$('#tocrs').val(time);
		$('.datetime').triggerHandler('change');
		$('#coursecrs').val(-1).combobox('disable',false).combobox('refresh');
		$('#teachercrs').val(-1).combobox('disable',false).combobox('refresh');
		$('#classes').val(-1).combobox('disable',false).combobox('refresh');
		$('#editcrs').hide();
		$('#deletecrs').hide();
		$('#addcrs').show();
		var crsdialogwidth=parseInt($('#crsdialog').width());
		var crsdialogweight=parseInt($('#crsdialog').height());
		$('#crsdialog').css('top',p.top-crsdialogweight).css('left',p.left-crsdialogwidth).show();
	});
	////////////////////////////////////////////////////
	$('#brcncl').click(function(){
		$('#brdialog').hide();
		});
	////////////////////////////////////////////////////
	$('#bradd').click(function(){
		 var pid=$('#brpid').val();
		 var cid=$('#brcrs').val();
		 var level=$('#level').val();
		 var term=$('#term').val();
		 var major=$('#major').val();
		 var entry=$('#entry').val();
		 if(cid==null || cid=='')
		 {
			alert('نام درس صحیح نیست!');
			return false;	 
		 }
		 show_wait();
		 $.post('php/alias.php',
		 	{action:2, pid:pid, cid:cid,level:level, term:term, major:major, entry:entry},
		 	function(e){
					
					var data=JSON.parse(e);
					$('div.alias').remove();
					load_alias(level, term, major, entry);
					$('#crstable').append(  "<tr pid='"+pid+"' class='alias' bgcolor='#C0C'>"+
														"<td  width='120' "+ 
														"height='31.7pt'>"+data['cname']+"</td>"+
														"<td>"+data['unit']+"</td><td>"+data['name']+" "+data['family']+"</td></tr>");					
					$('#brdialog').hide();
					$(".brrow_select[pid='"+pid+"']").find('.br_remove').triggerHandler('click');
					hide_wait();
				});
		});
	////////////////////////////////////////////////////
	$('#brdel').click(function(){
		var c=confirm('درس مشترک حذف گردد؟');
		if(c)
			{
				var pid=$('#brpid').val();
				var term=$('#term').val();
				var level=$('#level').val();
				var entry=$('#entry').val();
				var major=$('#major').val();
				$.post('php/alias.php',{action:4, pid:pid, term:term, level:level, entry:entry, major:major},function(e){
					
					$(".alias[pid='"+pid+"']").remove();
					$('#brdialog').hide();
					});
			}
		});
	///////////////////////////////////////////////////
});
//////////////////////////////////////////////////////////////////////
$(window).resize(function(){
	
	var level=$('#level').val();
	var term=$('#term').val();
	var major=$('#major').val();
	var entry=$('#entry').val();
	$('td.cell').attr('free','true');
	$('div.section').remove();
	$('div.alias').remove();
	show_wait()
	$.post('php/action.php',{action:5, level:level, term:term, major:major, entry:entry},function(e){
		var data=JSON.parse(e);
		for(var pid in data)
		{
			var day=data[pid]['day'];
			var from=parseInt(data[pid]['from']);
			var to=parseInt(data[pid]['to']);
			var cname=data[pid]['cname'];

			param={left:-1, top:-1, width:0, height:0};
			ger_coordination(day, from, to, param);
			
			var c=$('#crs').clone();
			$('body').append(c);
			c.css('top',param.top).css('left',param.left).css('width',param.width).css('height',param.height ).text(cname).addClass('section').attr('pid',pid).show();
			//$('.section').draggable('destroy');
			$('.section').unbind().bind('dblclick',section_click).bind('mouseenter',section_mouseenetr).bind('mouseleave',section_mouseleave);
			//$('.section').draggable({revert:true,  cursor: "move"});

		}//end for pid
	load_alias(level,term,major,entry);
	hide_wait()
	});//end post	
});
/////////////////////////////////////////////////////////////////////
function section_click(e){
	
	 var pid=$(this).attr('pid');
	 $('#pidcrs').val(pid);
	 var p=$(this).position();
	 var h=0;
	 if($(this).is('div'))
		 h=parseInt($('#crsdialog').height());
		 
	 show_wait()
	 $.post('php/action.php',{action:2,pid:pid},function(e){
		 
		 var data=JSON.parse(e);
		 $('#coursecrs').val(data['cid']).combobox('disable',true).combobox('refresh');
		 $('#daycrs').val(data['day']);
		 $('#fromcrs').val(data['from']);
		 $('#tocrs').val(data['to']);
		 //$('.datetime').triggerHandler('change');
		 $('#teachercrs').val(data['tid'])/*.combobox('disable',true)*/.combobox('refresh');
		 $('#classes').val(data['clid'])/*.combobox('disable',true)*/.combobox('refresh');
		 $('#editcrs').show();
		 $('#deletecrs').show();
		 $('#addcrs').hide();

		 $('#crsdialog').css('top',p.top-h).css('left',p.left).show();

		 hide_wait()
	 }).error(function(e){alert(e);});
	
};
/////////////////////////////////////////////////////////////////
function section_mouseenetr(){
	var pid=$(this).attr('pid');
	$('body').find("[pid='"+pid+"']").each(function(){
											$(this).css('background-color','yellow');
	});
	}
///////////////////////////////////////////////////////////////
function section_mouseleave(){
	var pid=$(this).attr('pid');
	$('body').find("[pid='"+pid+"']").each(function(){
											$(this).css('background-color','#E4EFF8');
											});
	}
///////////////////////////////////////////////////////////////
function ger_coordination(day, from, to, param)
{
			var sec=0;
			if(is_free(day,from,to,1))
				sec=1;
			else
				if(is_free(day,from,to,2))
				sec=2;

			for(var i=from; i<=to; i++)
			{
				var td=$("td.cell[day='"+day+"'][time='"+i+"'][sec='"+sec+"']");
				if(td!=null && td.attr('free')=='true')
				{
					td.attr('free','false');
					param.width+=parseInt(td.css('width'));
					param.height=td.css('height');
					if(i==to)
					{
						var p=td.position();
						param.left=p.left;
						param.top=p.top;
					}
				}
			}					
}
//////////////////////////////////////////////////////////////////
function is_free(day,from,to,sec)
{
	for(var i=from; i<=to; i++)
	{
		var td=$("td.cell[day='"+day+"'][time='"+i+"'][sec='"+sec+"']");
		if(td==null || td.attr('free')=='false')
				return false;
	}
	return true;
}
////////////////////////////////////////////////////////////////
function show_wait()
{
	var top=parseInt($(window).height())-parseInt($('#wait').height());
	var left=parseInt($(window).width())-parseInt($('#wait').width());
	$('#wait').css('top',top/2).css('left',left/2).show();
	$('#overlay').show();

}
///////////////////////////////////////////////////////////////
function hide_wait()
{
	$('#wait').hide();
	$('#overlay').hide();

}
/////////////////////////////////////////////////////////////////
function validate_form()
{
		var teacherid=$('#teachercrs').val();
		var courseid=$('#coursecrs').val();
		var teacher=$('#teachercrs').find('option[value='+teacherid+']').text();
		var course=$('#coursecrs').find('option[value='+courseid+']').text();

		var from=parseInt($('#fromcrs').val());
		var to=parseInt($('#tocrs').val());
		var classid=$('#classes').val();
		
		if(teacher=='' || teacher== null)
		{
			alert('استاد نامشخص است');	
			return false;
		}
		if(course=='' || course== null)
		{
			alert('درس نامشخص است');
			return false;	
		}
		if(classid=='' || classid==null){
			alert('شماره کلاس اشتباه وارد شده است');
			return false;
			};
		
		if(from<=6 && to>6)
		{
			alert('امکان برگذاری کلاس بین ساعت نماز و ناهار وجود ندارد');
			return false;
		}
		if (teacherid==-1)
		{
			alert('استاد درس مشخص شود');
			return false;
		}
		if (courseid==-1)
		{
			alert('درس نامشخص است');
			return false;
		}
		if (classid==-1)
		{
			alert('کلاس نا مشخص است');
			return false;
		}
		if(from>to)
		{
			alert('بازه زمانی نادرست است');	
			return false;
		}
		return true;
}
///////////////////////////////////////////////////////////////////////////////
function load_alias(level, term, major, entry)
{
	$.post('php/alias.php',{action:1, level:level, term:term, major:major, entry:entry},function(e){
		
		var data=JSON.parse(e);
		for(var pid in data)
		{
			var day=data[pid]['day'];
			var from=parseInt(data[pid]['from']);
			var to=parseInt(data[pid]['to']);
			var alias_cname=data[pid]['cname'];
			
			param={left:-1, top:-1, width:0, height:0};
			ger_coordination(day, from, to, param);
			
			var c=$('#crs').clone();
			$('body').append(c);
			c.css('top',param.top).css('left',param.left).css('width',param.width).css('height',param.height ).text(alias_cname).addClass('alias').attr('pid',pid).css('background-color','#C0C').show();
			$('.alias').unbind().bind('dblclick',alias_click);
		}//end for pid
		return true;
	});//end post	
	
}
////////////////////////////////////////////////////////////////////////////////////////////////
function mouse_enter()
{
	$(this).find('.br_add').show();
	$(this).find('.br_remove').show();
}
//////////////////////////////////////////////////////////////////////////////////////////////
function mouse_leave()
{
		$(this).find('.br_add').hide();
		$(this).find('.br_remove').hide();
}
//////////////////////////////////////////////////////////////////////////////////////////
function add_click()
{
	var pid=$(this).parent().attr('pid');	
	var txt=$(this).parent().text();
	var top=parseInt($(this).offset().top);
	var left=parseInt($(this).offset().left);
	var width=parseInt($('#brdialog').width());
	$('#brcrs').combobox('disable',false);
	$('#broldcrs').text($(this).parent().text());
	$('#brpid').val($(this).parent().attr('pid'));
	$('#bradd').show();
	$('#brdel').hide();
	$('#brcncl').show();
	$('#brdialog').css('top',top+10).css('left',left-width-100).show();
}
//////////////////////////////////////////////////////////////////////////////////////////
function remove_click()
{
	var pid=$(this).parent().attr('pid');	
	$.post('php/action.php',{action:13,pid:pid});
	$(this).parent().remove();
}
////////////////////////////////////////////////////////////////////////////////////////
function alias_click(self)
{
	$('#broldcrs').text('');
	var p=$(this).position();
		var h=0;
	 	if($(this).is('div'))
		 	h=parseInt($('#brdialog').height());

	var pid=$(this).attr('pid');
	$('#brpid').val(pid);
	var term=$('#term').val();
	var level=$('#level').val();
	var entry=$('#entry').val();
	var major=$('#major').val();
	show_wait();
	$.post('php/alias.php',{action:3,pid:pid, term:term, level:level, entry:entry, major:major}, function(e){
		var data=JSON.parse(e);
		var level='';
		switch(data['level'])
		{
			case '1': level='کاردانی پیوسته'; break;
			case '2': level='کاردانی ناپیوسته'; break;
			case '3': level='کارشناسی پیوسته'; break;
			case '4': level='کارشناسی ناپیوسته'; break;
			case '5': level='کارشناسی ارشد'; break;	
		}
		
		$('#bradd').hide();
		$('#brdel').show();
		$('#brcncl').show();
		$('#brcrs').val(data['alias_cid']).combobox('disable',true).combobox('refresh');
		$('#broldcrs').text(data['cname']+' '+level+' ترم '+data['term']+' ورودی '+data['entry']+' رشته '+data['major']);
		$('#brdialog').css('top',p.top-h).css('left',p.left).show();	
		hide_wait();
		});
		
		
						

	
		
}