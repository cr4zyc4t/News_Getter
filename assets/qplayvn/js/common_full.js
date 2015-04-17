var load=true;
function high_light(id){
	if(load){
		load=false;
		$("#high_light_"+id).html("Xin chờ");
		$.ajax({
			type:"POST",
			url:"/index/high-light",
			data:{"id":id},
			success:function(data){
				load=true;
				$("#high_light_"+id).remove();
			}
		});
	}
}
var delete_ajax=true;
function delete_news(id){
	var r=confirm("Có thực sự muốn xóa?");
	if(r){
		if(delete_ajax){
			delete_ajax=false;
			$("#delete_"+id).html("Xin chờ");
			$.ajax({
				type:"POST",
				url:"/index/delete-news",
				data:{"id":id},
				success:function(data){
					delete_ajax=true;
					$("#div_delete_"+id).remove();
				}
			});
		}
	}
}