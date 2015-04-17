var lastScrollTop = 0;
var page_scroll=2;
var load=true;
var count_scroll=0;
var check_wp=navigator.userAgent.match(/Windows Phone/i);
if(!check_wp) check_wp=navigator.userAgent.match(/Wp/i);
$(window).scroll(function(event) {
	if(page_scroll>2){
		if (load && $(window).scrollTop() + $(window).height() > $(document).height()-100) {
			load=true;
			loadMore(page_scroll);
		}
	}
});
function loadMore(page){
	var category_name=$("#category_name").val();
	var category_id=$("#category_id").val();
	if(load){
		load=false;
		$("#btn_loadmore").html("Đang tải dữ liệu ...");
		$.ajax({
			url:"/index/load-more",
			type:"POST",
			data:{category_name:category_name,category_id:category_id,page:page},
			success:function(data){
				load=true;
				page_scroll++;
				$("#btn_loadmore").html("Xem thêm");
				$("#btn_loadmore").attr("onclick","loadMore("+(page+1)+")");
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
