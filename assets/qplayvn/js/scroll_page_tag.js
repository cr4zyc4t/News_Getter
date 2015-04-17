var lastScrollTop = 0;
var page_scroll=2;
var load=true;
$(window).scroll(function(event) {
	var st = $(this).scrollTop();
	if(page_scroll>2){
		if (load && $(window).scrollTop() + $(window).height() > $(document).height()-100) {
			load=true;
			loadMoreByTag(page_scroll);
		}
	}
});
function loadMoreByTag(page){
	var tag=$("#tag").val();
	if(load){
		load=false;
		$("#btn_loadmore").html("Đang tải dữ liệu ...");
		$.ajax({
			url:"/index/load-more-by-tag",
			type:"POST",
			data:{tag:tag,page:page},
			success:function(data){
				load=true;
				page_scroll++;
				$("#btn_loadmore").html("Xem thêm");
				$("#btn_loadmore").attr("onclick","loadMoreByTag("+(page+1)+")");
				//$(".row:last").after(data);
				var arr_col=$(".galcolumn");
				$("#example").append(data);
				var item=$("#example"+page+" > .item");
				var col=arr_col.size();
				for(var j=0;j<item.size();j++){
					$("#"+arr_col[j%col].id).append(item[j]);
					console.log(arr_col[j%col].id);
				}
				$("#example"+page).remove();
			}
		});
	}
}
