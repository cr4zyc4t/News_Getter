/*!
 *   Core v0.1
 *   Author: vqt907
!*/
/*
    Custom script for HuiDeFa
----------------------------
*/
// $(function() {
    // //BAR CHART
//
// });


$(document).ready(function() {
  function loadYearData(year){
		$.post("/report/yearlyReport/"+year,{}, function(data) {
		  $('#yearly-price-chart').html('');
    	Morris.Bar({
        element: 'yearly-price-chart',
        resize: true,
        data: data,
		  	xkey: 'month',
		  	ykeys: ['total'],
		  	labels: ['Total Price'],
		  	barColors: function (row, series, type) {
		  		var data = this.data;
			    if (type === 'bar') {
			      	if ("totalMax" in data[row.x].src) return 'rgb(255,255,0)';
			      	if ("totalMin" in data[row.x].src) return 'rgb(0,255,0)';
			      	return 'rgb(160,160,160)';
			    } else {
			      	return '#FFF';
			    }
		  	},
        hideHover: 'auto'
	    });

	    $('#yearly-qty-chart').html('');
    	Morris.Bar({
        element: 'yearly-qty-chart',
        resize: true,
        data: data,
		  	xkey: 'month',
		  	ykeys: ['qty'],
		  	labels: ['Total Qty'],
		  	barColors: function (row, series, type) {
		  		var data = this.data;
			    if (type === 'bar') {
			      	if ("qtyMax" in data[row.x].src) return 'rgb(255,255,0)';
			      	if ("qtyMin" in data[row.x].src) return 'rgb(0,255,0)';
			      	return 'rgb(160,160,160)';
			    } else {
			      	return '#FFF';
			    }
		  	},
	        hideHover: 'auto'
	    });
    },"json");

    $(".yearlyTable .box-body").load("/report/yearlyTable/"+year,function(){
			// $("#selectYearForm").closest(".box").children(".overlay,.loading-img").remove();
		});

		$(".col-sm-12.yearlyTable2 .box-body").load("/report/yearlyDepartTable/"+year,function(){
			// $("#selectYearForm").closest(".box").children(".overlay,.loading-img").remove();
		});

		$(".col-sm-12.yearlyTableQty .box-body").load("/report/yearlyDepartTableQty/"+year,function(){
			$("#selectYearForm").closest(".box").children(".overlay,.loading-img").remove();
		});

		$(".col-sm-12.yearlySummary").load("/report/yearlySummary/"+year+"/1",function(){

    });


    $.post("/report/yearlyDepart/"+year,{}, function(data) {
      $('#yearly-depart-price-chart').html('');
    	Morris.Bar({
        element: 'yearly-depart-price-chart',
        resize: true,
        data: data,
		  	xkey: 'department',
		  	ykeys: ['total'],
		  	labels: ['Total Sales'],
	    	xLabelAngle: 30,
        hideHover: 'auto'
	    });

      $('#yearly-depart-qty-chart').html('');
    	Morris.Bar({
        element: 'yearly-depart-qty-chart',
        resize: true,
        data: data,
		  	xkey: 'department',
		  	ykeys: ['total_qty'],
		  	labels: ['Total Sales'],
	    	xLabelAngle: 30,
        hideHover: 'auto'
	    });
    },"json");

    $.post("/report/yearlyDepartPriceDetail/"+year,{}, function(response){
    	var chart_label = [];
    	for (var key in response[0]) {
    		if(key != 'month')
				chart_label.push(key);
			};
			$('#depart-price-chart').html('');
    	Morris.Bar({
		  	element: 'depart-price-chart',
		  	data: response,
		  	xkey: 'month',
		  	ykeys: chart_label,
		  	labels: chart_label,
		  	barColors: ['#4572A7','#AA4643','#89A54E','#71588F', '#4198AF', '#DB843D'],
		  	hideHover: 'auto'
			});
    },"json");

    $.post("/report/yearlyDepartQtyDetail/"+year,{}, function(response){
    	var chart_label = [];
    	for (var key in response[0]) {
    		if(key != 'month')
				chart_label.push(key);
			};
			$('#depart-qty-chart').html('');
    	Morris.Bar({
		  	element: 'depart-qty-chart',
		  	data: response,
		  	xkey: 'month',
		  	ykeys: chart_label,
		  	labels: chart_label,
		  	barColors: ['#4572A7','#AA4643','#89A54E','#71588F', '#4198AF', '#DB843D'],
		  	hideHover: 'auto'
			});
    },"json");
	};

	loadYearData($("#year_select").val());

	$("#selectYearForm").submit(function() {
		$("#selectYearForm").closest(".box").append("<div class=\"overlay\"></div><div class=\"loading-img\"></div>");

		var year = $("#year_select").val();
		loadYearData(year);
		$(".year-number").html(year);

		return false;
	});
	$(".year-number").html($("#year_select").val());
});


