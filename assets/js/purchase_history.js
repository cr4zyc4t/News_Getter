function showPurchaseHistory (id)
{
  $("#selectMonthForm").data('customerid', id);
  $("#selectMonthForm").closest(".box").append("<div class=\"overlay\"></div><div class=\"loading-img\"></div>");

  loadPurchaseDataByMonth($("#selectMonth").val(), $("#selectYear").val(), id);
  loadPurchaseDataByYear($("#year_select").val(), id);
  loadPurchaseDataByPeriod($("#from_date").val(), $("#to_date").val(), id);

  $('#customerProfile').load("/customer/customerProfile/"+id,function(){});
  return false;
}

$(document).ready(function(){
  $("#selectMonthForm").submit(function() {
    try {
      $(".history").closest(".box").append("<div class=\"overlay\"></div><div class=\"loading-img\"></div>");

      var month = $("#selectMonth").val();
      var year = $("#selectYear").val();
      if (!month.length || !year.length)
      {
        $(".history").closest(".box").children(".overlay,.loading-img").remove();
        alert('Missing date!');
        return false;
      }
      var customerid = $(this).data('customerid');

      if (!customerid.length)
      {
        $(".history").closest(".box").children(".overlay,.loading-img").remove();
        alert('Please choose a customer');
        return false;
      }
      loadPurchaseDataByMonth(month, year, customerid);

    } catch (err) {
      console.log(err);
    }
    return false;
  });

  $("#selectYearForm").submit(function() {
    try {
      $(".history").closest(".box").append("<div class=\"overlay\"></div><div class=\"loading-img\"></div>");

      var year = $("#year_select").val();
      if (!year.length)
      {
        $(".history").closest(".box").children(".overlay,.loading-img").remove();
        alert('Missing date!');
        return false;
      }
      var customerid = $('#selectMonthForm').data('customerid');

      if (!customerid.length)
      {
        $(".history").closest(".box").children(".overlay,.loading-img").remove();
        alert('Please choose a customer');
        return false;
      }
      loadPurchaseDataByYear(year, customerid);
    } catch (err) {
      console.log(err);
    }
    return false;
  });

  $("#selectPeriodForm").submit(function() {
    try {
      $(".history").closest(".box").append("<div class=\"overlay\"></div><div class=\"loading-img\"></div>");

      var from = $("#from_date").val();
      var to = $("#to_date").val();
      if (!from.length || !to.length)
      {
        $(".history").closest(".box").children(".overlay,.loading-img").remove();
        alert('Missing date!');
        return false;
      }
      var date1 = new Date(from);
      var date2 = new Date(to);
      if (from > to)
      {
        $(".history").closest(".box").children(".overlay,.loading-img").remove();
        alert('Invalid dates!');
        return false;
      }
      var customerid = $('#selectMonthForm').data('customerid');

      if (!customerid.length)
      {
        $(".history").closest(".box").children(".overlay,.loading-img").remove();
        alert('Please choose a customer');
        return false;
      }
      loadPurchaseDataByPeriod(from, to, customerid);
    } catch (err) {
      console.log(err);
    }
    return false;
  });
});

function loadPurchaseDataByMonth (month, year, customerid)
{
  $("#purchaseHistory").load("/customer/loadPurchaseData/"+month+"/"+year+"/"+customerid,function(){
    $(".history").find(".overlay,.loading-img").remove();
  });
}

function loadPurchaseDataByYear (year, customerid)
{
  $("#purchaseHistoryByYear").load("/customer/loadPurchaseDataByYear/"+year+"/"+customerid,function(){
    $(".history").find(".overlay,.loading-img").remove();
  });
}

function loadPurchaseDataByPeriod (from, to, customerid)
{
  $("#purchaseHistoryByPeriod").load("/customer/loadPurchaseDataByPeriod/"+from+"/"+to+"/"+customerid,function(){
    $(".history").find(".overlay,.loading-img").remove();
  });
}
