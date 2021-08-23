$(document).ready(function(){

	$('#change_pass').click(function(){
		$('#change_passdiv').fadeIn();
		return false;
			});
	//////////////////////////////////////////////////////////////
	$('#dpt').change(function(){
		var dptid=$(this).val();
		
		$.post('php/action.php',{action:10,dptid:dptid},function(e){
			var data=JSON.parse(e);
			$('#major').html('');
			for(var i=0; i<data.length; i++)
				$('#major').append("<option value='"+data[i]['mid']+"'>"+data[i]['mname']+"</option>");
			$('#major').triggerHandler('change');
			});
		});
	//////////////////////////////////////////////////////////	
	$('#major').change(function(){
		var mid=$(this).val();
				
		$.post('php/action.php',{action:9,mid:mid},function(e){
			
			var data=JSON.parse(e);
			
			if(data['error']==0)
			{
				$(':checkbox').prop('checked',false);
				$('#teacher').val(data['tid']);
				$('#stdnum').val(data['std_num']);
				$('#did').val(data['dptid']);
				if(data['pkrd']==1) $('#pkrd').prop('checked',true);
				if(data['nkrd']==1) $('#nkrd').prop('checked',true);
				if(data['pkrsh']==1) $('#pkrsh').prop('checked',true);
				if(data['nkrsh']==1) $('#nkrsh').prop('checked',true);
				if(data['akrsh']==1) $('#akrsh').prop('checked',true);
				
				for(var i=0;i<data['entry'].length;i++)
				{
					$(data['entry'][i]['id']).prop('checked',true);
				}

			}
		});
	});

});