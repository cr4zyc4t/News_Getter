$(document).ready(function(){
	$(".swiper-container").css("width",$("#wapper").width());
	var mySwiper = new Swiper('.swiper-container',{
	    slidesPerView: 'auto',
	    watchActiveIndex:true,
		useCSS3Transforms:false,
	  });
});