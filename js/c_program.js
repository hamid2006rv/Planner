$(document).ready(function(){
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	$('#menu').menu({position:{my:"right top", at:"left top"}});
	
	$( "#class" ).combobox({
		select: function(event, ui){
			//alert(ui.item.value);
			$('#frm').submit()
		}
	});
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	show_wait()
	var clid=$('#class').val();
	$.post('php/action.php',{action:8, clid:clid},function(e){
		var data=JSON.parse(e);
	
		for(var r in data)
		{
			var pid=r;
			var day=data[r]['day'];
			var from=parseInt(data[r]['from']);
			var to=parseInt(data[r]['to']);
			var cname=data[r]['cname'];

			param={left:-1, top:-1, width:0, height:0};
			ger_coordination(day, from, to, param);
			
			var c=$('#crs').clone();
			$('body').append(c);
			c.css('top',param.top).css('left',param.left).css('width',param.width).css('height',param.height ).text(cname).addClass('section').attr('pid',pid).show();
			$('.section').unbind().bind('click',section_click).bind('mouseenter',section_mouseenetr).bind('mouseleave',section_mouseleave);
		}//end for pid
		
		hide_wait()
	});//end post
});
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
///////////////////////////////////////////////////////////////
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
/////////////////////////////////////////////////////////////////////
function section_click(e){
/*	 var pid=$(this).attr('pid');
	 $('#pidcrs').val(pid);
	 var p=$(this).position();
	
	 show_wait()
	 $.post('php/action.php',{action:2,pid:pid},function(e){
		 var data=JSON.parse(e);
		 $('#coursecrs').val(data['cid']).attr('disabled','disabled');
		 $('#daycrs').val(data['day']);
		 $('#fromcrs').val(data['from']);
		 $('#tocrs').val(data['to']);
		 $('#teachercrs').val(data['tid']).attr('disabled','disabled');
		 $('#classes').val(data['clid']);
		 $('#editcrs').show();
		 $('#deletecrs').show();
		 $('#addcrs').hide();
	
		 $('#crsdialog').css('top',p.top).css('left',p.left).show();
		 
		 hide_wait()
	 }).error(function(e){alert(e);});
*/	
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
///////////////////////////////////////////////////////////////////
function show_wait()
{	
	$('#overlay').show();
	var top=parseInt($(window).height())-parseInt($('#wait').height());
	var height=parseInt($(window).width())-parseInt($('#wait').width());
	$('#wait').css('top',top/2).css('left',height/2);
	$('#wait').show();
}
////////////////////////////////////////////////////////////////////
function hide_wait()
{
	$('#overlay').hide();
	$('#wait').hide();
}
//////////////////////////////////////////////////////////////////////
$(window).resize(function(){
	show_wait();
	$('td.cell').attr('free','true');
	$('div.section').remove();
	var clid=$('#class').val();
	$.post('php/action.php',{action:8, clid:clid},function(e){
		var data=JSON.parse(e);
	
		for(var r in data)
		{
			var pid=r;
			var day=data[r]['day'];
			var from=parseInt(data[r]['from']);
			var to=parseInt(data[r]['to']);
			var cname=data[r]['cname'];

			param={left:-1, top:-1, width:0, height:0};
			ger_coordination(day, from, to, param);
			
			var c=$('#crs').clone();
			$('body').append(c);
			c.css('top',param.top).css('left',param.left).css('width',param.width).css('height',param.height ).text(cname).addClass('section').attr('pid',pid).show();
			$('.section').unbind().bind('click',section_click).bind('mouseenter',section_mouseenetr).bind('mouseleave',section_mouseleave);
		}//end for pid
		
		hide_wait()
	});//end post
});