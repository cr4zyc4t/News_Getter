// /*!
 // *   Core v0.1
 // *   Author: vqt907
// !*/
// /*
    // Custom script for HuiDeFa
// ----------------------------
// */
// // $(function() {
    // // //BAR CHART
// //
// // });
//
//
$(document).ready(function() {
  loadPeriodData($("#from_date").val(), $("#to_date").val());

  $("#selectPeriodForm").submit(function() {
    try {
      $("#selectPeriodForm").closest(".box").append("<div class=\"overlay\"></div><div class=\"loading-img\"></div>");

      var from = $("#from_date").val();
      var to = $("#to_date").val();
      if (!from.length || !to.length)
      {
        $("#selectPeriodForm").closest(".box").children(".overlay,.loading-img").remove();
        alert('Missing date!');
      }
      var date1 = new Date(from);
      var date2 = new Date(to);
      if (from > to)
      {
        $("#selectPeriodForm").closest(".box").children(".overlay,.loading-img").remove();
        alert('Invalid dates!');
      }
      loadPeriodData(from, to);
    } catch (err) {
      console.log(err);
    }
    return false;
  });
});

  function loadPeriodData(from, to)
  {
    $.post("/custom_date_sales_report/periodReport/",{
      from: from,
      to: to
    }, function(data) {
      $('#period-price-chart').html('');
      Morris.Bar({
        element: 'period-price-chart',
        resize: true,
        data: data,
        xkey: 'day',
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

      $('#period-qty-chart').html('');
      Morris.Bar({
        element: 'period-qty-chart',
        resize: true,
        data: data,
        xkey: 'day',
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
    }, "json");

    $(".periodTable .box-body").load("/custom_date_sales_report/periodTable/"+from+"/"+to,function(){});
    // $(".col-sm-12.periodDepartTablePrice .box-body").load("/custom_date_sales_report/periodDepartTablePrice/"+from+"/"+to,function(){});

    $(".col-sm-12.periodTableQty .box-body").load("/custom_date_sales_report/periodDepartTableQty/"+from+"/"+to,function(){
      $("#selectPeriodForm").closest(".box").children(".overlay,.loading-img").remove();
    });

    $(".col-sm-12.periodTablePrice .box-body").load("/custom_date_sales_report/periodDepartTable/"+from+"/"+to,function(){
    });


    $(".col-sm-12.periodSummary").load("/custom_date_sales_report/periodSummary/"+from+"/"+to+"/1",function(){});


    $.post("/custom_date_sales_report/periodDepart",{
      from: from,
      to: to
    }, function(data) {
      $('#period-depart-price-chart').html('');
      Morris.Bar({
        element: 'period-depart-price-chart',
        resize: true,
        data: data,
        xkey: 'department',
        ykeys: ['total'],
        labels: ['Total Sales'],
        xLabelAngle: 30,
        hideHover: 'auto'
      });

      $('#period-depart-qty-chart').html('');
      Morris.Bar({
        element: 'period-depart-qty-chart',
        resize: true,
        data: data,
        xkey: 'department',
        ykeys: ['total_qty'],
        labels: ['Total Sales'],
        xLabelAngle: 30,
        hideHover: 'auto'
      });
    },"json");

    $.post("/custom_date_sales_report/periodDepartPriceDetail/",{
      from: from,
      to: to
    }, function(response){
      var chart_label = [];
      for (var key in response[0]) {
        if(key != 'day')
        chart_label.push(key);
      };

      $('#depart-price-chart').html('');
      Morris.Bar({
        element: 'depart-price-chart',
        data: response,
        xkey: 'day',
        ykeys: chart_label,
        labels: chart_label,
        barColors: ['#4572A7','#AA4643','#89A54E','#71588F', '#4198AF', '#DB843D'],
        hideHover: 'auto'
      });
    },"json");

    $.post("/custom_date_sales_report/periodDepartQtyDetail",{
      from: from,
      to: to
    }, function(response){
      var chart_label = [];
      for (var key in response[0]) {
        if(key != 'day')
        chart_label.push(key);
      };
      $('#depart-qty-chart').html('');
      Morris.Bar({
        element: 'depart-qty-chart',
        data: response,
        xkey: 'day',
        ykeys: chart_label,
        labels: chart_label,
        barColors: ['#4572A7','#AA4643','#89A54E','#71588F', '#4198AF', '#DB843D'],
        hideHover: 'auto'
      });
    },"json");
  }